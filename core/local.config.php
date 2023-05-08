<?php

/**
 * This is the phpVMS Main Configuration File
 *
 * This file won't be modified/touched by future versions
 * of phpVMS, you can change your settings here
 * 
 * There may also be additional settings in app.config.php
 * To change it, copy the line into this file here, for the
 * settings to take effect
 *
 */

/**
 * MAKE ALL ADDITIONS AND CHANGES TO THIS FILE. Do NOT
 * add or make changes to app.config.php
 * Instead, (if necessary) copy the section in question from app.config.php 
 * and paste into local.config.php - then make the changes here in the local.config.php file 
 * Entries in local.config.php will take precedence over the same entry in app.config.php
 */

Config::Set('DEBUG_MODE', false);
Config::Set('DEBUG_LEVEL', 1); // 1 logs query errors, 2 logs all queries
Config::Set('ERROR_LEVEL', E_ALL ^ E_NOTICE);

define('DBASE_USER', 'phpvms');
define('DBASE_PASS', 'nTfnSKrHsNzPWPkX');
define('DBASE_NAME', 'phpvms');
define('DBASE_SERVER', 'localhost');
define('DBASE_TYPE', 'mysqli');

define('TABLE_PREFIX', 'phpvms_');

define('SITE_URL', 'https://aoc.virtualcqh.com');

# Page encoding options
Config::Set('PAGE_ENCODING', 'ISO-8859-1');

# Clean URLs - set this to true, and then uncomment
# the lines indicated in the .htaccess file 
Config::Set('URL_REWRITE', false);

# Maintenance mode - this disables the site to non-admins
Config::Set('MAINTENANCE_MODE', false);
Config::Set('MAINTENANCE_MESSAGE', 'We are currently down for maintenance, please check back soon.');

/*	Whether you have the /admin/maintenance.php script added into cron.
	If you do, set this to true. This saves many DB calls since phpVMS will
	have to 'fake' a cron-job
	*/
Config::Set('USE_CRON', false);

Config::Set('CHECK_RELEASE_VERSION', true);
Config::Set('CHECK_BETA_VERSION', false);

# See more details about these in the docs
Config::Set('PAGE_EXT', '.htm');	# .htm is fine. You can still run PHP
Config::Set('PILOTID_OFFSET', 0);	# What # to start pilot ID's from
Config::Set('PILOTID_LENGTH', 4);	# Length of the Pilot ID
Config::Set('UNITS', 'nm');			# Your units: nm, mi or km
Config::Set('LOAD_FACTOR', '82');	# %age load factor 
Config::Set('CARGO_UNITS', 'kg');

# After how long to mark a pilot inactive, in days
Config::Set('PILOT_AUTO_RETIRE', true);
Config::Set('PILOT_INACTIVE_TIME', 90);

# Automatically confirm pilots?
Config::Set('PILOT_AUTO_CONFIRM', true);

# Automatically calculate ranks?
Config::Set('RANKS_AUTOCALCULATE', true);

# For how many hours a pilot can edit their submitted PIREP (custom fields only)
Config::Set('PIREP_CUSTOM_FIELD_EDIT', '48');

# If someone places a bid, whether to disable that or not
Config::Set('DISABLE_SCHED_ON_BID', false);
Config::Set('DISABLE_BIDS_ON_BID', false);

# If you want to count transfer hours in rank calculations
Config::Set('TRANSFER_HOURS_IN_RANKS', false);

# The StatsData::UserOnline() function - how many minutes to check
Config::Set('USERS_ONLINE_TIME', 20);

/* Google Map Options
	You will need to add your own Google Maps API Key in two different locations. 
	Look in core/templates/core_htmlhead.php (might want to move this to
		lib/skins/YOURSKINNAME folder instead) around line 37. Replace
		YOUR_API_KEY_HERE with your personal Google Maps API key
	Look in admin/templates/core_htmlhead.php around line 16. Replace 
		YOUR_API_KEY_HERE with your personal Google Maps API key. */
Config::Set('MAP_WIDTH', '800px');
Config::Set('MAP_HEIGHT', '600px');
# Valid types are G_NORMAL_MAP, G_SATELLITE_MAP, G_HYBRID_MAP, G_PHYSICAL_MAP
Config::Set('MAP_TYPE', 'CartoDB.DarkMatter');
Config::Set('MAP_LINE_COLOR', '#ff0000');
Config::Set('MAP_CENTER_LAT', '27.500000');
Config::Set('MAP_CENTER_LNG', '115.642634');
Config::Set('MAP_ZOOM_LEVEL', 3);

/* Recaptcha - This version is ReCaptcha v2 compliant. You will need to 
	acquire your own keys for ReCaptcha to work. Keys are site specific. 
	Get your keys here: https://developers.google.com/recaptcha/docs/display
	Add each key in the designated section */
Config::Set('RECAPTCHA_PUBLIC_KEY', 'PLACE_GOOGLE_RECAPTCHA_SITE_KEY_HERE');
Config::Set('RECAPTCHA_PRIVATE_KEY', 'PLACE_GOOGLE_RECAPTCHA_SECRET_KEY_HERE');

# ACARS options
#  Minutes, flights to show on the ACARS
#  Default is 720 minutes (12 hours)
Config::Set('ACARS_LIVE_TIME', 720); 
Config::Set('ACARS_DEBUG', false);

# This is your airline's twitter account, if it exists
Config::Set('TWITTER_AIRLINE_ACCOUNT', '');
Config::Set('TWITTER_ENABLE_PUSH', false);
Config::Set('TWITTER_CONSUMER_KEY', '');
Config::Set('TWITTER_CONSUMER_SECRET', '');
Config::Set('TWITTER_OAUTH_TOKEN', '');
Config::Set('TWITTER_OAUTH_SECRET', '');

/*
  This is the unit of money. For non-dollars, use :
	Dollars ($), enter "$"
	Euro (€), enter "&#8364;"
	Yen (¥), enter "&yen;"
	Pounds (£), enter "&pound;"
	
  For example, to set EUROS:
	Config::Set('MONEY_UNIT', '&#8364;');
 */

Config::Set('MONEY_UNIT', '￥');
 
# FSPassengers Settings
# Units settings
Config::Set('WeightUnit', '0');   # 0=Kg 1=lbs
Config::Set('DistanceUnit', '2');   # 0=KM 1= Miles 2=NMiles
Config::Set('SpeedUnit', '1');   # 0=Km/H 1=Kts
Config::Set('AltUnit', '1');   # 0=Meter 1=Feet 
Config::Set('LiquidUnit', '2');   # 0=liter 1=gal 2=kg 3=lbs
Config::Set('WelcomeMessage', 'phpVMS/FSPAX ACARS'); # Welcome Message

/* FSFK Settings
	Your FTP Server, and path to the lib/images folder (from where the FTP connects from), IE
	ftp://phpvms.net/phpvms/lib/fsfk or ftp://phpvms.net/public_html/phpvms/lib/fsfk
	
	You want the path from when you connect to the FTP down to where the /lib/fsfk folder is 
    
    SECURITY NOTE! Make a separate FTP user and password ONLY for this, with access only to this folder
*/
Config::Set('FSFK_FTP_SERVER', '');
Config::Set('FSFK_FTP_PORT', '21');
Config::Set('FSFK_FTP_USER', '');
Config::Set('FSFK_FTP_PASS', '');
Config::Set('FSFK_FTP_PASSIVE_MODE', 'TRUE');
Config::Set('FSFK_IMAGE_PATH', '/lib/fsfk'); // web path from SITE_ROOT

# Options for the signature that's generated 
Config::Set('SIGNATURE_TEXT_COLOR', '#000');
Config::Set('SIGNATURE_SHOW_EARNINGS', false);
Config::Set('SIGNATURE_SHOW_RANK_IMAGE', false);
Config::Set('SIGNATURE_SHOW_COPYRIGHT', false);

# Avatar information
Config::Set('AVATAR_FILE_SIZE', 50000); 
Config::Set('AVATAR_MAX_WIDTH', 80);
Config::Set('AVATAR_MAX_HEIGHT', 80);

# Email Settings
Config::Set('EMAIL_FROM_NAME', 'no-reply');
Config::Set('EMAIL_FROM_ADDRESS', 'admin@virtualcqh.com');

Config::Set('EMAIL_USE_SMTP', true);
# Add multiple SMTP servers by separating them with ;
Config::Set('EMAIL_SMTP_SERVERS', 'smtp.exmail.qq.com');
Config::Set('EMAIL_SMTP_PORT', '465');
Config::Set('EMAIL_SMTP_USE_AUTH', true);
Config::Set('EMAIL_SMTP_SECURE', 'ssl'); # must be "ssl" for Google Apps
Config::Set('EMAIL_SMTP_USER', 'admin@virtualcqh.com');
Config::Set('EMAIL_SMTP_PASS', 'Wj9kBP95V6jeVCDd');
