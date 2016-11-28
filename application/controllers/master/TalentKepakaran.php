<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Masters.php';

class TalentKepakaran extends Masters {

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
        echo $this->load->blade('master.talentkepakaran.index',
            array('flash'=>$flash, 'talentkepakaran' => Model_Talent_Kepakaran::all()));
    }

    // show form
    public function create($talentkepakaran = null, $error = null, $method = "create")
    {
        $talentkepakaran = isset($talentkepakaran) ? $talentkepakaran : new Model_Talent_Kepakaran();
        $listprofesi = Model_Profesi::select_all();
        echo $this->load->blade('master.talentkepakaran.create',
        array('data' => $talentkepakaran, 'flashdata' => $error, 'method' => $method, 'listprofesi' => $listprofesi));
    }

    // insert data
    public function store()
    {
        $post = $_POST; unset($post['_token']);
        $talentkepakaran = new Model_Talent_Kepakaran($post);
        if ($talentkepakaran->is_valid())
        {
            $talentkepakaran->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/talentkepakaran', 'location');
        }
        else
        {   if (!empty($post))
            {
                return $this->create($talentkepakaran, $talentkepakaran->errors->full_messages(), 'store');
            }
            else
            {
                return $this->create($talentkepakaran);
            }
        }
    }

    // show edit form
    public function edit($id)
    {
        $error = $this->session->userdata('warning');
        $talentkepakaran = $this->session->userdata('talentkepakaran');
        $listprofesi = Model_Profesi::select_all();
        $talentkepakaran = !empty($talentkepakaran) ? $talentkepakaran : Model_Talent_Kepakaran::find_by_kode_talent_kepakaran($id);
        $this->session->unset_userdata('talentkepakaran');
        $this->session->unset_userdata('warning');
        echo $this->load->blade('master.talentkepakaran.edit',
            array('data' => $talentkepakaran, 'flashdata' => $error, 'listprofesi' => $listprofesi));
    }

    //update data
    public function update($id)
    {
        if (empty($_POST)){
            redirect('/master/talentkepakaran', 'location');
        }
        else
        {
            $talentkepakaran = Model_Talent_Kepakaran::find_by_kode_talent_kepakaran($id);
            $talentkepakaran->nama_talent_kepakaran = $_POST['nama_talent_kepakaran'];
            $talentkepakaran->profesi = $_POST['profesi'];
            $talentkepakaran->save();
            if ($talentkepakaran->is_invalid())
            {
                $this->session->set_userdata('warning', $talentkepakaran->errors->full_messages());
                $this->session->set_userdata('talentkepakaran', $talentkepakaran);
                return $this->edit($id);
            }
            else{
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/master/talentkepakaran', 'location');
            }
        }
    }

    // delete data
    public function destroy($id)
    {
        $talentkepakaran = Model_Talent_Kepakaran::find_by_kode_talent_kepakaran($id);
        $talentkepakaran->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/master/talentkepakaran', 'location');
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
            redirect('/master/talentkepakaran', 'location');
        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        echo $this->load->blade('master.talentkepakaran.excel', array('data' => $data));
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
                $kode_talent_kepakaran = $objWorksheet->getCellByColumnAndRow(0, $row);
                $nama_talent_kepakaran = $objWorksheet->getCellByColumnAndRow(1, $row);
                $profesi = $objWorksheet->getCellByColumnAndRow(2, $row);
                if ($kode_talent_kepakaran->getValue()!= '' || $kode_talent_kepakaran->getValue() != null){
                    $data = array(
                    	'kode_talent_kepakaran' => $kode_talent_kepakaran->getValue(),
                        'nama_talent_kepakaran' => $nama_talent_kepakaran->getValue(),
                        'profesi' => $profesi->getValue(),
                        );


                    $obj        = new Model_Talent_Kepakaran($data);
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
            $obj = new Model_Talent_Kepakaran($value);
            if ($obj->is_invalid())
            {
                $has_invalid = true;
            }
            $data[] = $obj;
        }

        if ($has_invalid)
        {
            echo $this->load->blade('master.talentkepakaran.excel', array('data' => $data));
        }
        else
        {
            foreach ($data as $value) {
                $value->save();
            }
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/talentkepakaran', 'location');
        }
    }

}