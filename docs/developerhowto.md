1. Configure the GravityForm
	- Form Settings->Confirmations. 
		- Confirmation Type = Redirect.
		- Redirect URL = the URL of the Forwarding Page created by the Site Admin.
		- Redirect Query String: Click the drop-down icon at the top right of this textarea to view the form fields available. By selecting fields here, 
compose a query string in the format "key1={value1}&key2={value2}..." You'll provide the key names and the formatting (ampersands and equals sign).
	- Save Confirmation.  
1. Create a new version of the Gravity Forms Extension plugin.
	- See [Deploying Custom Plugins](https://sites.google.com/a/boisestate.edu/wordpress-support/home/boise-state-custom-plugins/deploying-custom-plugins)
	- Update the class name in updater.php to assure that it's unique. All our plugins will use this class, and WP will throw an error if the 
 name isn't unique.
	- Update the main PHP file to reference the new class name...
  ...if( ! class_exists( 'Boise_State_[plugin_name]_Updater' ) ){...
  and the Github repository you created to hold the plugin code:
  ...$updater->set_repository( 'boise-state-[plugin_name]' );...
	- Push an initial commit of the code to Github
	- Create an initial release in Github
	- Download the zip file and install on test.boisestate.edu to complete your testing.
	- Download the zip file and install on the appropriate site for production.
	- Increment the version and create a new release on Github to test the production site's ability to automatically detect an available update.
1. Configuring and Testing
This plugin accepts as shortcode parameters some configuration information required by Touchnet.
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