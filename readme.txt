=== Skrill ===
Contributors: AgileSolutionsPK
Donate link: http://agilesolutionspk.com/donate/
Tags: Wordpress, Payment Gateway, Skrill, Plugin
Requires at least: 3.3
Tested up to: 3.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Pay by Skrill button developed as Wordpress plugin.

== Description ==

It is a Wordpress plugin that displays a pay by Skrill button on your Wordpress page or post. Skrill was previously known as moneybookers.com. It integrates skrill with wordpress in a simple way. It uses shortcode API and stores common information in settings. You can create as many buttons on your site as you like. Here is the shortcode

[skrill_simple amount="2.00" label="Book" description="Romeo and Juliet" ] 

It has the following parameters

amount The total amount that you need to charge from customer. It includes shipping etc 
label  This is a short label for the item like book, cd etc. See Skrill documentation for details
description This is description of the item being sold.

You can also control the appearance of button by using css. Div class is "skrill" that you need to define
== Installation ==

1. Upload `skrill` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place shortcode on the page or post where you want button to be displayed

[skrill_simple amount="2.00" label="Book" description="Romeo and Juliet" ]

For basic usage, you can also have a look at the <a href="http://agilesolutionspk.com/skrill" rel="nofollow">plugin homepage</a>.
== Frequently asked questions ==

Q. What are the dependencies for this plugin.

A. There are no dependencies to uss this plugin.

Q. What is Skrill

A. Skrill is a payment system somewhat similar to paypal. You can get more info at http://www.skrill.com and http://www.moneybookers.com

Q. Can i control the appearance of button.

A. Yes, button and form and encapsulated in a div with class "skrill". You need to define this class in your css
