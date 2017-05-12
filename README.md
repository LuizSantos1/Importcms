# Overview
This small code snippet adds a function in Magento 2 that helps you import CMS pages from CSV file. The CSV file can be exported from Magento 1. It is helpful to migrate CMS Pages from Magento 1 to Magento 2. 

# CSV file structure
You can export CSV file from Magento 1 using the structure as this file: http://demo.tigren.com/sample_cms_pages.csv
You may look for a free extension for exporting CMS pages in Magento 1.

# Installation
* Copy module source to app/code folder
* Refresh Magento cache
* Run this command: php bin/magento setup:upgrade

# Usage
* From the backend, go to Content > Import CMS Pages and run importing with CSV file
* Copy wyiwyg images from your Magento 1 to Magento 2 (copied from media/wysiwyg to pub/media/wysiwyg folder)

# Supported version
We tested the module with Magento 2 up to 2.1.6

# Support
Please note that this module is currently at a very early version. It is not ready for using in production site but a reference for your development. Please be careful and make sure you edit the code properly before using. 
For any questions, please do not hesitate to email us at support@tigren.com or visit our website: https://www.tigren.com
