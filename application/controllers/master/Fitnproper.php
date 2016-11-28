<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Masters.php';

class Fitnproper extends Masters {

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
        echo $this->load->blade('master.fitnproper.index',
            array('flash'=>$flash, 'data' => SoalFitProper::all()));
    }

    // show form
    public function create($data = null, $error = null, $method = "create", $kat = '')
    {
        $data = isset($data) ? $data : new SoalFitProper();
        $kompetensi = SoalFitProper::get_kompetensi();
        if ($method != 'create'){
            $data->list_kompetensi = Kompetensi::get_kode_map($kat);
        }
        echo $this->load->blade('master.fitnproper.create',
            array(
                'data' => $data, 
                'kompetensi' => $kompetensi, 
                'flashdata' => $error, 
                'method' => $method
            )
        );
    }

    // insert data
    public function store()
    {
    //     print_r(Kompetensi::get_kode_map());die;
        $post = $_POST; unset($post['_token']);unset($post['kategori_kompetensi']);
        $data = new SoalFitProper($post);
        if ($data->is_valid())
        {
            $data->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/fitnproper', 'location');
        }
        else
        {   if (!empty($post))
            {
                return $this->create($data, $data->errors->full_messages(), 'store', $_POST['kategori_kompetensi']);
            }
            else
            {
                return $this->create($data);
            }
        }
    }

    // show edit form
    public function edit($id,  $method = "edit", $kat = '')
    {
        $error = $this->session->userdata('warning');
        $data = $this->session->userdata('grade');
        $data = SoalFitProper::find_by_kode_soal($id);
        if ($method != 'edit'){
            $data->list_kompetensi = array($data->kode_kompetensi => $data->kode_kompetensi);
        }else{
            $data->list_kompetensi = array($data->kode_kompetensi => $data->kode_kompetensi);
        }
        $this->session->unset_userdata('grade');
        $this->session->unset_userdata('warning');
        echo $this->load->blade('master.fitnproper.edit',
            array('data' => $data, 'flashdata' => $error, 'method' => $method));
    }

    //update data
    public function update($id)
    {
        if (empty($_POST)){
            redirect('/master/fitnproper', 'location');
        }
        else
        {
            $data = SoalFitProper::find_by_kode_soal($id);
            $post = $_POST; unset($post['_token']);unset($post['kategori_kompetensi']);
            $data->update_attributes($post);
            if ($data->is_invalid())
            {
                $this->session->set_userdata('warning', $data->errors->full_messages());
                $this->session->set_userdata('grade', $data);
                return $this->edit($id, 'update', $_POST['kode_kompetensi']);
            }
            else{
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/master/fitnproper', 'location');
            }
        }
    }

    // delete data
    public function destroy($id)
    {
        $kompetensi = SoalFitProper::find_by_kode_soal($id);
        $kompetensi->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/master/fitnproper', 'location');
    }

    public function ajax($data)
    {
        $data = Kompetensi::get_kode_map($data);
        echo $this->load->blade('master.fitnproper.ajax', array('data'=> $data));
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
            redirect('/master/fitnproper', 'location');
        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        echo $this->load->blade('master.fitnproper.excel', array('data' => $data));
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
                $kode     = $objWorksheet->getCellByColumnAndRow(0, $row);
                $kategori = $objWorksheet->getCellByColumnAndRow(1, $row);

                if ($kode->getValue()!= '' || $kode->getValue() != null){
                    $data = array(
                        'kode_kompetensi' => $kode->getValue(),
                        'soal' => $kategori->getValue(),
                    );

                    $obj        = new SoalFitProper($data);
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
            $obj = new SoalFitProper($value);
            if ($obj->is_invalid())
            {
                $has_invalid = true;
            }
            $data[] = $obj;
        }

        if ($has_invalid)
        {
            echo $this->load->blade('master.fitnproper.excel', array('data' => $data));
        }
        else
        {
            foreach ($data as $value) {
                $value->save();
            }
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/fitnproper', 'location');
        }
    }


}