<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Masters.php';
use Alchemy\Zippy\Zippy;

class Assessment extends Masters {

    private $flash;
    public function __construct()
    {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->driver('session');
        $this->flash['success'] = $this->session->flashdata('success');
        $this->flash['warning'] = $this->session->flashdata('warning');
    }

    // show all data
    public function index()
    {
        $flash['success'] = $this->session->flashdata('success');
        $flash['warning'] = $this->session->flashdata('warning');
        $psikolog = Model_Assessment_Psikolog::allAssessment();
        $psikolog['tanggal_assessment'] = date('d-m-Y', strtotime($psikolog['tanggal_assessment']));
        echo $this->load->blade('master.assessment.index',
            array('flash'=>$this->flash, 'data' => $psikolog));
    }

    // show form
    public function create($grade = null, $error = null, $method = "create")
    {
        $grade = isset($grade) ? $grade : new Model_Assessment_Psikolog();
        echo $this->load->blade('master.assessment.create',
        array(
            'data' => $grade,
            'flashdata' => $error,
            'method' => $method,
            'kompetensi' => $grade->employee == null ? array() : $grade->employee->soft_competencies(),
            'employee' => Model_Employee::select_list() ));
    }

    // insert data
    public function store()
    {
        $post = $_POST; unset($post['_token']);
        $file = $_FILES;
        $valid_formats = array("jpg", "jpeg", "png", "gif", "bmp");
        $assessment = new Model_Assessment_Psikolog();
        $assessment->nipeg = $post['employee'];
        $assessment->kode_assessment = $post['kode_assessment'];
        $assessment->tanggal_assessment = $post['tanggal_assessment'];
        $assessment->batch = $post['batch'];

        $temp = explode("-",$assessment->tanggal_assessment);
        if ($temp[1] < 7 ){
            $assessment->periode = "1";
        }else{
            $assessment->periode = "2";
        }
        $assessment->tahun = $temp[0];

        $assessment->file_atasan = file_get_contents($file['file_assessment_versi_Atasan']['tmp_name']);
        $assessment->file_bawahan = file_get_contents($file['file_assessment_versi_Bawahan']['tmp_name']);
        $assessment->file_sdm = file_get_contents($file['file_assessment_versi_SDM']['tmp_name']);
        $assessment->file_atasan_type = $file['file_assessment_versi_Atasan']['type'];
        $assessment->file_bawahan_type = $file['file_assessment_versi_Bawahan']['type'];
        $assessment->file_sdm_type = $file['file_assessment_versi_SDM']['type'];

        $file_atasan_size   = $file['file_assessment_versi_Atasan']['size'];
        $file_bawahan_size  = $file['file_assessment_versi_Bawahan']['size'];
        $file_sdm_size      = $file['file_assessment_versi_SDM']['size'];
        $file_atasan_type   = $assessment->file_atasan_type;
        $file_sdm_type      = $assessment->file_sdm_type;
        $file_bawahan_type  = $assessment->file_bawahan_type;


        // echo $file_atasan_size;
        // echo "<br/>";
        // echo $file_sdm_size;
        // echo "<br/>";
        // echo $file_bawahan_size;
        // echo "<br/>";
        // echo $file_atasan_type;
        // echo "<br/>";
        // echo $file_sdm_type;
        // echo "<br/>";
        // echo $file_bawahan_type;
        // echo "<br/>";
        if(isset($file['file_assessment_versi_Atasan']['tmp_name']) && isset($file['file_assessment_versi_Bawahan']['tmp_name']) && isset($file['file_assessment_versi_SDM']['tmp_name']))
            $assessment->file_exists = 1;

        // $penilaian = Model_Penilaian_Kriteria_Talent::find('last', array(
        //     'conditions' => array('nipeg = ?', $post['employee']),
        //     'order' => 'kode_penilaian ASC'));
        // $emp = Model_Employee::find_by_nipeg($post['employee']);

            if (($file_atasan_size < 1500000) AND ($file_sdm_size < 1500000) AND ($file_bawahan_size < 1500000) AND (($file_atasan_type == 'application/pdf') OR ($file_atasan_type == '')) AND (($file_sdm_type == 'application/pdf') OR ($file_sdm_type == '')) AND (($file_bawahan_type == 'application/pdf') OR ($file_bawahan_type == ''))){
                if ($assessment->is_valid()){
                    $assessment->save();
                    foreach ($post['kompetensi'] as $key => $value) {
                        $kmp = new Model_Nilai_Soft_Competency_Psikolog();
                        $kmp->kode_kompetensi = $key;
                        $kmp->kode_assessment = $assessment->kode_assessment;
                        $kmp->nilai = $value;
                        $kmp->save();
                    }

                    // if (is_null($penilaian)){
                    //     $penilaian = new Model_Penilaian_Kriteria_Talent();
                    //     $penilaian->nipeg = $emp->nipeg;
                    //     $penilaian->kode_jadwal = Model_Jadwal::this_semester() == null ? '' : Model_Jadwal::this_semester()->kode_jadwal;
                    // }

                    // $soft   = new SoftCompetency($emp);
                    // $nilai  = $soft->calculate_psikolog();
                    // $penilaian->nilai_assessment_psikolog = $nilai;
                    // $penilaian->save();

                    $this->session->set_flashdata('success', 'Sukses menyimpan data');
                    redirect('/master/assessment', 'location');
                }else{   
                    if (!empty($post)){
                        return $this->create($assessment, $assessment->errors->full_messages(), 'store');
                    }else{
                        return $this->create($assessment);
                    }
                }
            }else{
                if ($file_atasan_size > 1500000){                    
                    $error[] = "File Report Atasan Lebih dari 1,5 Mb";
                    // $this->errors->add('file_atasan', "File Report Atasan Lebih dari 1,5 Mb");
                }
                if ($file_sdm_size > 1500000){                    
                   $error[] = "File Report SDM Lebih dari 1,5 Mb";
                }
                if ($file_bawahan_size > 1500000){       
                    $error[] = "File Report Bawahan Lebih dari 1,5 Mb";             
                    // $this->errors->add('file_bawahan', "File Report Bawahan Lebih dari 1,5 Mb");
                }
                if (($file_atasan_type != 'application/pdf') AND ($file_atasan_type != '')){                    
                    $error[] = "File Report Atasan harus format PDF";
                    // $this->errors->add('file_atasan', "File Report Atasan harus format PDF");
                }
                if (($file_sdm_type != 'application/pdf') AND ($file_sdm_type != '')){                    
                    $error[] = "File Report SDM harus format PDF";
                    // $this->errors->add('file_sdm', "File Report SDM harus format PDF");
                }
                if (($file_bawahan_type != 'application/pdf') AND ($file_bawahan_type != '')){                    
                    $error[] = "File Report Bawahan harus format PDF";
                    // $this->errors->add('file_atasan', "File Report Bawahan harus format PDF");
                }
                $this->session->unset_userdata('warning');
                // print_r($error);
                // echo $this->load->blade('master.assessment.create',
                //     array(
                //         'data' => $assessment,
                //         'flashdata' => $error,
                //         ));
                return $this->create($assessment, $error);
            }
        
    }

    public function ajax($nipeg)
    {
        $em = Model_Employee::find_by_nipeg($nipeg);
        echo $this->load->blade('master.assessment.ajax', array('data'=> Model_Kompetensi::all_soft()));
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
            redirect('/master/assessment', 'location');
        }
        $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        $this->session->set_flashdata('success', 'Sukses menyimpan data');
        redirect('/master/assessment', 'location');
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
            if ($row > 5)
            {
                $kode    = $objWorksheet->getCellByColumnAndRow(0, $row);
                $tanggal = $objWorksheet->getCellByColumnAndRow(1, $row);
                $nipeg   = $objWorksheet->getCellByColumnAndRow(2, $row);
                $batch   = $objWorksheet->getCellByColumnAndRow(3, $row);

                if ($kode->getValue()!= '' || $kode->getValue() != null){

                    $emp = Model_Employee::find_by_nipeg($nipeg->getValue());

                    if (!is_null($emp)){

                        $assessment = new Model_Assessment_Psikolog();
                        $assessment->nipeg              = $nipeg->getValue();
                        $assessment->kode_assessment    = $kode->getValue();
                        $assessment->tanggal_assessment = $tanggal->getFormattedValue();
                        $assessment->batch              = $batch->getValue();

                        if ($assessment->is_valid())
                        {
                            $assessment->save();
                            for ($i=4; $i < 17; $i++) {
                                $kmp = new Model_Nilai_Soft_Competency_Psikolog();
                                $kmp->kode_kompetensi = $objWorksheet->getCellByColumnAndRow($i, 5)->getValue();
                                $kmp->kode_assessment = $assessment->kode_assessment;
                                $kmp->nilai = $objWorksheet->getCellByColumnAndRow($i, $row)->getValue();
                                $kmp->save();
                            }
                            // $penilaian = Model_Penilaian_Kriteria_Talent::find('last', array(
                            //     'conditions' => array('nipeg = ?',$nipeg->getValue()),
                            //     'order' => 'kode_penilaian ASC'));

                            // if (is_null($penilaian)){
                            //     $penilaian = new Model_Penilaian_Kriteria_Talent();
                            //     $penilaian->nipeg = $emp->nipeg;
                            //     $penilaian->kode_jadwal = Model_Jadwal::this_semester() == null ? '' : Model_Jadwal::this_semester()->kode_jadwal;
                            // }

                            // $soft   = new SoftCompetency($emp);
                            // $nilai  = $soft->calculate_psikolog();
                            // $penilaian->nilai_assessment_psikolog = $nilai;
                            // $penilaian->save();
                        }
                    }
                }
            }
        }
        unlink($filename);
    }

    public function files($name, $kode)
    {
        $ass = Model_Assessment_Psikolog::find_by_kode_assessment($kode);
        if (is_null($ass)){
            echo '<script>
            if (confirm("Data tidak ditemukan.") == true) {
                window.close();
            } else {
                window.close();
            }
            </script>';
        }
        $type = $name.'_type';
        header('Content-Type: '.$ass->$type);
        echo $ass->$name;
    }

    public function zipupload()
    {
        $folder_name    = round(microtime(true)*1000);
        $full_path      = FCPATH.'storage/'.$folder_name;
        mkdir($full_path, 0777, true);

        $storage = new \Upload\Storage\FileSystem($full_path);
        $file = new \Upload\File('file', $storage);
        // Validate file upload
        $file->addValidations(array(
            //You can also add multi mimetype validation
            new \Upload\Validation\Mimetype(
                array(
                    'application/zip',
                    'multipart/x-zip',
                    'application/x-zip-compressed',
                    'application/x-compressed'
                )
            ),
        ));

        try {
            $file->upload();
        } catch (\Exception $e) {
            $this->session->set_flashdata('warning', 'Type file harus berbentuk zip.');
            redirect('/master/assessment', 'location');
        }

        $this->process_zip($full_path,$file->getNameWithExtension());
        $this->rrmdir($full_path);

        $this->session->set_flashdata('success', 'File sukses di proses.');
        redirect('/master/assessment', 'location');
    }

    private function process_zip($path,$file)
    {
        $full       = $path.'/'.$file;
        $zippy      = Zippy::load();
        $archive    = $zippy->open($full);

        //extract data
        $archive->extract($path);
        $dirs       = scandir($path);

        foreach ($dirs as $key => $value) {
            if(($value != '..') and ($value != '.' ) and ($value != $file )){
                $fl         = explode('.', $value)[0];
                $arrName    = explode("_", $fl);

                $em = Model_Employee::find_by_nipeg($arrName[1]);
                $assessment = $em->last_psikolog();

                if (!is_null($assessment)){
                    if($arrName[2] == 'A'){
                        $assessment->file_sdm = file_get_contents($path.'/'.$value);
                        $assessment->file_sdm_type = 'application/pdf';
                    }
                    else if ($arrName[2] == 'B'){
                        $assessment->file_atasan = file_get_contents($path.'/'.$value);
                        $assessment->file_atasan_type = 'application/pdf';
                    }
                    else if ($arrName[2] == 'C'){
                        $assessment->file_bawahan = file_get_contents($path.'/'.$value);
                        $assessment->file_bawahan_type = 'application/pdf';
                    }

                    if(!is_null($assessment->file_bawahan) && !is_null($assessment->file_atasan) && !is_null($assessment->file_sdm))
                        $assessment->file_exists = 1;

                    $assessment->save();
                }
            }
        }
    }


    private function rrmdir($dir) {
        foreach(glob($dir . '/*') as $file) {
            if(is_dir($file))
                rmdir($file);
            else
                unlink($file);
        }
        rmdir($dir);
    }

}