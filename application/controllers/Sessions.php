<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions extends CI_Controller {

   public function __construct()
    {
        parent::__construct();
        $this->load->driver('session');
    }

    public function index()
    {
        redirect('sessions/sign_in', 'location');
    }

    public function sign_in()
    {
        if ($this->session->has_userdata('logged_in')){
            redirect('/', 'location');
        }
        else
        {
            $flash['success'] = $this->session->flashdata('success');
            $flash['warning'] = $this->session->flashdata('warning');
            echo $this->load->blade('session.index', array(
                'flash' => $flash));
        }
    }

    public function create() {
        $post = $_POST;
        $user = Model_User::find('first', 
                    array(
                        'conditions'=> array(
                        'email = ?', $post['email'])
                    )
                );
        $pegawai = Model_Alumni::find('first', 
                    array(
                        'conditions'=> array(
                        'email = ?', $post['email'])
                    )
                );
        if ($user){
            $a = get_instance()->load->decrypt($user->password);
            $b = ($post['password']);
            if ( $a == $b ){
                $this->session->set_flashdata('success', 'Login sukses.');

               $data = array('logged_in' => true, 'user_id' => $user->user_id,'nim' => $user->nim,'nama' => $pegawai->nama,'role' => $user->role);
                $user->last_ip = $user->ip;
                $user->ip = $this->input->ip_address() ;
                $user->last_login = $user->login_date;
                $user->login_date = date('d-m-Y');
                $user->save();
                $this->session->set_userdata($data);
                // print_r($data);
                redirect('/', 'location');
            }else{
                $this->session->set_flashdata('warning', 'Kombinasi Email dan Password tidak sesuai.');
                redirect('sessions/sign_in', 'location');
            }
        }
        else{
            $this->session->set_flashdata('warning', 'Email tidak ditemukan.');
            redirect('sessions/sign_in', 'location');
        }
    }

    public function sign_out()
    {
        $this->session->sess_destroy();
        redirect('/', 'location');
    }


    public function seed(){
        try {

            $user = new Model_User();
            $user->email    = 'admin@fast.or.id';
            $user->password = 'FastJuara1';
            $user->role     = 'administrator';
            $user->nim      = '000';
            $user->save();
        } catch (Exception $e) {
            echo $e;
        }

        print_r("seedeed");
    }


}