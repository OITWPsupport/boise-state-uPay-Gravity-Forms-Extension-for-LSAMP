1. Prerequisites
 - Site ID. You'll need to know the site ID of your uPay site.
 - uPay URL. This is constant, but make sure you confirm that the URL you use in the upay_url value in the shortcode is accurate.
 - Visit your uPay admin site to create your passed_amount_validation_key string.
 - Plugin installed. Each item or event for which uPay is used to collect payment will have its own version of this plugin. The WP Support team will need to customize the plugin and install it on your secureforms subsite.
1. Create your forwarding page
  - this is where you use the shortcode
  - Create a new page in your secureforms subsite and add the shortcode provided to you by WP Support. This page will serve as your confirmation page for the secureform you'll create in the next step, so note the URL. When users land here after submitting your form, they'll be immediately and automatically forwarded to your uPay site.
1. Create your GravityForm
 - [This page on Webguide](https://webguide.boisestate.edu/secure-forms/) provides information on adding forms to your secureforms subsite. 
 - When you create your form, you need to provide 
  - Select the Confirmation tab
  - Click the Redirect button and enter the URL of the forwarding page you created above.
1. Submit a request to WP Support
 - Before your form is complete, the WP Support team will need to create and install a custom plugin to automatically direct your users to your uPay site. Contact the Help Desk and request a custom GravityForms extension.
1. Test
 - WP Support will require help from you to confirm that the plugin and forms are working properly.
1. Unanswered
  - Posting back the payment result + EXT_TRANS_ID
