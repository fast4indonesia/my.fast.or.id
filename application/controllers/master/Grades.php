<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Masters.php';

class Grades extends Masters {

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
        echo $this->load->blade('master.grades.index',
            array('flash'=>$flash, 'grades' => Grade::all()));
    }

    // show form
    public function create($grade = null, $error = null, $method = "create")
    {
        $grade = isset($grade) ? $grade : new Grade();
        echo $this->load->blade('master.grades.create',
        array('data' => $grade, 'flashdata' => $error, 'method' => $method));
    }

    // insert data
    public function store()
    {
        $post = $_POST; unset($post['_token']);
        $grade = new Grade($post);
        if ($grade->is_valid())
        {
            $grade->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/grades', 'location');
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
        $grade = !empty($grade) ? $grade : Grade::find_by_kode_grade($id);
        $this->session->unset_userdata('grade');
        $this->session->unset_userdata('warning');
        echo $this->load->blade('master.grades.edit',
            array('data' => $grade, 'flashdata' => $error));
    }

    //update data
    public function update($id)
    {
        if (empty($_POST)){
            redirect('/master/grades', 'location');
        }
        else
        {
            $grade = Grade::find_by_kode_grade($id);
            $grade->nama_grade = $_POST['nama_grade'];
            $grade->level = $_POST['level'];
            $grade->save();
            if ($grade->is_invalid())
            {
                $this->session->set_userdata('warning', $grade->errors->full_messages());
                $this->session->set_userdata('grade', $grade);
                return $this->edit($id);
            }
            else{
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/master/grades', 'location');
            }
        }
    }

    // delete data
    public function destroy($id)
    {
        $grade = Grade::find_by_kode_grade($id);
        $grade->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/master/grades', 'location');
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
            redirect('/master/grades', 'location');
        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        echo $this->load->blade('master.grades.excel', array('data' => $data));
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
                if ($kode->getValue()!= '' || $kode->getValue() != null){
                    $data = array('kode_grade' => $kode->getValue(),
                        'nama_grade' => $nama->getValue());


                    $obj        = new Grade($data);
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
            $obj = new Grade($value);
            if ($obj->is_invalid())
            {
                $has_invalid = true;
            }
            $data[] = $obj;
        }

        if ($has_invalid)
        {
            echo $this->load->blade('master.grades.excel', array('data' => $data));
        }
        else
        {
            foreach ($data as $value) {
                $value->save();
            }
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/grades', 'location');
        }
    }

}