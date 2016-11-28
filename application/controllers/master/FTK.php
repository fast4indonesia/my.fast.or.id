<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Masters.php';

class Ftk extends Masters {
    public $controller_name = 'ftk';
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
        echo $this->load->blade('master.ftk.index',
            array('flash'=>$flash, 'data' => Model_Ftk::allData()));

        // $listkantor = Model_Kantor::select_all();
        // // $namakantor = Model_Kantor::find_name($id);
        // $listjabatan = Model_Jabatan::select_all();
        // // $namajabatan = Model_Jabatan::find_name($id);        
        // echo $this->load->blade('master.ftk.index',
        //     array('flash'=>$flash,'listkantor' => $listkantor, 'listjabatan' => $listjabatan, 'ftk' => Model_Ftk::all()));
    }

    // show form
    public function create($ftk = null, $error = null, $method = "create")
    {
        $listkantor = Model_Kantor::select_all();
        $listjabatan = Model_Jabatan::select_all();

        $ftk = isset($ftk) ? $ftk : new Model_FTK();
        echo $this->load->blade('master.ftk.create',array('data' => $ftk, 'flashdata' => $error, 'listkantor' => $listkantor, 'listjabatan' => $listjabatan, 'method' => $method));
    }

    // insert data
    public function store()
    {
        $post = $_POST; unset($post['_token']);
        $ftk = new Model_Ftk($post);
        if ($ftk->is_valid())
        {
            $ftk->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/ftk', 'location');
        }
        else
        {   if (!empty($post))
            {
                return $this->create($ftk, $ftk->errors->full_messages(), 'store');
            }
            else
            {
                return $this->create($ftk);
            }
        }
    }

    // show edit form
    public function edit($id)
    {
        $error = $this->session->userdata('warning');
        $ftk = $this->session->userdata('ftk');
        $ftk = !empty($ftk) ? $ftk : Model_Ftk::find_by_kode_ftk($id);
        $listkantor = Model_Kantor::select_all();
        // $namakantor = Model_Kantor::find_name($id);
        $listjabatan = Model_Jabatan::select_all();
        // $namajabatan = Model_Jabatan::find_name($id);        
        // print_r($namajabatan(nama_jabatan));

        $this->session->unset_userdata('ftk');
        $this->session->unset_userdata('warning');
        echo $this->load->blade('master.ftk.edit',
            array('data' => $ftk, 'flashdata' => $error,'listkantor' => $listkantor, 'listjabatan' => $listjabatan));
    }

    //update data
    public function update($id)
    {
        if (empty($_POST)){
            redirect('/master/ftk', 'location');
        }
        else
        {
            $ftk = Model_Ftk::find_by_kode_ftk($id);
            $ftk->kode_kantor   = $_POST['kode_kantor'];
            $ftk->kode_jabatan  = $_POST['kode_jabatan'];
            $ftk->jumlah        = $_POST['jumlah'];
            $ftk->save();
            if ($ftk->is_invalid())
            {
                $this->session->set_userdata('warning', $ftk->errors->full_messages());
                $this->session->set_userdata('ftk', $ftk);
                return $this->edit($id);
            }
            else{
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/master/ftk', 'location');
            }
        }
    }

    // delete data
    public function destroy($id)
    {
        $ftk = Model_Ftk::find_by_kode_ftk($id);
        $ftk->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/master/ftk', 'location');
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
            redirect('/master/ftk', 'location');
        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        // echo $this->load->blade('master.ftk.excel', array('data' => $data));
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
            if ($row > 1)
            {
                $unit_kantor    = $objWorksheet->getCellByColumnAndRow(0, $row);
                $nk             = Model_Kantor::find_by_nama_kantor($unit_kantor->getValue());
                foreach ($nk as $key => $value) {
                    $kode_kantor = $value->kode_kantor;
                }

                $jabatan        = $objWorksheet->getCellByColumnAndRow(1, $row);
                $jb             = Model_Jabatan::find_by_nama_jabatan($jabatan->getValue());
                foreach ($jb as $key => $value) {
                    $kode_jabatan = $value->kode_jabatan;
                }

                // $jumlah         = $objWorksheet->getCellByColumnAndRow(2, $row);

                // if ($unit_kantor->getValue()!= '' || $unit_kantor->getValue() != null){
                //     $data = array(
                //         'kode_kantor' => $kode_kantor,
                //         'kode_jabatan' => $kode_jabatan,
                //         'jumlah' => $jumlah->getValue(),
                //         );

                //     $obj        = new Model_Ftk($data);
                //     if ($obj->is_valid())
                //     {
                //         try {
                //             $obj->save();
                //         } catch (Exception $e) {

                //         }
                //     }
                //     $arrShow[]  = $obj;
                // }
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
            $obj = new Model_Ftk($value);
            if ($obj->is_invalid())
            {
                $has_invalid = true;
            }
            $data[] = $obj;
        }

        if ($has_invalid)
        {
            echo $this->load->blade('master.ftk.excel', array('data' => $data));
        }
        else
        {
            foreach ($data as $value) {
                $value->save();
            }
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/ftk', 'location');
        }
    }

}