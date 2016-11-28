<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Talents.php';

class TracerCandidate extends Talents {

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
        $unit = Model_Unit::select_all();
        $status_definitif = Model_Status_Definitif::select_all();
        $grade = Grade::select_all();
        $jabatan = Model_Jabatan::select_all();
        echo $this->load->blade('talents.tracer.index',
            array('flash'=>$flash, 'karyawan' => Model_Employee::all(), 'unit' => $unit, 'status_definitif' => $status_definitif, 'grade' => $grade, 'jabatan' => $jabatan));
    }


    //tracer kandidat
    public function search()
    {
    	$post = $this->input->post();
    	$karyawan = Model_Employee::CustomSearchBy($post);
        $unit = Model_Unit::select_all();
        $status_definitif = Model_Status_Definitif::select_all();
        $grade = Grade::select_all();
        $jabatan = Model_Jabatan::select_all();

    	$flash['success'] = $this->session->flashdata('success');
        $flash['warning'] = $this->session->flashdata('warning');
        echo $this->load->blade('talents.tracer.index',
            array('flash'=>$flash, 'karyawan' => $karyawan, 'unit' => $unit, 'status_definitif' => $status_definitif, 'grade' => $grade, 'jabatan' => $jabatan));

    }

    public function filterpost()
    {
        if (($this->input->post()) == null)
        {
            redirect('master/employee/filter');
        }
        else
        {
            $field = $this->input->post('filter_categories');
            $value = $this->input->post('filter_categories_values');
            $conditions = $field.'= ?';
            $data['search'] = new Model_Employee();
            $data['karyawan'] = Model_Employee::find('all', array('conditions' => array($conditions, $value)));
            $data['sidebar']= "includes/sidebar";
            $data['content']="master/employees/filter";
            $data['controller_name'] = $this->controller_name;
            $this->load->view('layouts/application', $data, FALSE);
        }
    }

}