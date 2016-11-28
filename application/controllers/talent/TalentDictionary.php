<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Talents.php';

class TalentDictionary extends Talents {

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
        echo $this->load->blade('talents.dictionary.index',
            array('flash'=>$flash, 'talentdictionary' => Model_Talent_Dictionary::all()));
    }

    // show form
    public function create($talentdictionary = null, $error = null, $method = "create")
    {
        $talentdictionary = isset($talentdictionary) ? $talentdictionary : new Model_Talent_Dictionary();
        $error = validation_errors();
        echo $this->load->blade('talents.dictionary.create',
        array('data' => $talentdictionary, 'flashdata' => $error, 'method' => $method, 'error' => $error));
    }

    // insert data
    public function store()
    {
        $this->load->library('form_validation');
        $post = $_POST; unset($post['_token']);
        $this->form_validation->set_rules('nama_kriteria', 'Nama Kriteria', 'required');

        $this->form_validation->set_rules('rentang_performance_awal', 'Rentang Performance Awal', 'integer|greater_than_equal_to[0]|less_than[601]');

        $this->form_validation->set_rules('rentang_performance_akhir', 'Rentang Performance Akhir', 'integer|greater_than_equal_to[0]|less_than[601]');

        $this->form_validation->set_rules('rentang_potensi_awal', 'Rentang Potensi Awal', 'integer|greater_than_equal_to[0]|less_than[401]');
        $this->form_validation->set_rules('rentang_potensi_akhir', 'Rentang Potensi Akhir', 'integer|greater_than_equal_to[0]|less_than[401]');


        if ($this->form_validation->run() == FALSE)
        {

            $talentdictionary = new Model_Talent_Dictionary($post);
            // print_r(validation_errors());die;
            return $this->create($talentdictionary, array(validation_errors()));
        }
        else
        {
            $talentdictionary = new Model_Talent_Dictionary($post);
            if ($talentdictionary->is_valid())
            {
                $talentdictionary->save();
                $this->session->set_flashdata('success', 'Sukses menyimpan data');
                redirect('/talent/talentDictionary', 'location');
            }
            else
            {
                if (!empty($post))
                {
                    return $this->create($talentdictionary, $talentdictionary->errors->full_messages(), 'store');
                }
                else
                {
                    return $this->create($talentdictionary);
                }
            }
        }

    }

    // show edit form
    public function edit($id)
    {
        $error = $this->session->userdata('warning');
        $talentdictionary = $this->session->userdata('talentdictionary');
        $talentdictionary = !empty($talentdictionary) ? $talentdictionary : Model_Talent_Dictionary::find_by_kode_talent_dictionary($id);
        $this->session->unset_userdata('talentdictionary');
        $this->session->unset_userdata('warning');
        $warning = validation_errors();
        echo $this->load->blade('talents.dictionary.edit', array('data' => $talentdictionary, 'flashdata' => $error, 'warning' => $warning));
    }

    //update data
    public function update($id)
    {
        $this->load->library('form_validation');
        if (empty($_POST)){
            redirect('/talent/talentDictionary', 'location');
        }
        else
        {
            $this->form_validation->set_rules('nama_kriteria', 'Nama Kriteria', 'required');
            $this->form_validation->set_rules('rentang_performance_awal', 'Rentang Performance Awal', 'integer|greater_than_equal_to[0]|less_than[601]');
            $this->form_validation->set_rules('rentang_performance_akhir', 'Rentang Performance Akhir', 'integer|greater_than_equal_to[0]|less_than[601]');
            $this->form_validation->set_rules('rentang_potensi_awal', 'Rentang Potensi Awal', 'integer|greater_than_equal_to[0]|less_than[401]');
            $this->form_validation->set_rules('rentang_potensi_akhir', 'Rentang Potensi Akhir', 'integer|greater_than_equal_to[0]|less_than[401]');
            if ($this->form_validation->run() == FALSE)
            {
                return $this->edit($id);
            }
            else
            {
                $talentdictionary = Model_Talent_Dictionary::find_by_kode_talent_dictionary($id);
                $talentdictionary->rentang_performance_awal = $_POST['rentang_performance_awal'];
                $talentdictionary->rentang_performance_akhir = $_POST['rentang_performance_akhir'];
                $talentdictionary->rentang_potensi_awal = $_POST['rentang_potensi_awal'];
                $talentdictionary->rentang_potensi_akhir = $_POST['rentang_potensi_akhir'];
                $talentdictionary->color = $_POST['color'];

                $talentdictionary->save();
                if ($talentdictionary->is_invalid())
                {
                    $this->session->set_userdata('warning', $talentdictionary->errors->full_messages());
                    $this->session->set_userdata('talentdictionary', $talentdictionary);
                    return $this->edit($id);
                }
                else
                {
                    $this->session->set_flashdata('success', 'Sukses mengupdate data');
                    redirect('/talent/talentDictionary', 'location');
                }
            }

        }
    }

    // delete data
    public function destroy($id)
    {
        $talentdictionary = Model_Talent_Dictionary::find_by_kode_talent_dictionary($id);
        $talentdictionary->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/talent/talentDictionary', 'location');
    }

}