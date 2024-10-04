<?php

require_once APPPATH.'services/ActivityLogger.php'; 

use App\Services\ActivityLogger;

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @since  2.3.2 because of deprecation of logActivity
 * Log Activity for everything
 * @param  string $description Activity Description
 * @param  integer $userid    The user who performs the activity, if null, the logged in staff member will used (if logged in)
 */
function log_activity($description, $userid = null)
{
    return ActivityLogger::log($description);
}

/**
 * Return last system activity id
 * @return mixed
 */
function get_last_system_activity_id()
{
    return ActivityLogger::getLast();
}