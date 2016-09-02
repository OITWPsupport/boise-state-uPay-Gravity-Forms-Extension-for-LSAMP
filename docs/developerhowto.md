Overview

Touchnet uPay is the service designated by the university for ecommerce. Any WordPress sites that require ecommerce need to integrate with Touchnet. OIT has created a plugin template so that each site requiring ecommerce can use a custom-built plugin configured and supported by OIT.

GravityForms is the product OIT provides to all site admins to easily create web forms. These forms live in subsites on secureforms.boisestate.edu. To allow university departments to implement ecommerce in their WordPress sites, we combine WordPress, GravityForms and OIT's Touchnet plugin template.

Purpose

This document describes the process for creating a plugin based on OIT's Touchnet plugin template.

1. Create a new version of the OIT Touchnet plugin.
Base the new plugin on any existing OIT Touchnet plugin. ((See [OITWPsupport @ GitHub](https://github.com/OITWPsupport).) Copy the files into a new GitHub repository and update them all to replace references to the previous plugin.

	- See [Deploying Custom Plugins](https://sites.google.com/a/boisestate.edu/wordpress-support/home/boise-state-custom-plugins/deploying-custom-plugins)
	- Update the class name in updater.php to assure that it's unique. All our plugins will use this class, and WP will throw an error if the 
 name isn't unique.
	- Update the main PHP file to reference the new class name...
  ...if( ! class_exists( 'Boise_State_[plugin_name]_Updater' ) ){...
  and the Github repository you created to hold the plugin code:
  ...$updater->set_repository( 'boise-state-[plugin_name]' );...
	- Update the shortcode so that it's unique
	- Push an initial commit of the code to Github
	- Create an initial release in Github

1. Create a Forwarding Page
The Forwarding Page will use the plugin you created above to send the user and transaction information to Touchnet. This is a simple page that contains only the plugin's shortcode. The shortcode will cause the page to automatically forward the user to Touchnet without seeing the Forwarding Page.
	- Create it on the appropriate secureforms subsite. Include the shortcode with any necessary parameters. 

1. Configure the GravityForm
The user will begin the ecommerce transaction on a web form on the department's secureforms subsite. That form will submit to a Forwarding Page that will route the user to Touchnet, posting information about the transaction and amount owed.

	1. Create the form
	GravityForms makes this easy, and most Site Admins can create their own forms. Work with them as necessary to implement a web form on secureforms for their ecommerce need.
	1. Configure the form to submit to the Forwarding Page
	NOTE: the Forwarding Page (and the OIT plugin) should live on secureforms.boisestate.edu.
		- Form Settings->Confirmations. 
			- Confirmation Type = Redirect.
			- Redirect URL = the URL of the Forwarding Page.
			- Redirect Query String: Click the drop-down icon at the top right of this textarea to view the form fields available. By selecting fields here, 
compose a query string in the format "key1={value1}&key2={value2}..." You'll provide the key names and the formatting (ampersands and equals sign).
		- Save Confirmation.  

1. Configuring and Testing
	- Download the zip file and install on test.boisestate.edu to complete your testing.
	- Download the zip file and install it on secureforms. Activate it on the appropriate secureforms subsite for production.
	- Increment the version and create a new release on Github to test the production site's ability to automatically detect an available update.
	- This plugin accepts as shortcode parameters some configuration information required by Touchnet.
	- URL
		- Shortcode parameter: upay_url
		- Default value: https://secure.touchnet.com/C20444_upay/web/index.jsp
	- Site ID
		- Shortcode parameter: upay_site_id
		- Default value: -1
	- Passed Amount Validation Key
		- Shortcode parameter: passed_amount_validation_key
		- Default value: [empty string]
		- Description: This parameter holds the value of the "Passed Amount Validation Key" discussed in the Touchnet User's Guide. 
	This value needs to be created (a unique alphanumeric string 30 characters or less) and entered in the "Passed Amount Validation Key" field in the uPay Site's Payment Settings page. Visit your uPay admin site to create your passed_amount_validation_key string.