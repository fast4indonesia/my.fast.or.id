<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Talents.php';

class TalentPool extends Talents {

    public function __construct()
    {
        parent::__construct();
        $this->load->driver('session');
    }

    // show all data
    public function index()
    {
        $flash['success'] = $this->session->flashdata('success');
        $flash['warning'] = $this->session->flashdata('warning');
        echo $this->load->blade('talents.talentpool.index',
            array('flash'=>$flash, 'data' => Model_Talent_Dictionary::all_order(),
                'employee' => Model_Employee::all()));
    }
}