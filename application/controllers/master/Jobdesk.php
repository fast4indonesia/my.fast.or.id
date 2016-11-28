<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Masters.php';

class Jobdesk extends Masters {
    public $controller_name = "jobdesk";
    public function __construct()
    {
        parent::__construct();
        $this->load->driver('session');
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    }

    public function index(){
    	$flash['success'] = $this->session->flashdata('success');
        $flash['warning'] = $this->session->flashdata('warning');

        echo $this->load->blade('master.jobdesk.index',
            array(
                'flash'=>$flash, 
                'data' =>Model_Jobdesk::allJabatan(),
                'jobdesk' =>Model_Jobdesk::allJobdesk()
            )
        );

        // $nama_jabatan     = Model_Jobdesk::get_nama_jabatan_by_kode_jabatan();
        // echo $this->load->blade('master.employees.create',
        //     array(
        //         'data' => $nama_jabatan,
        //         'data' => $jobdesk,
        //           ));

        // $jabatan = !empty($jabatan) ? $jabatan : Model_Jobdesk::allJabatan();
        // // print_r($jenjangkkj);die;
        // echo $this->load->blade('master.jobdesk.index',array('flash'=>$flash, 'jabatan' => $jabatan));

    }

    // show form soft
    public function create($jobdesk = null, $error = null, $method='create'){
        // select data kompetensi kemudian di assign ke object active record
        $jabatan = !empty($jabatan) ? $jabatan : Model_Jabatan::select_all();
        echo $this->load->blade('master.jobdesk.create',
        array('jabatan' => $jabatan, 'flashdata' => $error, 'method' => $method));

    }

    // insert data
    public function store()
    {
        $post['kode_jabatan'] = $this->input->post('kode_jabatan');
        $post['jobdesk'] = $this->input->post('jobdesk'); 
        $jobdesk = new Model_Jobdesk($post);
        if ($jobdesk->is_valid())
        {
            $jobdesk->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/jobdesk/', 'location');
        }
        else
        {
            if (!empty($post))
            {
                return $this->create($jobdesk, $jobdesk->errors->full_messages(), 'store');
            }
            else
            {
                return $this->create($jobdesk);
            }
        }
        
    }


    
    // delete data
    public function destroy($id)
    {
        $id = intval($id);
        $soft = Model_Jobdesk::find_by_kode_jabatan($id);
        echo $soft;
        $soft->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/master/jobdesk', 'location');
    }

        //file upload
    public function fileupload($kriteria = '')
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
            redirect('/master/jobdesk/', 'location');
        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        echo $this->load->blade('master.jobdesk.excel', array('data' => $data));
    }

    private function process($filename){

        $objPHPExcel    = PHPExcel_IOFactory::load($filename);
        $objWorksheet   = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow     = $objWorksheet->getHighestRow();
        $arrShow        = array();
        //untuk soft kompetensi
            for ($row = 1; $row <= $highestRow; ++ $row){
                // read from row 4
                if ($row > 1){
                    $kode_jabatan = "";
                    $keterangan = $objWorksheet->getCellByColumnAndRow(0, $row);
                    $ket = Model_Jabatan::find_by_keterangan($keterangan->getValue());
                    foreach ($ket as $key => $value) {
                        $kode_jabatan = $value->kode_jabatan;
                    }
                    $jobdesk = $objWorksheet->getCellByColumnAndRow(1, $row);

                    if ($kode_jabatan!= '' || $kode_jabatan != null){
                        $data = array(
                            'kode_jabatan' => $kode_jabatan,
                            'jobdesk' => $jobdesk->getValue(),
                            );
                        $obj = new Model_Jobdesk($data);
                        if ($obj->is_valid())
                        {
                            try
                            {
                                $obj->save();
                            }
                            catch (Exception $e) {

                            }
                        }
                    $arrShow[]  = $obj;
                    }
                }
            }
        return $arrShow;
    }

    public function saveupload($kriteria)
    {

        $post = $this->input->post('data');
        $has_invalid = false;
        $data = array();
        foreach ($post as $value)
        {
            $obj = new Model_Acuan_Nilai_Soft_Kompetensi($value);
            if ($obj->is_invalid())
            {
                $has_invalid = true;
            }
            $data[] = $obj;
        }
        if ($has_invalid)
        {
            echo $this->load->blade('master.jobdesk.excel', array('data' => $data));
        }
        else
        {
            foreach ($data as $value)
            {
                $value->save();
            }
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/jobdesk/', 'location');
            
        }

    }

}