<?php

// require_once BASEPATH.'vendor/autoload.php';

class ActiveRecord
{
    public function __construct(){

        ActiveRecord\Config::initialize(function($cfg)
        {
            $ci =& get_instance();
            $ci->load->database();
            $cfg->set_model_directory(APPPATH.'models');
            $cfg->set_connections(array(
                 'development' => $ci->db->dsn));
        });
    }
}