<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Masters.php';

class Evaluation extends Masters {

    private $flash;
    public function __construct()
    {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->driver('session');
        // if (Model_Jadwal::this_semester() == null)
        // {
        //     echo $this->load->blade('evaluations.error_access');
        //     die;
        // }
        $this->flash['success'] = $this->session->flashdata('success');
        $this->flash['warning'] = $this->session->flashdata('warning');
    }

    // show all data
    public function index()
    {
        // print_r(Model_Employee::first()->this_soft_to_array());die;
        echo $this->load->blade('master.evaluation.index',
            array(
                'flash'=>$this->flash,
                'data' => Model_Assessment_Psikolog::all(),
                'kompetensi' => Model_Kompetensi::all_soft(),
                'employee' => Model_Employee::all()
            ));
    }

    public function create()
    {
        echo $this->load->blade('master.evaluation.create',
            array(
                'employee'=>Model_Employee::select_list()
            ));
    }

    public function ajax($nipeg)
    {
        $em = Model_Employee::find_by_nipeg($nipeg);
        echo $em->get_kriteria_penilaian()->to_json();
    }

    public function store()
    {
        $post = $_POST;
        $em = Model_Employee::find_by_nipeg($post['nama_karyawan']);
        if($em == null)
        {
            $this->session->set_flashdata('warning', 'Pegawai tidak ditemukan.');
            redirect('/master/evaluation', 'location');
        }

        $kriteria = Model_Penilaian_Kriteria_Talent::find_by_nipeg_and_periode_and_tahun($post['nama_karyawan'], $post['periode'], $post['tahun']);
        if ($kriteria == null)
        {
            $kriteria = new Model_Penilaian_Kriteria_Talent();
            $kriteria->nipeg = $em->nipeg;
            // $kriteria->kode_jadwal = Model_Jadwal::this_semester()->kode_jadwal;
            $kriteria->tahun = $post['tahun'];
            $kriteria->periode = $post['periode'];
            $kriteria->save();
        }

        // print_r($post);die;
        $kriteria->update_attributes($post['kompetensi']);
        $this->session->set_flashdata('success', 'Sukses menginput data.');
        redirect('/master/evaluation', 'location');
    }

}