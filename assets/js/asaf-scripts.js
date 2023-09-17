(function ($) {
    $(document).ready(function () {
        $('.asfp-form-area #submitBtn').on('click', function (event) {
            event.preventDefault(); // Prevent the default form submit.            

            // Custom function for displaying message
            function add_message(message, type) {
                let html = "<div class='alert alert-" + type + "'>" + message + "</div>";
                $(".asfp-confirmation-message").empty().append(html);
                $(".asfp-confirmation-message").fadeIn();
            }

            // Count Words
            function asfp_count_words(words) {
                let entireWords = words.split(' ');
                return entireWords.length;
            }

            // Checking Email
            function asfp_check_email(email) {
                let emailPattern = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;      // Only email allowed.
                return emailPattern.test(email);
            }

            // Checking Mobile Number
            function asfp_check_mobile_number(mobileNumber) {
                let mobileNumberPattern = /^[0-9]{10}$/;            // Only (0 - 9) and 10 digits are allowed.
                return mobileNumberPattern.test(mobileNumber);
            }

            // Checking Text Only
            function asfp_check_text_only(text) {
                let onlyTextPattern = /^[A-Za-z]*$/;                // Only (A - Z) and (a - z) are allowed.
                return onlyTextPattern.test(text);
            }

            // Function to check if a cookie exists and handle form submission
            function asfpCheckCookie() {
                // Set the desired timezone to UTC+6
                const desiredTimeZone = 'Asia/Dhaka'; // Dhaka, Bangladesh is UTC+6

                // Create an instance of the Intl.DateTimeFormat with the desired timezone
                const formatter = new Intl.DateTimeFormat('en-US', { timeZone: desiredTimeZone });
                const cookieName = "asafForm";
                const now = new Date().getTime();
                const lastSubmissionTimestamp = parseInt(Cookies.get(cookieName));

                if (!isNaN(lastSubmissionTimestamp)) {
                    // Calculate the time difference in hours
                    const hoursSinceLastSubmission = (now - lastSubmissionTimestamp) / 1000 / 60 / 60;
                    // If less than 24 hours have passed, prevent submission
                    if (hoursSinceLastSubmission < 24) {
                        return false;
                    }
                }
                // Set a new cookie with the current timestamp
                Cookies.set(cookieName, now, { expires: 1 }); // Cookie expires in 1 day (24 hours)

                return true;
            }

            // Getting values from the form
            let nonce = $("#_wpnonce").val();
            let asfpAmount = $("#asfp-amount").val();
            let asfpBuyer = $("#asfp-buyer").val();
            let asfpReceiptId = $("#asfp-receipt-id").val();
            let asfpItems = $("#asfp-items").val();
            let asfpBuyerEmail = $("#asfp-buyer-email").val();
            let asfpCity = $("#asfp-city").val();
            let asfpPhone = $("#asfp-phone").val();
            let asfpEntryBy = $("#asfp-entry-by").val();
            let asfpNote = $("#asfp-note").val();
            console.log(nonce, asfpAmount, asfpBuyer, asfpReceiptId, asfpItems, asfpBuyerEmail, asfpCity, asfpPhone, asfpEntryBy, asfpNote);
            if (!asfpAmount || !asfpBuyer || !asfpReceiptId || !asfpItems || !asfpBuyerEmail || !asfpCity || !asfpPhone || !asfpEntryBy || !asfpNote) {
                add_message('Sorry, Empty field not allowed!', 'danger');
                console.log('empty');
            } else {
                if (!$.isNumeric(asfpAmount)) {
                    add_message('Sorry, Only Numeric Value allowed for the Amount field.', 'warning');
                } else if (!asfp_check_text_only(asfpReceiptId)) {
                    add_message('Sorry, Only Text allowed for the Receipt Id field.', 'warning');
                } else if (asfp_count_words(asfpBuyer) > 20) {
                    add_message('Sorry, Buyer field\'s length can not be more than 20 words. You have given ' + asfp_count_words(asfpBuyer) + ' words.', 'warning');
                } else if (!asfp_check_email(asfpBuyerEmail)) {
                    add_message('Sorry, Buyer Email is not valid. Please check your input.', 'warning');
                } else if (asfp_count_words(asfpNote) > 30) {
                    add_message('Sorry, Note field\'s length can not be more than 30 words. You have given ' + asfp_count_words(asfpNote) + ' words.', 'warning');
                } else if (!asfp_check_mobile_number(asfpPhone)) {
                    add_message('Sorry, Phone number is not valid. Only (0 - 9) and 10 digits are allowed. Ex: 1911120583', 'warning');
                } else if (!asfpCheckCookie()) {
                    add_message('Sorry, You can only submit once every 24 hours.', 'warning');
                } else {
                    add_message('Sending request..', 'success');
                    let prependedPhoneNumber = '880' + asfpPhone;
                    let data = new FormData();
                    data.append('action', 'asfp_form');
                    data.append('nonce', nonce);
                    data.append('asfp_amount', asfpAmount);
                    data.append('asfp_buyer', asfpBuyer);
                    data.append('asfp_receipt_id', asfpReceiptId);
                    data.append('asfp_items', asfpItems);
                    data.append('asfp_buyer_email', asfpBuyerEmail);
                    data.append('asfp_city', asfpCity);
                    data.append('asfp_phone', prependedPhoneNumber);
                    data.append('asfp_entry_by', asfpEntryBy);
                    data.append('asfp_note', asfpNote);
                    $.ajax({
                        url: asfp_data_obj.ajax_url,
                        type: 'POST',
                        dataType: 'json',
                        data: data,
                        nonce: nonce,
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function (data) {
                            console.log(data);
                            if (data.response !== 'success') {
                                add_message(data.message, 'danger');
                            }
                            else {
                                add_message(data.message, 'success');
                            };
                        }
                    })

                        // Error 
                        .fail(function () {
                            add_message(data.message ? data.message : 'Sorry! Something went wrong.', 'danger');
                        })
                }   // End condition while everything okay.
            }       // End condition while no field is empty.

        });
    });
})(jQuery);