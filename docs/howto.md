# Overview
Touchnet uPay is the service designated by the university for ecommerce. If your WordPress site requires ecommerce functionality, it needs to be integrated with Touchnet. 

GravityForms is the product that allows WordPress Site Admins to easily create web forms. These forms live in subsites on secureforms.boisestate.edu.  

OIT's WP Support team is available to work with you to create a custom WordPress plugin that will combine WordPress, Gravity Forms and Touchnet to create an ecommerce application.

# Purpose
This document describes the process of having an ecommerce application created for your WordPress site. It lists the steps in the process and the communication and information you'll need to work with WP Support to create and launch this application.

# Prerequisites
There are a few pieces of information you'll need in order to get the process started:

 - Site ID. You'll need to know the site ID of your uPay site.
 - uPay URL. Make sure you know the URL to your uPay site.
 - Visit your uPay admin site to create your passed\_amount\_validation\_key string.

# Procedures
This section describes what you'll need to do to get your e-commerce application up and running, including working with the WP Support team to get a custom plugin created.

##1. **Contact WP Support.**  
You'll need to provide them some information they required in order to create and install a custom plugin to automatically direct your users to your uPay site. Each item or event for which uPay is used to collect payment will have its own version of this plugin. The [WP Support](https://webguide.boisestate.edu/contact/) team will need to customize the plugin and install it on your secureforms subsite.
##2. **Create your Forwarding Page.**  
The Forwarding Page is where you will use the plugin to send the user and transaction information to Touchnet. This is a simple page that contains only the plugin's shortcode. The shortcode will cause the page to automatically forward the user to Touchnet without seeing the Forwarding Page. Create a new page in your secureforms subsite and add the shortcode provided to you by WP Support. This page will serve as your confirmation page for the secureform you'll create in the next step, so note the URL. When users land here after submitting your form, they'll be immediately and automatically forwarded to your uPay site. 
##3. **Create your Gravity Form.**  
[This page on Webguide](https://webguide.boisestate.edu/secure-forms/) provides information on adding forms to your secureforms subsite. Work with WP Support  to implement a web form on secureforms.boisestate.edu for your ecommerce need. **Your Gravity Form must not include fields for payment information.** Users will enter payment information only after they arrive at Touchnet.
##4. **Test.**  
WP Support will require help from you to confirm that the plugin and forms are working properly. This will include submitting test payment to a test uPay site, and verifying the results.


#Notes:
Posting back the payment result + EXT\_TRANS\_ID. **Actually** there won't be a postback. This app and the uPay store will both record the transaction ID, and 
  they can be visually compared for confirmation. This is consistent with what users are doing as of September 2016 (per Coleen Dudley, Health Sciences).
