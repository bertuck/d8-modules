AW Glossary module:
----------------------
Requires - Drupal 8
Kenni Bertucat


Overview:
--------
This module permit to manage glossary in the website.
It will automatically add a view page, a vocabulary,
a field settings for each text_area with html
to enable the glossary mode, and a configuration
form to set the title and the description of the page.

Requirements:
-------------
* Disable `Convert line breaks into HTML (i.e. <br> and <p>)` in config/content/formats ckeditor configuration


Installation:
------------
1. Place this module directory in your modules folder (this will
   usually be "modules/" for Drupal 8).
2. Go to Manage -> Extend to enable the module.
3. And then you have access to the configuration routes :
    - /admin/configuration/glossary
