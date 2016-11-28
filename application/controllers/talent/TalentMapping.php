<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Talents.php';

class TalentMapping extends Talents {
    public $controller_name = "talentmapping";
    public function __construct()
    {
        parent::__construct();
        $this->load->driver('session');
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    }

    // show all data
    public function index()
    {
        $flash['success'] = $this->session->flashdata('success');
        $flash['warning'] = $this->session->flashdata('warning');
        redirect('talent/talentMapping/soft', 'location');
        // echo $this->load->blade('talents.mapping.index',
        //     array('flash'=>$flash, 'talentmapping' => Model_Acuan_Nilai_Soft_Kompetensi::all()));
    }

    public function Soft()
    {
    	$flash['success'] = $this->session->flashdata('success');
        $flash['warning'] = $this->session->flashdata('warning');
        $jenjangkkj = !empty($jenjangkkj) ? $jenjangkkj : Model_Acuan_Nilai_Soft_Kompetensi::allJenjangKKJ();
        // print_r($jenjangkkj);die;

        echo $this->load->blade('talents.mapping.soft.index',array('flash'=>$flash, 'jenjangkkj' => $jenjangkkj));

    }

    public function Hard()
    {
    	$flash['success'] = $this->session->flashdata('success');
        $flash['warning'] = $this->session->flashdata('warning');
        $jabatan = !empty($jabatan) ? $jabatan : Model_Acuan_Nilai_Hard_Kompetensi::allJabatan();

        echo $this->load->blade('talents.mapping.hard.index',
            array('flash'=>$flash, 'jabatan' => $jabatan));
    }

    public function createHard()
    {
        // select data kompetensi kemudian di assign ke object active record
        $kompetensi = !empty($kompetensi) ? $kompetensi : Model_Kompetensi::find('all', array('select' => 'kode_kompetensi, nama_kompetensi', 'conditions' => array('kategori = ?', 'bidang')));
        // select data jenjang kkj kemudian di assign ke object active record
        $jabatan = !empty($jabatan) ? $jabatan : Model_Jabatan::find('all', array('select' => 'kode_jabatan, nama_jabatan'));

        echo $this->load->blade('talents.mapping.hard.create',
        array('kompetensi' => $kompetensi, 'jabatan' => $jabatan, 'flashdata' => $error, 'method' => $method));
    }


    // show form soft
    public function createSoft()
    {
        // select data kompetensi kemudian di assign ke object active record
        $kompetensi = !empty($kompetensi) ? $kompetensi : Model_Kompetensi::find('all', array('select' => 'kode_kompetensi, nama_kompetensi', 'conditions' => array('kategori <> ?', 'bidang')));
        // select data jenjang kkj kemudian di assign ke object active record
        // $jenjangkkj = !empty($jenjangkkj) ? $jenjangkkj : Model_JenjangKkj::find('all', array('select' => 'kode_jenjang_kkj, nama_jenjang_kkj'));
        $jenjangkkj = !empty($jenjangkkj) ? $jenjangkkj : Model_JenjangKkj::get_data_kkj();

        echo $this->load->blade('talents.mapping.soft.create',
        array('kompetensi' => $kompetensi, 'jenjangkkj' => $jenjangkkj, 'flashdata' => $error, 'method' => $method));

    }

    // insert data
    public function storesoft()
    {
        $kode_jenjang_kkj = $this->input->post('kode_jenjang_kkj');
        $listkodekompetensi = array_unique($this->input->post('kode_kompetensi'));
        // print_r($listkodekompetensi);
        $listnilaikompetensi = $this->input->post('nilai_soft_kompetensi');
        $i = 0;
        // print_r(kode_jenjang_kkj);die;
        array_pop($listkodekompetensi);        
        // print_r($listkodekompetensi);
        foreach ($listkodekompetensi as $key => $value) {
            $post = array(
                'KODE_JENJANG_KKJ' => $kode_jenjang_kkj,
                'KODE_KOMPETENSI'  => $value,
                'NILAI'             => $listnilaikompetensi[$i],
                             );
            $i++;
            $acuanNilaiSoft = new Model_Acuan_Nilai_Soft_Kompetensi($post);

            if ($acuanNilaiSoft->is_valid()){
                $acuanNilaiSoft->save();
                $saveData = true;
            }
            else{
                $saveData = false;
            }
        }

        if ($saveData){
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/talent/TalentMapping/Soft', 'location');
        }
        else{
            if (!empty($post))
            {
                return $this->createSoft($acuanNilaiSoft, $acuanNilaiSoft->errors->full_messages(), 'store');
            }
            else
            {
                return $this->createSoft($acuanNilaiSoft);
            }
        }

    }

    // insert data
    public function storehard()
    {
        $kode_jabatan = $this->input->post('kode_jabatan');
        $listkodekompetensi = array_unique($this->input->post('kode_kompetensi'));
        $listnilaikompetensi = $this->input->post('nilai_hard_kompetensi');
        $i = 0;

        foreach ($listkodekompetensi as $key => $value) {
            $post = array(
                'KODE_JABATAN' => $kode_jabatan,
                'KODE_KOMPETENSI'  => $value,
                'NILAI' => $listnilaikompetensi[$i],
                             );
            $i++;
            $acuanNilaiHard = new Model_Acuan_Nilai_Hard_Kompetensi($post);
            // print_r($post);
            // print_r($acuanNilaiHard->is_valid());
            // print_r($acuanNilaiHard->errors->full_messages()); die;
            if ($acuanNilaiHard->is_valid())
            {
                $acuanNilaiHard->save();
                $saveData = true;
            }
            else
            {
                $saveData = false;
            }
        }
        if ($saveData)
        {
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/talent/TalentMapping/Hard', 'location');
        }
        else
        {
            if (!empty($post))
            {
                return $this->createHard($acuanNilaiHard, $acuanNilaiHard->errors->full_messages(), 'store');
            }
            else
            {
                return $this->createHard($acuanNilaiHard);
            }
        }
    }

    // show edit form
    public function editSoft($id)
    {
        $error = $this->session->userdata('warning');
        $soft = $this->session->userdata('soft');
        $soft = !empty($soft) ? $soft : Model_Acuan_Nilai_Soft_Kompetensi::find_by_kode_jenjang_kkj($id);
        $this->session->unset_userdata('soft');
        $this->session->unset_userdata('warning');
        var_dump($soft);


        //echo $this->load->blade('talents.mapping.soft.edit', array('data' => $soft, 'flashdata' => $error));
    }

    // show edit form
    public function editHard($id)
    {
        $error = $this->session->userdata('warning');
        $talentdictionary = $this->session->userdata('talentdictionary');
        $talentdictionary = !empty($talentdictionary) ? $talentdictionary : Model_Talent_Dictionary::find_by_kode_talent_dictionary($id);
        $this->session->unset_userdata('talentdictionary');
        $this->session->unset_userdata('warning');

        echo $this->load->blade('talents.dictionary.edit', array('data' => $talentdictionary, 'flashdata' => $error));
    }

    //update data
    public function updateSoft($id)
    {
        if (empty($_POST)){
            redirect('/talent/talentMapping/hard', 'location');
        }
        else
        {
            $soft = Model_Acuan_Nilai_Soft_Kompetensi::find_by_kode_jenjang_kkj($id);
            //not yet
            /*
            $soft->rentang_performansi_awal = $_POST['rentang_performansi_awal'];
            $soft->rentang_performansi_akhir = $_POST['rentang_performansi_akhir'];
			$soft->rentang_potensi_awal = $_POST['rentang_potensi_awal'];
			$soft->rentang_potensi_akhir = $_POST['rentang_potensi_akhir'];
            */
            $soft->save();
            if ($soft->is_invalid())
            {
                $this->session->set_userdata('warning', $soft->errors->full_messages());
                $this->session->set_userdata('talentdictionary', $talentdictionary);
                return $this->edit($id);
            }
            else{
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/talent/talentMapping/hard', 'location');
            }
        }
    }

    //update data
    public function updateHard($id)
    {
        if (empty($_POST)){
            redirect('/talent/talentMapping/hard', 'location');
        }
        else
        {
            $hard = Model_Acuan_Nilai_Hard_Kompetensi::find_by_kode_jabatan($id);
            /*
            $hard->rentang_performansi_awal = $_POST['rentang_performansi_awal'];
            $hard->rentang_performansi_akhir = $_POST['rentang_performansi_akhir'];
            $hard->rentang_potensi_awal = $_POST['rentang_potensi_awal'];
            $hard->rentang_potensi_akhir = $_POST['rentang_potensi_akhir'];
            */
            $hard->save();
            if ($hard->is_invalid())
            {
                $this->session->set_userdata('warning', $hard->errors->full_messages());
                $this->session->set_userdata('talentdictionary', $talentdictionary);
                return $this->edit($id);
            }
            else{
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/talent/talentMapping/hard', 'location');
            }
        }
    }


    // delete data
    public function destroySoft($id)
    {
        // $id = intval($id);
        // $soft = Model_Acuan_Nilai_Soft_Kompetensi::find_by_kode_jenjang_kkj($id);
        Model_Acuan_Nilai_Soft_Kompetensi::delete_all(array('conditions' => array('kode_jenjang_kkj' => $id)));
        // $soft->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/talent/talentMapping/soft', 'location');
    }

    // delete data
    public function destroyHard($id)
    {
        // $hard = Model_Acuan_Nilai_Hard_Kompetensi::find_by_kode_jabatan($id);
        // $hard->delete();
        Model_Acuan_Nilai_Hard_Kompetensi::delete_all(array('conditions' => array('kode_jabatan' => $id)));
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/talent/talentMapping/hard', 'location');
    }

        //file upload
    public function fileupload($kriteria = '')
    {
        $storage = new \Upload\Storage\FileSystem(APPPATH.'storage');
        $file = new \Upload\File('file', $storage);
        $new_filename = uniqid();
        $file->setName($new_filename);

        // Try to upload file
        try {
            // Success!
            $file->upload();
        } catch (\Exception $e) {
            $this->session->set_flashdata('warning', 'Type file harus berbentuk excel.');
            if ($kriteria == 'soft')
            {
                redirect('/talent/talentMapping/soft', 'location');
            }
            elseif ($kriteria=='hard')
            {
                redirect('/talent/talentMapping/hard', 'location');
            }

        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension(), $kriteria);
        if ($kriteria == 'soft')
        {
            echo $this->load->blade('talents.mapping.soft.excel', array('data' => $data));
        }
        elseif ($kriteria=='hard')
        {
            echo $this->load->blade('talents.mapping.hard.excel', array('data' => $data));
        }
        //echo $this->load->blade('master.grades.excel', array('data' => $data));

    }

    private function process($filename = '', $kriteria)
    {
        $objPHPExcel    = PHPExcel_IOFactory::load($filename);
        $objWorksheet   = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow     = $objWorksheet->getHighestRow();
        $arrShow        = array();
        //untuk soft kompetensi
        if ($kriteria == 'soft')
        {
            for ($row = 1; $row <= $highestRow; ++ $row)
            {
                // read from row 4
                if ($row > 1)
                {
                    $nama_jenjang_kkj   = $objWorksheet->getCellByColumnAndRow(0, $row);
                    $nm                 = Model_JenjangKkj::find_by_nama_jenjang_kkj($nama_jenjang_kkj->getValue());                 
                    foreach ($nm as $key => $value) {
                        $kode_jabatan   = $value->kode_jabatan;
                    } 
                    $kode_kompetensi = $objWorksheet->getCellByColumnAndRow(1, $row);
                    $nilai = $objWorksheet->getCellByColumnAndRow(2, $row);
                    if ($kode_jenjang_kkj->getValue()!= '' || $kode_jenjang_kkj->getValue() != null)
                    {
                        $data = array(
                            'kode_jenjang_kkj' => $kode_jenjang_kkj,
                            'kode_kompetensi' => $kode_kompetensi->getValue(),
                            'nilai' => $nilai->getValue(),
                            );
                        $obj = new Model_Acuan_Nilai_Soft_Kompetensi($data);
                        if ($obj->is_valid())
                        {
                            try
                            {
                                $obj->save();
                            }
                            catch (Exception $e) {

                            }
                        }
                    $arrShow[]  = $obj;
                    }
                }
            }
        }
        //untuk hard kompetensi
        elseif ($kriteria == 'hard'){
            for ($row = 1; $row <= $highestRow; ++ $row){
                // read from row 4
                if ($row > 1){
                    $nama_jabatan = $objWorksheet->getCellByColumnAndRow(0, $row);   
                    $nm           = Model_Jabatan::find_by_nama_jabatan($nama_jabatan->getValue());                 
                    foreach ($nm as $key => $value) {
                        $kode_jabatan  = $value->kode_jabatan;
                    } 
                    $kode_kompetensi = $objWorksheet->getCellByColumnAndRow(1, $row);
                    $nilai = $objWorksheet->getCellByColumnAndRow(2, $row);
                    if ($kode_jabatan->getValue()!= '' || $kode_jabatan->getValue() != null){
                        $data = array(
                            'kode_jabatan' => $kode_jabatan,
                            'kode_kompetensi' => $kode_kompetensi->getValue(),
                            'nilai' => $nilai->getValue(),
                        );

                        $obj = new Model_Acuan_Nilai_Hard_Kompetensi($data);

                        if ($obj->is_valid()){
                            try
                            {
                                $obj->save();
                            }
                            catch (Exception $e) {

                            }
                        }

                        $arrShow[]  = $obj;
                    }
                }
            }
        }
        return $arrShow;
    }

    public function saveupload($kriteria){

        $post = $this->input->post('data');
        $has_invalid = false;
        $data = array();
        if ($kriteria == 'soft'){
            foreach ($post as $value){
                $obj = new Model_Acuan_Nilai_Soft_Kompetensi($value);
                if ($obj->is_invalid()){
                    $has_invalid = true;
                }
                $data[] = $obj;
            }
            if ($has_invalid){
                echo $this->load->blade('talents.mapping.soft.excel', array('data' => $data));
            }
            else{
                foreach ($data as $value){
                    $value->save();
                }
                $this->session->set_flashdata('success', 'Sukses menyimpan data');
                redirect('/talent/talentMapping/soft', 'location');
            }
        }
        elseif ($kriteria == 'hard'){
            foreach ($post as $value){
                $obj = new Model_Acuan_Nilai_Hard_Kompetensi($value);
                if ($obj->is_invalid()){
                    $has_invalid = true;
                }
                $data[] = $obj;
            }
            if ($has_invalid){
                echo $this->load->blade('talents.mapping.hard.excel', array('data' => $data));
            }
            else{
                foreach ($data as $value){
                    $value->save();
                }
                $this->session->set_flashdata('success', 'Sukses menyimpan data');
                redirect('/talent/talentMapping/hard', 'location');
            }
        }

    }

}