<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Masters.php';

class Sertifikasi extends Masters {
    public $controller_name = 'sertifikasi';
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
        echo $this->load->blade('master.sertifikasi.index',
            array('flash'=>$flash, 'sertifikasi' => Model_Sertifikasi::all()));
    }

    // show form
    public function create($sertifikasi = null, $error = null, $method = "create")
    {
        $sertifikasi = isset($sertifikasi) ? $sertifikasi : new Model_Sertifikasi();
        //$listkompetensi = Kompetensi::select_all();
        echo $this->load->blade('master.sertifikasi.create',array('data' => $sertifikasi, 'flashdata' => $error, 'method' => $method));
    }

    // insert data
    public function store()
    {
        $post = $_POST; unset($post['_token']);
        $sertifikasi = new Model_Sertifikasi($post);
        if ($sertifikasi->is_valid())
        {
            $sertifikasi->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/sertifikasi', 'location');
        }
        else
        {   if (!empty($post))
            {
                return $this->create($sertifikasi, $sertifikasi->errors->full_messages(), 'store');
            }
            else
            {
                return $this->create($sertifikasi);
            }
        }
    }

    // show edit form
    public function edit($id)
    {
        $error = $this->session->userdata('warning');
        $sertifikasi = $this->session->userdata('sertifikasi');
        $sertifikasi = !empty($sertifikasi) ? $sertifikasi : Model_Sertifikasi::find_by_kode_sertifikasi($id);
        $this->session->unset_userdata('sertifikasi');
        $this->session->unset_userdata('warning');
        //$listkompetensi = Kompetensi::select_all();
        echo $this->load->blade('master.sertifikasi.edit',
            array('data' => $sertifikasi, 'flashdata' => $error));
    }

    //update data
    public function update($id)
    {
        if (empty($_POST)){
            redirect('/master/sertifikasi', 'location');
        }
        else
        {
            $sertifikasi = Model_Sertifikasi::find_by_kode_sertifikasi($id);
            $sertifikasi->unit_kompetensi = $_POST['unit_kompetensi'];
            $sertifikasi->masa_berlaku = $_POST['masa_berlaku'];
            $sertifikasi->save();
            if ($sertifikasi->is_invalid())
            {
                $this->session->set_userdata('warning', $sertifikasi->errors->full_messages());
                $this->session->set_userdata('sertifikasi', $sertifikasi);
                return $this->edit($id);
            }
            else{
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/master/sertifikasi', 'location');
            }
        }
    }

    // delete data
    public function destroy($id)
    {
        $sertifikasi = Model_Sertifikasi::find_by_kode_sertifikasi($id);
        $sertifikasi->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/master/sertifikasi', 'location');
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
            redirect('/master/sertifikasi', 'location');
        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        echo $this->load->blade('master.sertifikasi.excel', array('data' => $data));
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
                $kode_sertifikasi = $objWorksheet->getCellByColumnAndRow(0, $row);
                $unit_kompetensi = $objWorksheet->getCellByColumnAndRow(1, $row);
                $masa_berlaku = $objWorksheet->getCellByColumnAndRow(2, $row);
                if ($kode_sertifikasi->getValue()!= '' || $kode_sertifikasi->getValue() != null){
                    $data = array('kode_sertifikasi' => $kode_sertifikasi->getValue(),
                        'unit_kompetensi' => $unit_kompetensi->getValue(),
                        'masa_berlaku' => $masa_berlaku->getValue(),
                        );


                    $obj        = new Model_Sertifikasi($data);
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
            $obj = new Model_Sertifikasi($value);
            if ($obj->is_invalid())
            {
                $has_invalid = true;
            }
            $data[] = $obj;
        }

        if ($has_invalid)
        {
            echo $this->load->blade('master.sertifikasi.excel', array('data' => $data));
        }
        else
        {
            foreach ($data as $value) {
                $value->save();
            }
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/sertifikasi', 'location');
        }
    }

}