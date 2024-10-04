<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ffmpeg
{
    public function __construct(){
    
        require_once APPPATH.'third_party/ffmpeg/autoload.php'; 
    }
}  