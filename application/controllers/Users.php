<?php defined('BASEPATH') OR exit('No direct script access allowed');
//file : application/controllers/talent
/**
*
* class untuk handle bagian assesment
*/

class Users extends MY_Controller{

    public $controller_name = "users";

    public function __construct(){
        parent::__construct();
         $this->load->driver('session');

        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    }

    public function index(){
        $flash['success'] = $this->session->flashdata('success');
        $flash['warning'] = $this->session->flashdata('warning');
        echo $this->load->blade('users.index',
            array('flash'=>$flash, 'users' => Model_Users::all()));
    }




    public function create($users = null, $error = null, $method = "create")
    {

        $flash['success'] = $this->session->flashdata('success');
        $flash['warning'] = $this->session->flashdata('warning');
        $users = isset($users) ? $users : new Model_Users();
        $listkaryawan = Model_Employee::select_list_not_exist();
        $listkaryawanemail = Model_Employee::select_list_karyawan_email();
        echo $this->load->blade('users.create',
            array(
                'flash'=>$flash,
                'data' => $users,
                'flashdata' => $error,
                'method' => $method,
                'role' => $role,
                'listkaryawan' => $listkaryawan,
                'listkaryawanemail' => $listkaryawanemail,
            ));
    }

    public function get_email($nipeg){
        $email = Model_Employee::get_email_by_nipeg($nipeg);
        echo json_encode($email);
        return json_encode($email);
    }


    // insert data
    public function store(){
        $post = $_POST; unset($post['_token']);
        $users = new Model_Users($post);
        if ($users->is_valid()){

      
           
            $users->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/users', 'location');
            
        }
        else{
            
            if (!empty($post)){
                //var_dump(expression)
                return $this->create($users, $users->errors->full_messages(), 'store');
            }
            else{
               return $this->create($users);
            }
            
        }
        

    }

    // show edit form
    public function edit($id){
        $error = $this->session->userdata('warning');
        $users = $this->session->userdata('users');
        $users = !empty($users) ? $users : Model_users::find_by_user_id($id);
        $listkantor = Model_Kantor::select_all();
        $listjabatan = Model_Jabatan::select_all();
        $listgrade = Grade::select_all();
        $listposisi = Model_Posisi::select_all();
        $listprofesi = Model_Profesi::select_all();
        $listjenjangkkj = JenjangKkj::select_all();
        $listjenjangjabatan = Model_Jenjang_Jabatan::select_all();
        //$liststatusdefinitif = Model_Status_Definitif::select_all();
        $listcostcenter = Model_Cost_Center::select_all();
        $listjenjangmaingrp = Model_Jenjang_KKJ_Main_GRP::select_all();
        $this->session->unset_userdata('users');
        $this->session->unset_userdata('warning');
        echo $this->load->blade('users.edit',
            array(
                'data' => $users,
                'flashdata' => $error,
                'method' => $method,
                'listkantor' => $listkantor,
                'listjabatan' => $listjabatan,
                'listgrade' => $listgrade,
                'listposisi' => $listposisi,
                'listprofesi' => $listprofesi,
                'listjenjangkkj' => $listjenjangkkj,
                'listjenjangjabatan' => $listjenjangjabatan,
                //'liststatusdefinitif' => $liststatusdefinitif,
                'listcostcenter' => $listcostcenter,
                  ));
    }

    //update data
    public function update()
    {
        if (empty($_POST)){
            redirect('users', 'location');
        }
        else{
            $id = $this->input->post('nipeg');
            $users = Model_Employee::find_by_nipeg($id);


            $users->tahun_pengangkatan =  $this->input->post('tahun_pengangkatan');
            $users->nama = $this->input->post('nama');
            $users->kode_jabatan= $this->input->post('kode_jabatan');
            $users->tgl_mulai_jabatan= $this->input->post('tgl_mulai_jabatan');
            $users->kode_grade= $this->input->post('kode_grade');
            $users->tgl_grade_terakhir= $this->input->post('tgl_grade_terakhir');
            $users->kode_posisi= $this->input->post('kode_posisi');
            $users->lama_di_organisasi= $this->input->post('lama_di_organisasi');


            if ($users->is_invalid())
            {
                $this->session->set_flashdata('error', $users->errors->full_messages());
                $this->session->set_userdata('grade', $users);
                redirect('master/employee/edit/'.$id);
                //return $this->edit($id);

            }
            else{
                $users->save();
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/master/employees', 'location');
            }

        }
    }

    // delete data
    public function destroy($id){
        $users = !empty($users) ? $users : Model_Users::find_by_user_id($id);
        $users->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/users', 'location');
    }





















    // public function setting($role_id)
    // {
    //     // print_r(Model_Module::get_module()[1]->submodule());die;
    //     $role = Role::find_by_idx($role_id);
    //     if (is_null($role))
    //     {
    //         $this->session->set_flashdata('warning', 'Role tidak ditemukan');
    //         redirect('/access', 'location');
    //     }
    //     // print_r(Model_Module::get_module()[0]->has_permission($role_id));die;
    //     echo $this->load->blade('access.setting', array(
    //         'role' => $role,
    //         'module' => Model_Module::get_module()));
    // }

    // public function store($role_id)
    // {
    //     $role = Role::find_by_idx($role_id);
    //     if (is_null($role) || !isset($_POST['data']))
    //     {
    //         $this->session->set_flashdata('warning', 'Role tidak ditemukan');
    //         redirect('/access', 'location');
    //     }
    //     else
    //     {
    //         //delete_all_permission
    //         Model_Permission::delete_all(array('conditions' => array('role_name' => $role_id)));
    //         foreach ($_POST['data'] as $key => $value) {
    //             $perm = new Model_Permission();
    //             $perm->modul_id = $value;
    //             $perm->role_name = $role_id;
    //             $perm->save();
    //         }
    //         $this->session->set_flashdata('success', 'Data berhasil disimpan.');
    //         redirect('/access', 'refresh');
    //     }
    // }
}