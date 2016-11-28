<?php defined('BASEPATH') OR exit('No direct script access allowed');

include_once APPPATH.'controllers/Masters.php';

class Jabatan extends Masters {
    public $controller_name = "jabatan";
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
        echo $this->load->blade('master.jabatan.index',
        array('flash'=>$flash, 'jabatan' => Model_Jabatan::allJabatan()));

       
    }

    // show form
    public function create($jabatan = null, $error = null, $method = "create")
    {
        //list profesi
        $listjabatangroup = Model_JabatanGroup::select_all();
        $listjenjangjabatan = Model_Jenjang_Jabatan::select_all();
        $listkantor = Model_Kantor::select_all();
        //list jenjang jabatan
        $jabatan = isset($jabatan) ? $jabatan : new Model_Jabatan();
        echo $this->load->blade('master.jabatan.create', 
            array(
                'data' => $jabatan ,
                'flashdata' => $error, 
                'method' => $method, 
                'listjabatangroup' => $listjabatangroup, 
                'listjenjangjabatan' => $listjenjangjabatan,
                'listkantor' => $listkantor
                )
            ); 
    }

    // insert data
    public function store()
    {
        $post = $_POST; unset($post['_token']);
        $jabatan = new Model_Jabatan($post);
        if ($jabatan->is_valid())
        {
            $jabatan->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/jabatan', 'location');
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
        $jabatan = $this->session->userdata('jabatan');
        $listjabatangroup = Model_JabatanGroup::select_all();
        $listjenjangjabatan = Model_Jenjang_Jabatan::select_all();
        $listkantor = Model_Kantor::select_all();
        $jabatan = !empty($jabatan) ? $jabatan : Model_Jabatan::find_by_kode_jabatan($id);
        $this->session->unset_userdata('jabatan');
        $this->session->unset_userdata('warning');
        echo $this->load->blade('master.jabatan.edit',
            array(
                'data' => $jabatan, 'flashdata' => $error, 
                'listjabatangroup' => $listjabatangroup, 
                'listjenjangjabatan' => $listjenjangjabatan,
                'listkantor'=> $listkantor
                )
            );
    }

    //update data
    public function update($id)
    {
        if (empty($_POST)){
            redirect('/master/jabatan', 'location');
        }
        else
        {
            
            $jabatan = Model_Jabatan::find_by_kode_jabatan($id);
            $jabatan->kode_jabatangroup         = $_POST['kode_jabatangroup'];
            $jabatan->kode_jenjang_jabatan      = $_POST['kode_jenjang_jabatan'];
            $jabatan->kode_kantor               = $_POST['kode_kantor'];
            $jabatan->nama_jabatan              = $_POST['nama_jabatan'];
            $jabatan->keterangan                = $_POST['keterangan'];
            $jabatan->position_sap              = $_POST['position_sap'];
            $jabatan->jenjang_main_grp_id_sap   = $_POST['jenjang_main_grp_id_sap'];
            $jabatan->jenjang_sub_grp_id_sap    = $_POST['jenjang_sub_grp_id_sap'];


            // print_r($jabatan);

            if ($jabatan->is_invalid())
            {
                $this->session->set_userdata('warning', $jabatan->errors->full_messages());
                $this->session->set_userdata('jabatan', $jabatan);
                return $this->edit($id);
            }
            else{                
                $jabatan->save();
                $jabatan->kode_jabatan =  $_POST['nama_jabatan'];
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/master/jabatan', 'location');
            }

        }
    }

    // delete data based on id
    public function destroy($id)
    {
        $jabatan = !empty($jabatan) ? $jabatan : Model_Jabatan::find_by_kode_jabatan($id);
        $jabatan->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/master/jabatan', 'location');
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
            redirect('/master/jabatan', 'location');
        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        //var_dump($data);die();
        echo $this->load->blade('master.jabatan.excel', array('data' => $data));
    }

    private function process($filename = ''){
        $objPHPExcel    = PHPExcel_IOFactory::load($filename);
        $objWorksheet   = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow     = $objWorksheet->getHighestRow();
        $arrShow        = array();
        for ($row = 9; $row <= $highestRow; ++ $row){
            // read from row 4
            if ($row > 8){

                $kode_jabatan = $objWorksheet->getCellByColumnAndRow(1, $row);
                $group = $objWorksheet->getCellByColumnAndRow(2, $row);
                // $jg = Model_JabatanGroup::find_by_nama_jabatangroup($group->getValue());
                // foreach ($jg as $key => $value) {
                //     $kode_jabatangroup = $value->kode_jabatangroup;
                // }
                $jenjang_jabatan = $objWorksheet->getCellByColumnAndRow(3, $row);
                $jj = Model_Jenjang_Jabatan::find_by_nama_desc_sap($jenjang_jabatan->getValue());
                foreach ($jj as $key => $value) {
                    $kode_jenjang_jabatan = $value->kode_jenjang_jabatan;
                }
                $nama = $objWorksheet->getCellByColumnAndRow(4, $row);
                $nk = Model_Kantor::find_by_nama_kantor($nama->getValue());
                foreach ($nk as $key => $value) {
                    $kode_kantor = $value->kode_kantor;
                }
                $nama_jabatan = $objWorksheet->getCellByColumnAndRow(5, $row);
                $keterangan = $objWorksheet->getCellByColumnAndRow(6, $row);
                $position_sap = $objWorksheet->getCellByColumnAndRow(7, $row);
                $jenjang_main_grp_id_sap = $objWorksheet->getCellByColumnAndRow(8, $row);
                $jenjang_sub_grp_id_sap = $objWorksheet->getCellByColumnAndRow(9, $row);
                // print_r($jj);
                // echo "<br/>";
                

                if ($kode_jabatan->getValue()!= '' || $kode_jabatan->getValue() != null){
                    $data = array(
                        'kode_jabatan' => $kode_jabatan->getValue(),
                        'kode_jabatangroup' => $group->getValue(),
                        'kode_jenjang_jabatan' => $kode_jenjang_jabatan,
                        'kode_kantor' => $kode_kantor,
                        'nama_jabatan' => $nama_jabatan->getValue(),
                        'keterangan' => $keterangan->getValue(),
                        'position_sap' => $position_sap->getValue(),
                        'jenjang_main_grp_id_sap' => $jenjang_main_grp_id_sap->getValue(),
                        'jenjang_sub_grp_id_sap' => $jenjang_sub_grp_id_sap->getValue()
                );

                    $obj = new Model_Jabatan($data);
                    if ($obj->is_valid()){
                        try {
                            $obj->save();
                            // echo "Nomor = (".$row.")".$kode_jabatan." | ".$kode_jabatangroup." | ".$kode_jenjang_jabatan." | ".$kode_kantor." | ".$nama_jabatan." | ".$keterangan;
                            // echo "<br/>";
                        } catch (Exception $e) {
                             //var_dump($obj->errors->full_messages());
                        }
                    }
                    $arrShow[]  = $obj;
                    //var_dump($obj->errors->full_messages());
                    //die;
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
            $obj = new Model_Jabatan($value);
            if ($obj->is_invalid())
            {
                $has_invalid = true;
            }
            $data[] = $obj;
        }

        if ($has_invalid)
        {
            echo $this->load->blade('master.jabatan.excel', array('data' => $data));
        }
        else
        {
            foreach ($data as $value) {
                $value->save();
            }
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/jabatan', 'location');
        }
    }


}