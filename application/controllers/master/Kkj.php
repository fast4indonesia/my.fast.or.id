<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Masters.php';

class Kkj extends Masters {

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
        echo $this->load->blade('master.kkj.index',
            array(
                'flash'=>$flash, 
                'kkjs' => JenjangKkj::all_data()
            )
        );
	}

	// show form
    public function create($data = null, $error = null, $method = 'create'){

        $listprofesi        = Model_Profesi::select_all();
        $listjenjangjabatan = Model_Jenjang_Jabatan::select_all();
        $jabatan            = !empty($jabatan) ? $jabatan : Model_Jabatan::find('all', array('select' => 'kode_jabatan, nama_jabatan'));

        $data = isset($data) ? $data : new JenjangKkj();
        echo $this->load->blade('master.kkj.create',
            array(
                'data' => $data, 
                'flashdata' => $error,
                'listprofesi' => $listprofesi, 
                'listjenjangjabatan' => $listjenjangjabatan,  
                'jabatan' => $jabatan,  
                'method' => $method 
            )
        );
    }

	// insert data
    public function store(){

        // $post = $_POST; unset($post['_token']);     
        $nama_jenjang_kkj   = $this->input->post('nama_jenjang_kkj');   
        $jenjang_jabatan    = $this->input->post('jenjang_jabatan');   
        $kode_jenjang_kkj   = date('mdY_hia');
        $kodejabatan = array_unique($this->input->post('jabatan'));
        $i = 0;
        foreach ($kodejabatan as $key => $value) {
            $post = array(
                'NAMA_JENJANG_KKJ' => $nama_jenjang_kkj,
                'KODE_JENJANG_KKJ' => $kode_jenjang_kkj,
                'KODE_JABATAN'  => $value,
                'JENJANG_JABATAN'  => $jenjang_jabatan,
             );
            $i++;
            $mappingkkj = new JenjangKkj($post);
            if ($mappingkkj->is_valid()){
                $mappingkkj->save();
                $saveData = true;
            }
            else{
                $saveData = false;
            }
        }
        // $data = new JenjangKkj($post);

        if ($saveData){
            // $data->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/kkj', 'location');
        }
        else{   
            if (!empty($post)){
                return $this->create($mappingkkj, $mappingkkj->errors->full_messages(), 'store');
            }
            else{
                return $this->create($mappingkkj);
            }
        }
    }

	// show edit form
    public function edit($id)
    {
        $error = $this->session->userdata('warning');
        $data = $this->session->userdata('data');
        $data = !empty($data) ? $data : JenjangKkj::find_by_kode_kkj($id);
        $this->session->unset_userdata('data');
        $this->session->unset_userdata('warning');
        echo $this->load->blade('master.kkj.edit',
            array('data' => $data, 'flashdata' => $error));
    }

    //update data
    public function update($id)
    {
        if (empty($_POST)){
            redirect('/master/kkj', 'location');
        }
        else
        {
            $data = JenjangKkj::find_by_kode_jenjang_kkj($id);
            $data->nama_jenjang_kkj = $_POST['nama_jenjang_kkj'];
            $data->save();
            if ($data->is_invalid())
            {
                $this->session->set_userdata('warning', $data->errors->full_messages());
                $this->session->set_userdata('data', $data);
                return $this->edit($id);
            }
            else{
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/master/kkj', 'location');
            }
        }
    }

    // delete data
    public function destroy($id)
    {
        $data = JenjangKkj::find_by_kode_kkj($id);
        $data->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/master/kkj', 'location');
    }

    //file upload
    public function fileupload()
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
            redirect('/master/kkj', 'location');
        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        echo $this->load->blade('master.kkj.excel', array('data' => $data));
    }

    private function process($filename = ''){
        $objPHPExcel    = PHPExcel_IOFactory::load($filename);
        $objWorksheet   = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow     = $objWorksheet->getHighestRow();
        $arrShow        = array();
        $no_cek         = 1;
        for ($row = 1; $row <= $highestRow; ++ $row){
            // read from row 4
            if ($row > 1){
                $nama_jenjang_kkj = $objWorksheet->getCellByColumnAndRow(0, $row);
                $nama_jabatan     = $objWorksheet->getCellByColumnAndRow(1, $row);
                $nj               = Model_Jabatan::find_by_nama_jabatan($nama_jabatan->getValue());
                foreach ($nj as $key => $value) {
                    $kodejabatan  = $value->kodejabatan;
                } 
                if ($no_cek == 1){
                    $kode_jenjang_kkj = date('mdY_hia');
                }else{
                    $kode_jenjang_kkj = $waktu;
                }
                if ($kode->getValue()!= '' || $kode->getValue() != null){
                    $data = array(
                        'nama_jenjang_kkj' => $kode->getValue(),
                        'kode_jabatan' => $kode_jabatan,
                        'kode_jenjang_kkj' => $kode_jenjang_kkj
                    );


                    $obj        = new JenjangKkj($data);
                    if ($obj->is_valid()){
                        try {
                            $obj->save();
                        } catch (Exception $e) {

                        }
                    }
                    $arrShow[]  = $obj;
                }
            }
            $waktu = $kode_jenjang_kkj;
        }
        unlink($filename);
        return $arrShow;
    }

    public function saveupload(){
        $post = $_POST['kkj'];
        $has_invalid = false;
        $data = array();
        foreach ($post as $value) {
            $obj = new JenjangKkj($value);
            if ($obj->is_invalid())
            {
                $has_invalid = true;
            }
            $data[] = $obj;
        }

        if ($has_invalid)
        {
            echo $this->load->blade('master.kkj.excel', array('data' => $data));
        }
        else
        {
            foreach ($data as $value) {
                $value->save();
            }
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/kkj', 'location');
        }
    }

}