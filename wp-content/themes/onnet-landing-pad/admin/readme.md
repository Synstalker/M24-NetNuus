OnNet Admin Framework
======================

Installation
---

Download the latest version of the frame work from the downloads section and decompress the archive into your theme root.
Your folder needs to be renamed to admin, if it isn't already.

Default Configuration
---

#### Automatic Updates & Notifications ####

All core, plugin and theme automatic updates as well as notifications have been disabled.  To enable these modify
the file */admin/admin-frame-work.php* in function *modify_automatic_updates_notifications*

#### Wodrpess Default Widgets ####

All widgets except Custom Meny & Search have been unregistered.  To change this modify to the file
file */admin/admin-frame-work.php* in function *deregister_default_widgets* and comment out the widgets
you would like to use.

#### Widget Coloring ####

The default styling for coloring widgets is included in */admin/css/widget-colors.css*.  You will
need to add your own classes for custom widgets there.

A management console will be released in the future.

Theme Options
---

#### Include the class file ####

	/**
	 * Load the Admin Framework
	 */
	require_once dirname(__FILE__) . '/admin/admin-framework.php';

#### Setup theme options for your theme ####

You will find the options file in

	/admin/lib/options.php

#### What options are available to use? ####

* text
* textarea
* checkbox
* select
* radio
* upload (an image uploader)
* images (use images instead of radio buttons)
* background (a set of options to define a background)
* multicheck
* color (a jquery color picker)
* typography (a set of options to define typography)
* editor