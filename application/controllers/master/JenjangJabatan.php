<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Masters.php';

class JenjangJabatan extends Masters {
    public $controller_name = "jenjangjabatan";
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
        echo $this->load->blade('master.jenjangjabatan.index',
        array('flash'=>$flash, 'jenjangjabatan' => Model_Jenjang_Jabatan::all()));
    }

    // show form
    public function create($jenjangjabatan = null, $error = null, $method = "create")
    {
        $jenjangjabatan = isset($jenjangjabatan) ? $jenjangjabatan : new Model_Jenjang_Jabatan();
        $listgroup = array('Fungsional' => 'Fungsional', 
                            'Struktural' => 'Struktural'
                            );
        echo $this->load->blade('master.jenjangjabatan.create', 
            array(
                'data' => $jenjangjabatan ,
                'flashdata' => $error, 
                'listgroup' => $listgroup, 
                'method' => $method
            )
        ); 
    }

    // insert data
    public function store()
    {
        $post = $_POST; unset($post['_token']);
        $jenjangjabatan = new Model_Jenjang_Jabatan($post);
        if ($jenjangjabatan->is_valid())
        {
            $jenjangjabatan->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/jenjangjabatan', 'location');
        }
        else
        {   if (!empty($post))
            {
                return $this->create($jenjangjabatan, $jenjangjabatan->errors->full_messages(), 'store');
            }
            else
            {
                return $this->create($jenjangjabatan);
            }
        }
    }

    // show edit form
    public function edit($id)
    {
        $error = $this->session->userdata('warning');
        $jenjangjabatan = $this->session->userdata('jenjangjabatan');
        $jenjangjabatan = !empty($jenjangjabatan) ? $jenjangjabatan : Model_Jenjang_Jabatan::find_by_kode_jenjang_jabatan($id);
        $this->session->unset_userdata('jenjangjabatan');
        $this->session->unset_userdata('warning');
        echo $this->load->blade('master.jenjangjabatan.edit',
            array('data' => $jenjangjabatan, 'flashdata' => $error));
    }

    //update data
    public function update($id)
    {
        if (empty($_POST)){
            redirect('/master/jenjangjabatan', 'location');
        }
        else
        {
            //$id = $this->input->post('kode_jenjang_jabatan');
            $jenjangjabatan = Model_Jenjang_Jabatan::find_by_kode_jenjang_jabatan($id);
            $jenjangjabatan->group                  =  $this->input->post('group');
            $jenjangjabatan->nama_jenjang_jabatan   =  $this->input->post('nama_jenjang_jabatan');
            $jenjangjabatan->keterangan             =  $this->input->post('keterangan');
            $jenjangjabatan->kd_kewenangan          =  $this->input->post('kd_kewenangan');
            $jenjangjabatan->desc_sap               =  $this->input->post('desc_sap');
            $jenjangjabatan->urutan                 =  $this->input->post('urutan');
            
            if ($jenjangjabatan->is_invalid())
            {
                $this->session->set_userdata('warning', $jenjangjabatan->errors->full_messages());
                $this->session->set_userdata('jenjangjabatan', $jenjangjabatan);
                return $this->edit($id);
            }
            else{
                $jenjangjabatan->save();
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/master/jenjangjabatan', 'location');
            }

        }
    }

    // delete data
    public function destroy($id)
    {
        $jenjangjabatan = !empty($jenjangjabatan) ? $jenjangjabatan : Model_Jenjang_Jabatan::find_by_kode_jenjang_jabatan($id);
        $jenjangjabatan->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/master/jenjangjabatan', 'location');
    }

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
            redirect('/master/jenjangJabatan', 'location');
        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        echo $this->load->blade('master.jenjangjabatan.excel', array('data' => $data));
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
                // $kode = $objWorksheet->getCellByColumnAndRow(0, $row);
                $group          = $objWorksheet->getCellByColumnAndRow(0, $row);
                $nama           = $objWorksheet->getCellByColumnAndRow(1, $row);
                $keterangan     = $objWorksheet->getCellByColumnAndRow(3, $row);
                // if ($kode->getValue()!= '' || $kode->getValue() != null){
                    $data = array(
                        'group' => $group->getValue(),
                        'nama_jenjang_jabatan' => $nama->getValue(),
                        'keterangan' => $keterangan->getValue()
                        );


                    $obj        = new Model_Jenjang_Jabatan($data);
                    if ($obj->is_valid())
                    {
                        try {
                            $obj->save();
                        } catch (Exception $e) {

                        }
                    }
                    $arrShow[]  = $obj;
                // }
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
            $obj = new Model_Jenjang_Jabatan($value);
            if ($obj->is_invalid())
            {
                $has_invalid = true;
            }
            $data[] = $obj;
        }

        if ($has_invalid)
        {
            echo $this->load->blade('master.jenjangjabatan.excel', array('data' => $data));
        }
        else
        {
            foreach ($data as $value) {
                $value->save();
            }
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/jenjangJabatan', 'location');
        }
    }


}