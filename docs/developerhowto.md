# Boise State uPay Gravity Forms Extension for LSAMP

## Overview

Touchnet uPay is the service designated by the university for ecommerce. Any WordPress sites that require ecommerce need to integrate with Touchnet. OIT has created a plugin template so that each site requiring ecommerce can use a custom-built plugin configured and supported by OIT.

GravityForms is the product OIT provides to all site admins to easily create web forms. These forms live in subsites on secureforms.boisestate.edu. To allow university departments to implement ecommerce in their WordPress sites, we combine WordPress, Gravity Forms and OIT's Touchnet plugin.

Throughout the process described here, you'll need to communicate with the Site Administrator requesting the plugin. They will be able to provide requirements for the application, and information specific to their uPay site.

## Purpose

This document describes the process for creating an ecommerce application based on WordPress, Gravity Forms and OIT's Touchnet plugin template.

## Prerequisites
This procedure presumes that you have knowledge of WordPress, Gravity Forms, PHP and GitHub.

## Procedure

### 1. Create a new version of the OIT Touchnet plugin
Base your plugin on any existing OIT Touchnet plugin. (Here(https://github.com/OITWPsupport/boise-state-uPay-Gravity-Forms-Extension-for-LSAMP) is an example.) You'll need to update some parts of the code to assure that this plugin is unique. (WordPress will throw an error if 2 plugins use the same class names or shortcodes, for example.)

1. Download the source code of an OIT Touchnet plugin from [OITWPsupport @ GitHub](https://github.com/OITWPsupport)
1. Copy the files into a new GitHub repository.
2. Update the class name in updater.php to assure that it's unique:  
`class Boise_State_[plugin_name]_Updater {`
3. Update the plugin's main PHP file:
	1. change this line to reference the new class name:  
		`if( ! class_exists( 'Boise_State_[plugin_name]_Updater' ) ){`
	1. change this line to reference GitHub repository you created:  
		`$updater->set_repository( 'boise-state-[plugin_name]' );`
	1. change the shortcode so that it's unique:  
		`add_shortcode('[shortcode_string]', 'createForm_[plugin_name]');`
6. Push an initial commit of the code to GitHub.
7. Create an initial release in GitHub.
	
See [Deploying Custom Plugins](https://sites.google.com/a/boisestate.edu/wordpress-support/plugins/boise-state-custom-plugins/deploying-custom-plugins)


### 2. Create a Forwarding Page
The Forwarding Page will use the plugin you created above to send the user and transaction information to Touchnet. This is a simple page that contains only the plugin's shortcode. The shortcode will cause the page to automatically forward the user to Touchnet without seeing the Forwarding Page.

1. Create a new page on the appropriate secureforms subsite. 
2. Add the shortcode to the page, including any necessary parameters. This plugin accepts as shortcode parameters some configuration information required by Touchnet:
	- URL
		- **Shortcode parameter:** `upay_url`
		- **Default value:** `https://secure.touchnet.com/C20444_upay/web/index.jsp`
	- Site ID
		- **Shortcode parameter:** `upay_site_id`
		- **Default value:** `-1`
	- Passed Amount Validation Key
		- **Shortcode parameter:** `passed_amount_validation_key`
		- **Default value:** [empty string]
		- **Description:** This parameter holds the value of the "Passed Amount Validation Key" discussed in the Touchnet User's Guide. Create your key (a unique alphanumeric string 30 characters or less) and enter it in the "Passed Amount Validation Key" field in the uPay Site's Payment Settings page.  
  
Here is an example use of the shortcode as used in a Forwarding Page: `[UPAYFORM upay_site_id="129" passed_amount_validation_key="gvawCFiwh43982Cc" upay_url="https://secure.touchnet.com/C20444_upay/web/index.jsp"]`

Publish the page and note its URL.

### 3. Create the Gravity Form
The user will begin the ecommerce transaction on a web form on the department's secureforms subsite. That form will submit to the Forwarding Page, which will send the user (and the user's transaction info) to Touchnet. In this step, you'll create the form and point it at the Forwarding Page. **The Gravity Form must not include fields for payment information.** Users will enter payment information only after they arrive at Touchnet.

1. Create the form. Gravity Forms makes this easy, and most Site Admins can create their own forms. Work with the Site Admin as necessary to implement a web form on secureforms for their ecommerce need.
1. Configure the form to submit to the Forwarding Page. (**Note:** the Forwarding Page and the OIT Touchnet plugin should live on secureforms.boisestate.edu).
	1. Open the Gravity Forms edit form page.
	2. Click Form Settings->Confirmations->Edit.
	3. Select Confirmation Type = Redirect.
	4. In the Redirect URL field, add the URL the Forwarding Page.
	5. Create a Redirect Query String. Click the drop-down icon at the top right of the textarea to view the form fields available. By selecting fields here, compose a query string in the format "key1={value1}&key2={value2}..." You'll provide the key names and the formatting (ampersands and equals sign). Make sure your key names match the relevant variable names in your plugin's main PHP file. (The query string parameters you designate here will be available to the plugin's main PHP file. This is is probably how you'll calculate the amount due before posting to Touchnet.)
	6. Click the `Save Confirmation` button.  

### 4. Configure and test the plugin
1. Download the zip file of your initial release from GitHub and install on test.boisestate.edu to complete your testing.
2. Increment the version and create a new release on GitHub to test the test site's ability to automatically detect an available update.
1. Download the zip file and install it on secureforms. Activate it on the appropriate secureforms subsite for testing.
2. Work with the Site Admin to configure their secureform and Forwarding Page to submit test transactions to a uPay test site, and verify the results.
