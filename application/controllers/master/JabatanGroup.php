<?php defined('BASEPATH') OR exit('No direct script access allowed');

include_once APPPATH.'controllers/Masters.php';

class JabatanGroup extends Masters {
    public $controller_name = "jabatangroup";
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
        echo $this->load->blade('master.jabatangroup.index',
        array('flash'=>$flash, 'jabatangroup' => Model_JabatanGroup::all()));

       
    }

    // show form
    public function create($jabatan = null, $error = null, $method = "create")
    {
        //list profesi
        // $listprofesi = Model_Profesi::select_all();
        // $listjenjangjabatan = Model_Jenjang_Jabatan::select_all();
        //list jenjang jabatan
        $jabatan = isset($jabatan) ? $jabatan : new Model_JabatanGroup();
        echo $this->load->blade('master.jabatangroup.create', array('data' => $jabatan ,'flashdata' => $error, 'method' => $method)); 
        // echo $this->load->blade('master.jabatan.create', array('data' => $jabatan ,'flashdata' => $error, 'method' => $method, 'listprofesi' => $listprofesi, 'listjenjangjabatan' => $listjenjangjabatan)); 
    }

    // insert data
    public function store()
    {
        $post = $_POST; unset($post['_token']);
        $jabatan = new Model_JabatanGroup($post);
        if ($jabatan->is_valid())
        {
            $jabatan->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/jabatangroup', 'location');
        }
        else
        {   if (!empty($post))
            {
                return $this->create($jabatan, $jabatan->errors->full_messages(), 'store');
            }
            else
            {
                return $this->create($jabatan);
            }
        }
    }

    // show edit form
    public function edit($id)
    {

        $error = $this->session->userdata('warning');
        $jabatangroup = $this->session->userdata('jabatangroup');
        $jabatangroup = !empty($jabatangroup) ? $jabatangroup : Model_JabatanGroup::find_by_kode_jabatangroup($id);
        $this->session->unset_userdata('jabatangroup');
        $this->session->unset_userdata('warning');
        echo $this->load->blade('master.jabatangroup.edit',
            array('data' => $jabatangroup, 'flashdata' => $error));
    }

    //update data
    public function update($id)
    {
        if (empty($_POST)){
            redirect('/master/jabatangroup', 'location');
        }
        else
        {
            
            $jabatangroup = Model_JabatanGroup::find_by_kode_jabatangroup($id);
            $jabatangroup->nama_jabatangroup =  $_POST['nama_jabatangroup'];
            $jabatangroup->level =  $_POST['level'];
            $jabatangroup->keterangan = $_POST['jenjang_jabatangroup'];

            if ($jabatangroup->is_invalid())
            {
                $this->session->set_userdata('warning', $jabatangroup->errors->full_messages());
                $this->session->set_userdata('jabatangroup', $jabatangroup);
                return $this->edit($id);
            }
            else{
                $jabatangroup->save();
                $jabatangroup->kode_jabatangroup =  $_POST['nama_jabatangroup'];
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/master/jabatangroup', 'location');
            }

        }
    }

    // delete data based on id
    public function destroy($id)
    {
        $jabatangroup = !empty($jabatangroup) ? $jabatangroup : Model_JabatanGroup::find_by_kode_jabatangroup($id);
        $jabatangroup->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/master/jabatangroup', 'location');
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
            redirect('/master/jabatangroup', 'location');
        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        //var_dump($data);die();
        echo $this->load->blade('master.jabatangroup.excel', array('data' => $data));
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

                $nama = $objWorksheet->getCellByColumnAndRow(0, $row);
                $level = $objWorksheet->getCellByColumnAndRow(1, $row);
                $keterangan = $objWorksheet->getCellByColumnAndRow(2, $row);
                // if ($kode->getValue()!= '' || $kode->getValue() != null){
                    $data = array(
                        'nama_jabatangroup' => $nama->getValue(),
                        'level' => $level->getValue(),
                        'keterangan' => $keterangan->getValue()
                        );


                    $obj        = new Model_JabatanGroup($data);
                    if ($obj->is_valid())
                    {
                        try {
                            $obj->save();
                        } catch (Exception $e) {
                             //var_dump($obj->errors->full_messages());
                        }
                    }
                    $arrShow[]  = $obj;
                    //var_dump($obj->errors->full_messages());
                    //die;
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
            $obj = new Model_Jabatan($value);
            if ($obj->is_invalid())
            {
                $has_invalid = true;
            }
            $data[] = $obj;
        }

        if ($has_invalid)
        {
            echo $this->load->blade('master.jabatangroup.excel', array('data' => $data));
        }
        else
        {
            foreach ($data as $value) {
                $value->save();
            }
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/jabatangroup', 'location');
        }
    }


}