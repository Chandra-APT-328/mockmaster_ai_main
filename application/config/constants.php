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

define('SAPLING_KEY', 'IEWKADUJVTYE8GCI7T5ORFDXQQT9O0O4');
define('SPEECH_SUPER_API_APP_KEY', '1688376425000192');
define('SPEECH_SUPER_API_SECRET_KEY', '3774f08b5dc9b37f66677f20fb43cc2f');
define('STRIPE_API_KEY', 'pk_live_51Nlt0dFlqNEgSv3hVP6zjDqUXKOE5ogbe6BGJzet66lEiZuGSFjmwsjjfcCQk51wtD9KPW4Qmg3UUDpL4NtuUQDF00uXYTMgbG');
define('STRIPE_SECRET_KEY', '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');
define('PRICE_ID', 'price_1Nqy4TSARFVcxe44L1WZGWAe');
define('PRODUCT_ID', 'prod_QcozCHsOjPp9k2');
define('STRIPE_CURRENCY','aud');
define('MAIL_SIGNATURE', 'One Australia Group');
define('PTEACADEMIC','academic');
define('PTECORE','core');
define('CORRECT_GRAMMER_API', 'http://103.138.244.114:8000/text_api/correct_grammar');
define('LANDING_PAGE', 'https://mockmaster.ai');

define('SMTP_EMAIL', 'contact@mockmaster.ai');
define('SMTP_PASSWORD', 'cnvfypjgsafcatpu');
define('DEV_SMTP_EMAIL', '');
define('DEV_SMTP_PASSWORD', '');

define('APPLYKART_KEY', '$a5%&jwr');
define('APPLYKART_IV', '@RApp987');

define('PACKAGE_REGULAR', 'regular');
define('PACKAGE_FREE', 'free');
define('PACKAGE_APPLYKART', 'applykart');
define('PACKAGE_PRACTICE_PRO', 'practice pro');
define('PACKAGE_SUCCESS_BUNDLE', 'success bundle');