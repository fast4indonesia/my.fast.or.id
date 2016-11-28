<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
*
* class untuk handle bagian assesment
*/
class Access extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
         $this->load->driver('session');
    }

    public function index()
    {
        $flash['success'] = $this->session->flashdata('success');
        $flash['warning'] = $this->session->flashdata('warning');
        echo $this->load->blade('access.index', array(
            'data' => Role::all(),
            'flash'=> $flash));
    }

    public function setting($role_id)
    {
        // print_r(Model_Module::get_module()[1]->submodule());die;
        $role = Role::find_by_idx($role_id);
        if (is_null($role))
        {
            $this->session->set_flashdata('warning', 'Role tidak ditemukan');
            redirect('/access', 'location');
        }
        // print_r(Model_Module::get_module()[0]->has_permission($role_id));die;
        echo $this->load->blade('access.setting', array(
            'role' => $role,
            'module' => Model_Module::get_module()));
    }

    public function store($role_id)
    {
        $role = Role::find_by_idx($role_id);
        if (is_null($role) || !isset($_POST['data']))
        {
            $this->session->set_flashdata('warning', 'Role tidak ditemukan');
            redirect('/access', 'location');
        }
        else
        {
            //delete_all_permission
            Model_Permission::delete_all(array('conditions' => array('role_name' => $role_id)));
            foreach ($_POST['data'] as $key => $value) {
                $perm = new Model_Permission();
                $perm->modul_id = $value;
                $perm->role_name = $role_id;
                $perm->save();
            }
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('/access', 'refresh');
        }
    }
}