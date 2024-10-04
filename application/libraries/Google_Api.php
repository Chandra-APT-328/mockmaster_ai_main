<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google_Api
{
    public function __construct(){
        log_message('Debug', 'Google_Api class is loaded.');
        require_once APPPATH.'third_party/google-api/vendor/autoload.php';
    }

}