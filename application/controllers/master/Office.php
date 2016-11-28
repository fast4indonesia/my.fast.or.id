<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Masters.php';

class Office extends Masters {

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
        echo $this->load->blade('master.office.index',
            array('flash'=>$flash, 'data' => Model_Kantor::all()));
    }

    // show form
    public function create($grade = null, $error = null, $method = "create")
    {
        $grade = isset($grade) ? $grade : new Model_Kantor();
        echo $this->load->blade('master.office.create',
        array('data' => $grade, 'flashdata' => $error, 'method' => $method));
    }

    // insert data
    public function store()
    {
        $post = $_POST; unset($post['_token']);
        $grade = new Model_Kantor($post);
        if ($grade->is_valid())
        {
            $grade->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/office', 'location');
        }
        else
        {   if (!empty($post))
            {
                return $this->create($grade, $grade->errors->full_messages(), 'store');
            }
            else
            {
                return $this->create($grade);
            }
        }
    }

    // show edit form
    public function edit($id)
    {
        $error = $this->session->userdata('warning');
        $grade = $this->session->userdata('grade');
        $grade = !empty($grade) ? $grade : Model_Kantor::find_by_kode_kantor($id);
        $this->session->unset_userdata('grade');
        $this->session->unset_userdata('warning');
        echo $this->load->blade('master.office.edit',
            array('data' => $grade, 'flashdata' => $error));
    }

    //update data
    public function update($id)
    {
        if (empty($_POST)){
            redirect('/master/office', 'location');
        }
        else
        {
            $grade = Model_Kantor::find_by_kode_kantor($id);
            $post = $_POST; unset($post['_token']);
            $grade->update_attributes($post);
            // $grade->save();
            if ($grade->is_invalid())
            {
                $this->session->set_userdata('warning', $grade->errors->full_messages());
                $this->session->set_userdata('grade', $grade);
                return $this->edit($id);
            }
            else{
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/master/office', 'location');
            }
        }
    }

    // delete data
    public function destroy($id)
    {
        $grade = Model_Kantor::find_by_kode_kantor($id);
        $grade->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/master/office', 'location');
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
            redirect('/master/office', 'location');
        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        echo $this->load->blade('master.office.excel', array('data' => $data));
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
                $jenis = $objWorksheet->getCellByColumnAndRow(2, $row);
                $alamat = $objWorksheet->getCellByColumnAndRow(3, $row);
                if ($kode->getValue()!= '' || $kode->getValue() != null){
                    $data = array(
                        'kode_kantor' => $kode->getValue(),
                        'nama_kantor' => $nama->getValue(),
                        'jenis_kantor' => $jenis->getValue(),
                        'alamat_kantor' => $alamat->getValue()

                    );

                    $obj        = new Model_Kantor($data);
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
            $obj = new Model_Kantor($value);
            if ($obj->is_invalid())
            {
                $has_invalid = true;
            }
            $data[] = $obj;
        }

        if ($has_invalid)
        {
            echo $this->load->blade('master.office.excel', array('data' => $data));
        }
        else
        {
            foreach ($data as $value) {
                $value->save();
            }
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/office', 'location');
        }
    }

}