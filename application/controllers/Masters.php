<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Masters extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        redirect('/master/employee', 'location');
    }

}