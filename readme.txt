=== Robot Ninja Helper ===

Contributors: prospress
Tags: woocommerce, robot ninja, tests
Requires at least: 4.4.0
Tested up to: 4.7.0
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
WC requires at least: 3.0
WC tested up to: 3.0
Stable tag: trunk

== Description ==

The Robot Ninja Helper plugin helps [Robot Ninja](https://robotninja.com) connect and work better with your site.

**Note:** This plugin is only really of use to you if you have a Robot Ninja account.

== Installation ==

Install and activate - that's it.

== Frequently Asked Questions ==

**Do I need a Robot Ninja account to use this plugin?**

Yes - please [sign up here](https://robotninja.com). The pugin will still work but won't really provide you any benefit without the service.

**What does the helper plugin do?**

* Makes sure that the Robot Ninja customer/user used for tests has an empty cart when logging in (ensure clean state).
* Register some additional fields to the WooCommerce `/system_status` endpoint that Robot Ninja can use to help with it's tests e.g.
  * Whether _Guest Checkout_ is enabled
  * Location of key WooCommerce pages (shop, cart, checkout, myaccount)
  * Most popular product/s

== Changelog ==

= 1.0-beta =
* Initial beta release.