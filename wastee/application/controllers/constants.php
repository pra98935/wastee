<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

switch(ENVIRONMENT) 
{
	case 'development':
		define( 'SUPPORT_EMAIL' ,	'support@wastee.com' );
		define( 'FEEBACK_EMAIL' ,	'support@wastee.com' );
		define( 'MAIL_TO_SUPPORT' , 'support@wastee.com' );
		define( 'FROM_ADMIN_EMAIL'	,	'' );
		define( 'BCC_EMAIL'			,	'support@wastee.com' );
		define( 'SMTP_HOST'			,	'smtp.gmail.com' );
		define( 'SMTP_USER'			,	'kumrawatparichaya@gmail.com' );
		define( 'SMTP_PASS'			,	'modi8189' );
		define( 'SMTP_PORT'			,	'25' );
		define( 'PROTOCOL'			,	'smtp' );
		define( 'SMTP_CRYPTO'		,	'tls' );
		define( 'ROOT_PATH'			,	$_SERVER['DOCUMENT_ROOT'].'/mobile/' );
		define( 'PATH_URL'			,	'http://'.$_SERVER['SERVER_NAME'].'/mobile/' );

		/** FACEBOOK ID **/
		define( 'FACEBOOK_ID'		,  '270698356633437' );

		/** GOOGLE+ ID **/
		define(	'GOOGLE_CLIENT_ID'		,	'801786671483-ocr7ou65t2nve6i7t20b8miojoosfa70.apps.googleusercontent.com' );
		define(	'GOOGLE_API_KEY'		,	'AIzaSyCNiLUDrAFobJvD9VW9nz228HRcidqUg6Azz' );

		/** GOOGEL CAPTCHA **/
		define('CAPTCHA_PUBLIC_KEY', '6Lf8hwgTAAAAAM5N-H0osq0j2kodSDAW-pn_203l');
		define('CAPTCHA_PRIVATE_KEY', '6Lf8hwgTAAAAAE0f6WTxr9WgrGxGMedLFsc45XYD');
		
		define('IMAGE_SERVER','local');
		define('IMAGE_UPLOADS_URL',        'http://'.$_SERVER['SERVER_NAME'].'/mobile/uploads/');
		define('ROOT_PATH_UPLOADS', $_SERVER['DOCUMENT_ROOT'] . "/mobile/uploads/");

		break;
	case 'testing':
		efine( 'SUPPORT_EMAIL' ,	'support@wastee.com' );
		define( 'FEEBACK_EMAIL' ,	'support@wastee.com' );
		define( 'MAIL_TO_SUPPORT' , 'support@wastee.com' );
		define( 'FROM_ADMIN_EMAIL'	,	'' );
		define( 'BCC_EMAIL'			,	'support@wastee.com' );
		define( 'SMTP_HOST'			,	'smtp.gmail.com' );
		define( 'SMTP_USER'			,	'kumrawatparichaya@gmail.com' );
		define( 'SMTP_PASS'			,	'modi8189' );
		define( 'SMTP_PORT'			,	'25' );
		define( 'PROTOCOL'			,	'smtp' );
		define( 'SMTP_CRYPTO'		,	'tls' );
		define( 'ROOT_PATH'			,	$_SERVER['DOCUMENT_ROOT'].'/mobile/' );
		define( 'PATH_URL'			,	'http://'.$_SERVER['SERVER_NAME'].'/mobile/' );

		/** FACEBOOK ID **/
		define( 'FACEBOOK_ID'		,  '1175735589110203' );

		/** GOOGLE+ ID **/
		define(	'GOOGLE_CLIENT_ID'		,	'57990170944-2ahe50ack7bqubd4e7erjnphhsplh54s.apps.googleusercontent.com' );
		define(	'GOOGLE_API_KEY'		,	'AIzaSyBRPtYxGwaIpOicoK4sEwwKzSAxOF22U9M' );

		/** GOOGEL CAPTCHA **/
		define('CAPTCHA_PUBLIC_KEY', '6LdqMAkTAAAAALYZp0Z07swHE1r2_Y2T-VfzwE8N');
		define('CAPTCHA_PRIVATE_KEY', '6LdqMAkTAAAAAM4LG4ROkB1EQy3ijt-KUL0h6GXo');
		
		define('IMAGE_SERVER','local');
		define('IMAGE_UPLOADS_URL', 'http://'.$_SERVER['SERVER_NAME'].'/mobile/uploads/');
		define('ROOT_PATH_UPLOADS', $_SERVER['DOCUMENT_ROOT'] . "/mobile/uploads/");
		
		break;
	default:
		define( 'SUPPORT_EMAIL' ,	'' );
		define( 'FEEBACK_EMAIL' ,	'' );
		define( 'MAIL_TO_SUPPORT' , '' );
		define( 'FROM_ADMIN_EMAIL'	,	'' );
		define( 'BCC_EMAIL'			,	'' );

		define( 'SMTP_HOST'			,	'' );
		define( 'SMTP_USER'			,	'' );
		define( 'SMTP_PASS'			,	'' );
		define( 'SMTP_PORT'			,	'587' );
		define( 'PROTOCOL'			,	'smtp' );
		define( 'SMTP_CRYPTO'		,	'tls' );

		define( 'ROOT_PATH'			,	$_SERVER['DOCUMENT_ROOT'].'/' );
		define( 'PATH_URL'			,	'http://'.$_SERVER['SERVER_NAME'].'/' );

		/** FACEBOOK ID **/
		define( 'FACEBOOK_ID'		,  '1869311083292442' );

		/** GOOGLE+ ID **/
		define(	'GOOGLE_CLIENT_ID'		,	'801786671483-ocr7ou65t2nve6i7t20b8miojoosfa70.apps.googleusercontent.com' );
		define(	'GOOGLE_API_KEY'		,	'AIzaSyCNiLUDrAFobJvD9VW9nz228HRcidqUg6Azz' );

		/** GOOGEL CAPTCHA **/
		define('CAPTCHA_PUBLIC_KEY', '6Lf8hwgTAAAAAM5N-H0osq0j2kodSDAW-pn_203l');
		define('CAPTCHA_PRIVATE_KEY', '6Lf8hwgTAAAAAE0f6WTxr9WgrGxGMedLFsc45XYD');
		
		define('IMAGE_SERVER','local');
		define('IMAGE_UPLOADS_URL',        'http://'.$_SERVER['SERVER_NAME'].'/mobile/uploads/');
		define('ROOT_PATH_UPLOADS',         $_SERVER['DOCUMENT_ROOT'] . "/mobile/uploads/");

	break;
}

/******* TABLE NAME CONSTANT *******/
define( 'ACTIVE_LOGIN' , 'tbl_active_login' );
define('USER', 'tbl_users');
define('CATEGORY', 'ms_category');
define('ITEM', 'tbl_items');
define('ENTITY_MEDIA', 'tbl_entity_media');


define('PROJECT_NAME', 'Wastee');
define('AUTH_KEY', 'KEY');

define( 'USER_TYPE' , 	'USER' );
define( 'ADMIN_TYPE' ,	'ADMIN' );

define( 'IS_LOCAL_TIME' , TRUE );
define( 'BACK_YEAR', '0 month' );

/******* Main settings *******/
define( 'MAILPATH'			,	'' );
define( 'MAILTYPE'			,	'html' );
define( 'CHARSET'			,	'iso-8859-1' );
define( 'WORD_WRAP'			,	TRUE );


define( 'FROM_EMAIL_NAME'	,	'Wastee' );
define( 'FROM_EMAIL_TITLE'	,	'Wastee' );
define( 'NO_REPLY_EMAIL'	,	'noreply1@wastee.com' );

define('ENTITY_TYPE_PRODUCT', 'Product');
define('ENTITY_TYPE_USER','User');


define('MYSQL_DATE_FORMAT', '%b %d, %Y %a %h:%i %p');
define('PHP_DATE_FORMAT', 'M d, Y h:m A');
define('DEFAULT_TIME_ZONE_ABBR', 'GST');
