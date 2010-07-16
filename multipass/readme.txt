=== Plugin Name ===
Contributors: kennymeyers
Donate link: http://tenderapp.com
Tags: support, tender
Requires at least: 2.8
Tested up to: 3.0
Stable tag: 4.3

MultiPass is a plugin for sending your user data to the fantastic customer support application Tender. This allows you to do single-sign on for both your Wordpress site and Tender.  All you have to do is feed it your MultiPass information.

== Description ==

What is Tender's MultiPass Single-Sign on?

When you build a website with [CMS], it already comes with a user registration system. Tender compliments your application, product or marketing site by being able to share this registration systems information.

With MultiPass Single Sign On you don't need user's to re-register with Tender, who wants to do that? Terrible people. That's whom.

With MultiPass we pass all the user information as securely as possible over a simple hyperlink. 

This plugin goes one step further and makes sure you don't have to do any of the weird encryption and crazy programming to secure the info. All you need to know are three simple things: 

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the `multipass` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `<?php multipass('yourtenderlink', 'your_sso_key', 'your_tender_site_key'); ?>` in your templates. With that information it will generate the link. 

This will generate an anchor element (link omitted due to its size and looks): 

<a href="(generated link)">Support</a>.

Optionally, you may use a fourth parameter and give the link a different text:

e.g. <?php multipass('yourtenderlink', 'your_sso_key', 'your_tender_site_key', "Help"); ?>

Will generate <a href="(generated link)">Help</a>

== Enabling MultiPass == 

In order to use this plugin you need to enable MultiPass on your Tender application. Here's how:

1. Login to your Tender app so you see your dashboard
2. Click on the Site Settings nav item
3. Scroll down to the bottom of the page
4. Where it says "MultiPass Single Sign On" click on "Enabled".
5. Copy and paste your SSO API key and your site key, make sure you keep them separate and you know which is which. 

With those three pieces of information, this plugin will automatically generate your Tender link.
