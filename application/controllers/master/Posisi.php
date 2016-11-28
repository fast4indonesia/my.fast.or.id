<?php defined('BASEPATH') OR exit('No direct script access allowed');

include_once APPPATH.'controllers/Masters.php';
//kode kantor dihapus, pindah untuk table sendiri
class Posisi extends Masters {
    public $controller_name = "posisi";
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
        echo $this->load->blade('master.posisi.index',
        array('flash'=>$flash, 'posisi' => Model_Posisi::allposisi()));


    }

    // show form
    public function create($posisi = null, $error = null, $method = "create")
    {
        $posisi = isset($posisi) ? $posisi : new Model_Posisi();
        $listkantor = Model_Kantor::select_all();
        echo $this->load->blade('master.posisi.create', 
            array(
                'data' => $posisi ,
                'listkantor' => $listkantor,
                'flashdata' => $error, 
                'method' => $method
            )
        );
    }

    // insert data
    public function store()
    {
        $post = $_POST; unset($post['_token']);
        $posisi = new Model_Posisi($post);
        if ($posisi->is_valid())
        {
            $posisi->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/posisi', 'location');
        }
        else{   
            print_r($posisi);
            if (!empty($post)){
                return $this->create($posisi, $posisi->errors->full_messages(), 'store');
            }
            else{
                return $this->create($posisi);
            }
        }
    }

    // show edit form
    public function edit($id)
    {

        $error = $this->session->userdata('warning');
        $posisi = $this->session->userdata('posisi');
        $posisi = !empty($posisi) ? $posisi : Model_Posisi::find_by_kode_posisi($id);
        $listkantor = Model_Kantor::select_all();
        $this->session->unset_userdata('posisi');
        $this->session->unset_userdata('warning');
        echo $this->load->blade('master.posisi.edit',
            array('data' => $posisi, 'flashdata' => $error, 'listkantor' => $listkantor));
    }

    //update data
    public function update($id)
    {
        if (empty($_POST)){
            redirect('/master/posisi', 'location');
        }
        else
        {

            $posisi = Model_Posisi::find_by_kode_posisi($id);
            $posisi->organisasi =  $_POST['organisasi'];
            $posisi->bidang =  $_POST['bidang'];
            //$posisi->kode_kantor =  $_POST['kode_kantor'];
            $posisi->save();
            if ($posisi->is_invalid())
            {
                $this->session->set_userdata('warning', $posisi->errors->full_messages());
                $this->session->set_userdata('posisi', $posisi);
                return $this->edit($id);
            }
            else{
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/master/posisi', 'location');
            }

        }
    }

    // delete data based on id
    public function destroy($id)
    {
        $jabatan = !empty($jabatan) ? $jabatan : Model_Posisi::find_by_kode_posisi($id);
        $jabatan->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/master/posisi', 'location');
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
            redirect('/master/posisi', 'location');
        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        redirect('/master/posisi', 'location');
    }

    private function process($filename = ''){
        $objPHPExcel    = PHPExcel_IOFactory::load($filename);
        $objWorksheet   = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow     = $objWorksheet->getHighestRow();
        $arrShow        = array();
        for ($row = 9; $row <= $highestRow; ++ $row){
            // read from row 4
            if ($row > 8)
            {
                $kode_posisi = $objWorksheet->getCellByColumnAndRow(1, $row);
                $bidang = $objWorksheet->getCellByColumnAndRow(2, $row);
                $pemangku = $objWorksheet->getCellByColumnAndRow(3, $row);
                $kinit = $objWorksheet->getCellByColumnAndRow(4, $row);
                $org_unit_sap = $objWorksheet->getCellByColumnAndRow(5, $row);
                $unit = $objWorksheet->getCellByColumnAndRow(6, $row);
                $start_date = $objWorksheet->getCellByColumnAndRow(8, $row);

                if ($start_date->getvalue() == ""){
                    $start_date = date("d-m-Y");
                }else{
                    $start_date = $start_date->getvalue();
                }


                if ($kode_posisi->getValue()!= '' || $kode_posisi->getValue() != null){
                    $data = array(
                        'kode_posisi' => $kode_posisi->getValue(),
                        'bidang' => $bidang->getValue(),
                        'unit' => $unit->getValue(),
                        'pemangku' => $pemangku->getValue(),
                        'kinit' => $kinit->getValue(),
                        'org_unit_sap' => $org_unit_sap->getValue(),
                        'kode_unit' => $unit->getValue(),
                        'start_date' => $start_date
                        );

                    $obj = new Model_Posisi($data);
                    if ($obj->is_valid()){
                        try {
                            $obj->save();
                            // echo "Nomor = (".$row.")".$kode_posisi." | ".$bidang." | ".$pemangku." | ".$kinit." | ".$org_unit_sap." | ".$unit." | ".$start_date;
                            // echo "<br/>";
                        } catch (Exception $e) {

                        }
                    }else{
                        echo "error";

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
            $obj = new Model_Posisi($value);
            if ($obj->is_invalid())
            {
                $has_invalid = true;
            }
            $data[] = $obj;
        }

        if ($has_invalid)
        {
            echo $this->load->blade('master.posisi.excel', array('data' => $data));
        }
        else
        {
            foreach ($data as $value) {
                $value->save();
            }
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/posisi', 'location');
        }
    }


}