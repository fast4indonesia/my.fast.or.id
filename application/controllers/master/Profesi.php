<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Masters.php';

class Profesi extends Masters {
    public $controller_name = "profesi";
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
        echo $this->load->blade('master.profesi.index',
        array('flash'=>$flash, 'profesi' => Model_Profesi::all()));
    }

    // show form
    public function create($profesi = null, $error = null, $method = "create")
    {
        $profesi = isset($profesi) ? $profesi : new Model_Profesi();
        echo $this->load->blade('master.profesi.create', array('data' => $profesi ,'flashdata' => $error, 'method' => $method)); 
    }

    // insert data
    public function store()
    {
        $post = $_POST; unset($post['_token']);
        $profesi = new Model_Profesi($post);
        if ($profesi->is_valid())
        {
            $profesi->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/profesi', 'location');
        }
        else
        {   if (!empty($post))
            {
                return $this->create($profesi, $profesi->errors->full_messages(), 'store');
            }
            else
            {
                return $this->create($profesi);
            }
        }
    }

    // show edit form
    public function edit($id)
    {
        $error = $this->session->userdata('warning');
        $profesi = $this->session->userdata('profesi');
        $profesi = !empty($profesi) ? $profesi : Model_Profesi::find_by_kode_profesi($id);
        $this->session->unset_userdata('profesi');
        $this->session->unset_userdata('warning');
        echo $this->load->blade('master.profesi.edit',
            array('data' => $profesi, 'flashdata' => $error));
    }

    //update data
    public function update($id)
    {
        if (empty($_POST)){
            redirect('/master/profesi', 'location');
        }
        else
        {
            //$id = $this->input->post('kode_profesi');
            $profesi = Model_Profesi::find_by_kode_profesi($id);

            $profesi->nama_profesi =  $_POST['nama_profesi'];
            $profesi->save();
            if ($profesi->is_invalid())
            {
                $this->session->set_userdata('warning', $profesi->errors->full_messages());
                $this->session->set_userdata('profesi', $profesi);
                return $this->edit($id);
            }
            else{
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/master/profesi', 'location');
            }

        }
    }

    // delete data
    public function destroy($id)
    {
        $profesi = !empty($profesi) ? $profesi : Model_Profesi::find_by_kode_profesi($id);
        $profesi->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/master/profesi', 'location');
    }

    public function fileupload(){
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
            redirect('/master/profesi', 'location');
        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        echo $this->load->blade('master.profesi.excel', array('data' => $data));
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
            if ($row > 3)
            {
                $kode = $objWorksheet->getCellByColumnAndRow(0, $row);
                $nama = $objWorksheet->getCellByColumnAndRow(1, $row);
                if ($kode->getValue()!= '' || $kode->getValue() != null){
                    $data = array('kode_profesi' => $kode->getValue(),
                        'nama_profesi' => $nama->getValue());


                    $obj        = new Model_Profesi($data);
                    if ($obj->is_valid())
                    {
                        try {
                            $obj->save();
                        } catch (Exception $e) {

                        }
                    }
                    $arrShow[]  = $obj;
                }
            }
        }
        return $arrShow;
    }

    public function saveupload()
    {
        $post = $_POST['data'];
        $has_invalid = false;
        $data = array();
        foreach ($post as $value) {
            $obj = new Model_Profesi($value);
            if ($obj->is_invalid())
            {
                $has_invalid = true;
            }
            $data[] = $obj;
        }

        if ($has_invalid)
        {
            echo $this->load->blade('master.profesi.excel', array('data' => $data));
        }
        else
        {
            foreach ($data as $value) {
                $value->save();
            }
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/profesi', 'location');
        }
    }


}