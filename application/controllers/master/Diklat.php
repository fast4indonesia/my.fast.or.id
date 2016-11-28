<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Masters.php';

class Diklat extends Masters {

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
        echo $this->load->blade('master.diklat.index',
            array('flash'=>$flash, 'diklat' => Model_Diklat::all()));
    }

    // show form
    public function create($diklat = null, $error = null, $method = "create")
    {
        $diklat = isset($diklat) ? $diklat : new Model_Diklat();
        echo $this->load->blade('master.diklat.create',
        array('data' => $diklat, 'flashdata' => $error, 'method' => $method));
    }

    // insert data
    public function store()
    {
        $post = $_POST; unset($post['_token']);
        $diklat = new Model_Diklat($post);
        if ($diklat->is_valid())
        {
            $diklat->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/diklat', 'location');
        }
        else
        {   if (!empty($post))
            {
                return $this->create($diklat, $diklat->errors->full_messages(), 'store');
            }
            else
            {
                return $this->create($diklat);
            }
        }
    }

    // show edit form
    public function edit($id)
    {
        $error = $this->session->userdata('warning');
        $diklat = $this->session->userdata('diklat');
        $diklat = !empty($diklat) ? $diklat : Model_Diklat::find_by_kode_diklat($id);
        $this->session->unset_userdata('diklat');
        $this->session->unset_userdata('warning');
        echo $this->load->blade('master.diklat.edit',
            array('data' => $diklat, 'flashdata' => $error));
    }

    //update data
    public function update($id)
    {
        if (empty($_POST)){
            redirect('/master/diklat', 'location');
        }
        else
        {
            $diklat = Model_Diklat::find_by_kode_diklat($id);
            $diklat->nama_diklat = $_POST['nama_diklat'];
            $diklat->jenis_diklat = $_POST['jenis_diklat'];
            $diklat->masa_berlaku = $_POST['masa_berlaku'];
            $diklat->save();
            if ($diklat->is_invalid())
            {
                $this->session->set_userdata('warning', $diklat->errors->full_messages());
                $this->session->set_userdata('diklat', $diklat);
                return $this->edit($id);
            }
            else{
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/master/diklat', 'location');
            }
        }
    }

    // delete data
    public function destroy($id)
    {
        $diklat = Model_Diklat::find_by_kode_diklat($id);
        $diklat->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/master/diklat', 'location');
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
            redirect('/master/diklat', 'location');
        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        echo $this->load->blade('master.diklat.excel', array('data' => $data));
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
                $kode_diklat = $objWorksheet->getCellByColumnAndRow(0, $row);
                $nama_diklat = $objWorksheet->getCellByColumnAndRow(1, $row);
                $jenis_diklat = $objWorksheet->getCellByColumnAndRow(2, $row);
                $masa_berlaku = $objWorksheet->getCellByColumnAndRow(3, $row);
                if ($kode_diklat->getValue()!= '' || $kode_diklat->getValue() != null){
                    $data = array(
                    	'kode_diklat' => $kode_diklat->getValue(),
                        'nama_diklat' => $nama_diklat->getValue(),
                        'jenis_diklat' => $jenis_diklat->getValue(),
                        'masa_berlaku' => $masa_berlaku->getValue(),
                        );


                    $obj        = new Model_Diklat($data);
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
        unlink($filename);
        return $arrShow;
    }

    public function saveupload()
    {
        $post = $_POST['data'];
        $has_invalid = false;
        $data = array();
        foreach ($post as $value) {
            $obj = new Model_Diklat($value);
            if ($obj->is_invalid())
            {
                $has_invalid = true;
            }
            $data[] = $obj;
        }

        if ($has_invalid)
        {
            echo $this->load->blade('master.diklat.excel', array('data' => $data));
        }
        else
        {
            foreach ($data as $value) {
                $value->save();
            }
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/diklat', 'location');
        }
    }

}