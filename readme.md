
# Arraytics Simple Form Plugin

A simple form plugin to collect data through the form also showing data in a table. The plugin provides two different shortcodes for displaying a submission form and report table. All submissions data are available for logged in users.

There are also a Admin Page named 'All Reports' where all records are shown in a Data Table. There are a Search Option to the top right section. Also any entry can be deleted by hovering an item. A confimation Alert will shown during the Delation.

Let's describe the Features below:


## The Form's Features

- Empty Field not allowed, shows Error Message
- Phone Number Validaion with Fixed Digits, prepend country code automatically
- Email address Validation with proper format
- There are some Numeric fields that don't take string
- User can't submit the form multiple time in a day, tracked by Cookies
- The Form works with Ajax, no page loading required

## The Backend Features

- Sanitize user inputs carefully
- Automatically Track User IP
- Automatically save the submission date
- Report Page is Restricted for 'Editor' & 'Administrator'
- Data Table for 'Administrator' for Searching, Viewing & Deleting items.

## Using Shortcodes

- `arraytics-simple-form` for showing the Form
- `arraytics-report-page` for showing the Report for Loggedin, Editor & Administrator users.

## Setup The Project to your Machine

- Download the Full project from Google Drive.
- Extract it, all files goes to your root directory 
- Find the 'sql' file inside the 'DB' directory then upload it to your 'MySQL' DB.
- Configure the 'config.php' file according to your configuration.
    
