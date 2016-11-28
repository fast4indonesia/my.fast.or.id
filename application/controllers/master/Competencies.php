<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Masters.php';

class Competencies extends Masters {

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
        echo $this->load->blade('master.competencies.index',
            array('flash'=>$flash, 'data' => Kompetensi::all()));
    }

    // show form
    public function create($data = null, $error = null, $method = "create")
    {
        $data = isset($data) ? $data : new Kompetensi();
        echo $this->load->blade('master.competencies.create',
            array('data' => $data, 'flashdata' => $error, 'method' => $method));
    }

    // insert data
    public function store()
    {
        $post = $_POST; unset($post['_token']);
        $data = new Kompetensi($post);
        // print_r($data->is_valid());die;
        if ($data->is_valid())
        {
            if($data->kategori != 'bidang')
            {
                $data->level_5 = null;
                $data->level_6 = null;
            }
            else{
                $data->level_0 = null;
            }

            $data->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/competencies', 'location');
        }
        else
        {   if (!empty($post))
            {
                return $this->create($data, $data->errors->full_messages(), 'store');
            }
            else
            {
                return $this->create($data);
            }
        }
    }

    // show edit form
    public function edit($id,  $method = "edit")
    {
        $error = $this->session->userdata('warning');
        $data = $this->session->userdata('grade');
        $data = !empty($data) ? $data : Kompetensi::find_by_kode_kompetensi($id);
        if ($data->kategori == 'bidang')
        {
            $data->default_hide = array('level_0');
        }else{
            $data->default_hide = array('level_5', 'level_6');
        }
        $this->session->unset_userdata('grade');
        $this->session->unset_userdata('warning');
        echo $this->load->blade('master.competencies.edit',
            array('data' => $data, 'flashdata' => $error, 'method' => $method));
    }

    //update data
    public function update($id)
    {
        if (empty($_POST)){
            redirect('/master/competencies', 'location');
        }
        else
        {
            $data = Kompetensi::find_by_kode_kompetensi($id);
            $post = $_POST; unset($post['_token']);
            $data->update_attributes($post);
            // $data->save();
            if ($data->is_invalid())
            {
                $this->session->set_userdata('warning', $data->errors->full_messages());
                $this->session->set_userdata('grade', $data);
                return $this->edit($id, 'update');
            }
            else{
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/master/competencies', 'location');
            }
        }
    }

    // delete data
    public function destroy($id)
    {
        $kompetensi = Kompetensi::find_by_kode_kompetensi($id);
        $kompetensi->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/master/competencies', 'location');
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
            redirect('/master/competencies', 'location');
        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        echo $this->load->blade('master.competencies.excel', array('data' => $data));
    }

    private function process($filename = '')
    {
        $objPHPExcel    = PHPExcel_IOFactory::load($filename);
        $objWorksheet   = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow     = $objWorksheet->getHighestRow();
        $arrShow        = array();
        for ($row = 1; $row <= $highestRow; ++ $row)
        {
            // read from row 4
            if ($row > 1){

                $kode       = $objWorksheet->getCellByColumnAndRow(0, $row);
                $nama       = $objWorksheet->getCellByColumnAndRow(1, $row);
                $kategori   = $objWorksheet->getCellByColumnAndRow(2, $row);
                $deskripsi  = $objWorksheet->getCellByColumnAndRow(3, $row);
                $level0     = $objWorksheet->getCellByColumnAndRow(4, $row);
                $level1     = $objWorksheet->getCellByColumnAndRow(5, $row);
                $level2     = $objWorksheet->getCellByColumnAndRow(6, $row);
                $level3     = $objWorksheet->getCellByColumnAndRow(7, $row);
                $level4     = $objWorksheet->getCellByColumnAndRow(8, $row);
                $level5     = $objWorksheet->getCellByColumnAndRow(9, $row);
                $level6     = $objWorksheet->getCellByColumnAndRow(10, $row);
                if ($kode->getValue()!= '' || $kode->getValue() != null){
                    $data = array(
                        'kode_kompetensi' => $kode->getValue(),
                        'nama_kompetensi' => $nama->getValue(),
                        'kategori' => $kategori->getValue(),
                        'deskripsi' => $deskripsi->getValue(),
                        'level_0' => $level0->getValue(),
                        'level_1' => $level1->getValue(),
                        'level_2' => $level2->getValue(),
                        'level_3' => $level3->getValue(),
                        'level_4' => $level4->getValue(),
                        'level_5' => $level5->getValue(),
                        'level_6' => $level6->getValue()
                    );

                    $obj        = new Kompetensi($data);
                    // $obj->save();
                    // print_r($obj);

                    if ($obj->is_valid()){
                        if ($obj->kategori != 'bidang'){
                            $obj->level_6 = null;
                            $obj->level_5 = null;
                        }else{
                            $obj->level_0 = null;
                        }
                        try {
                            $obj->save();
                        } catch (Exception $e) {

                        }
                    }else{
                        
                    }
                    $arrShow[]  = $obj;
                }
            }
        }
        unlink($filename);
        return $arrShow;
    }

    public function saveupload(){
        $post = $_POST['data'];
        $has_invalid = false;
        $data = array();
        foreach ($post as $value) {
            $obj = new Kompetensi($value);
            if ($obj->is_invalid())
            {
                $has_invalid = true;
            }
            $data[] = $obj;
        }

        if ($has_invalid)
        {
            echo $this->load->blade('master.competencies.excel', array('data' => $data));
        }
        else
        {
            foreach ($data as $value) {
                if ($value->kategori != 'bidang'){
                    $value->level_6 = null;
                    $value->level_5 = null;
                }else{
                    $value->level_0 = null;
                }
                $value->save();
            }
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/competencies', 'location');
        }
    }


}