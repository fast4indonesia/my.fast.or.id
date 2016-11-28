<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
*
* class untuk handle bagian assesment
*/
class Profiles extends MY_Controller
{

    public function index()
    {
        $flash['success'] = $this->session->flashdata('success');
        $flash['warning'] = $this->session->flashdata('warning');
        $user = $this->current_user();
        echo $this->load->blade('profiles.index',
            array(
                'flash' => $flash,
                'user' => $user));
    }

    public function change_password()
    {
        $old = $this->load->decrypt($this->current_user()->password);

        if($old != $_POST['old_password'])
        {
            $this->session->set_flashdata('warning', 'Old Password tidak sesuai, silahkan ulangi lagi');
            redirect('/profiles', 'location');
        }
        else
        {
            if ($_POST['new_password'] != $_POST['new_password_2'])
            {
                $this->session->set_flashdata('warning', 'Konfirmasi New Password tidak sesuai, silahkan ulangi lagi');
                redirect('/profiles', 'location');
            }
            else
            {
                $this->current_user()->password = $this->load->encrypt($_POST['new_password']);
                $this->current_user()->save();
                $this->session->set_flashdata('success', 'Sukses mengubah password.');
                redirect('/profiles', 'location');
            }
        }
    }
}