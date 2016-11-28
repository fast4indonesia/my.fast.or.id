<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Masters.php';
class Employee extends Masters {
    public $controller_name = "employee";
    public function __construct()
    {
        parent::__construct();
        $this->load->driver('session');
        //$this->load->library('bootstrap');
        //$this->load->model('Model_Employee');

        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
       // $this->load->library('form_validation');

    }

    // show all data
    public function index()
    {
        //var_dump(Model_Employee::all());die;
        $flash['success'] = $this->session->flashdata('success');
        $flash['warning'] = $this->session->flashdata('warning');
        echo $this->load->blade('master.employees.index',
            array('flash'=>$flash, 
                'karyawan' => Model_Employee::allEmployee(),
                'cek_menu' => "Eksisting"
            )
        );
    }

    public function history()
    {
        //var_dump(Model_Employee::all());die;
        $flash['success'] = $this->session->flashdata('success');
        $flash['warning'] = $this->session->flashdata('warning');
        echo $this->load->blade('master.employees.index-history',
            array('flash'=>$flash, 
                'karyawan' => Model_Employee::allEmployee(),
                'cek_menu' => "History"
            )
        );
    }

    // show form
    public function create($karyawan = null, $error = null, $method = "create")
    {
        $karyawan = isset($karyawan) ? $karyawan : new Model_Employee();
        $listkantor = Model_Kantor::select_all();
        $listjabatan = Model_Jabatan::select_all();
        $listgrade = Grade::select_all();
        $listposisi = Model_Posisi::select_all();
        $listprofesi = Model_Profesi::select_all();
        $listjenjangkkj = JenjangKkj::select_all();
        $listjenjangjabatan = Model_Jenjang_Jabatan::select_all();
        $liststatusdefinitif = Model_Status_Definitif::select_all();
        $listcostcenter = Model_Cost_Center::select_all();
        $listjenjangmaingrp = Model_Jenjang_KKJ_Main_GRP::select_all();

        $listgolongandarah = array('A' => 'A', 'B' => 'B', 'O' => 'O', 'AB' => 'AB');
        $listagama = array('ISLAM' => 'ISLAM', 'KRISTEN' => 'KRISTEN', 'KATHOLIK' => 'KATHOLIK', 'HINDU' => 'HINDU', 'BUDHA' => 'BUDHA', 'LAINNYA' => 'LAINNYA');
        $listgender = array('Pria' => 'Pria', 'Wanita' => 'Wanita');
        $listgelar = array('SMP' => 'SMP', 
                            'SMA' => 'SMA',
                            'SMK' => 'SMK',
                            'DIPLOMA' => 'DIPLOMA',
                            'SARJANA' => 'SARJANA',
                            'MASTER' => 'MASTER',
                            'DOCTOR' => 'DOCTOR',
                            'PROFESOR' => 'PROFESOR'
                            );
        $listjenis = array('Aktif' => 'Aktif', 
                            'DM (DUMMY)' => 'DM (DUMMY)',
                            'OJT' => 'OJT',
                            'TUGAS BELAJAR' => 'TUGAS BELAJAR',
                            'PENSIUN' => 'PENSIUN',
                            'TIDAK AKTIF' => 'TIDAK AKTIF',
                            'MPP' => 'MPP'
                            );
        $listperkawinan = array('Single' => 'Single', 'Menikah' => 'Menikah', 'Janda' => 'Janda', 'Duda' => 'Duda');

        // echo "aaaa ".$listgolongandarah;
        // $listgelar = Model_Kantor::$listgelar;
        echo $this->load->blade('master.employees.create',
            array(
                'data' => $karyawan,
                'flashdata' => $error,
                'method' => $method,
                'listkantor' => $listkantor,
                'listjenis' => $listjenis,
                'listjabatan' => $listjabatan,
                'listgrade' => $listgrade,
                'listgelar' => $listgelar,
                'listgender' => $listgender,
                'listposisi' => $listposisi,
                'listprofesi' => $listprofesi,
                'listgolongandarah' => $listgolongandarah,
                'listagama' => $listagama,
                'listperkawinan' => $listperkawinan,
                'listjenjangkkj' => $listjenjangkkj,
                'listjenjangjabatan' => $listjenjangjabatan,
                'liststatusdefinitif' => $liststatusdefinitif,
                'listcostcenter' => $listcostcenter,
                  ));
    }

    // insert data
    public function store()
    {
        $post = $_POST; unset($post['_token']);
        // print_r($post);
        $karyawan = new Model_Employee($post);
        
        //var_dump($karyawan);

        if ($karyawan->is_valid()){            
            $karyawan->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/employee', 'location');
            
        }
        else{    
            if (!empty($post)){
                //var_dump(expression)
                return $this->create($karyawan, $karyawan->errors->full_messages(), 'store');
            }
            else{
               return $this->create($karyawan);
            }
            
        }
        

    }

    // show edit form
    public function edit($id){

        $error = $this->session->userdata('warning');
        $karyawan = $this->session->userdata('karyawan');
        $karyawan = !empty($karyawan) ? $karyawan : Model_Employee::find_by_nipeg($id);
        $listkantor = Model_Kantor::select_all();
        $listjabatan = Model_Jabatan::select_all();
        $listgrade = Grade::select_all();
        $listposisi = Model_Posisi::select_all_sap();
        $listprofesi = Model_Profesi::select_all();
        $listjenjangkkj = JenjangKkj::select_all();
        $listjenjangjabatan = Model_Jenjang_Jabatan::select_all();
        $liststatusdefinitif = Model_Status_Definitif::select_all();
        $listcostcenter = Model_Cost_Center::select_all();
        $listjenjangmaingrp = Model_Jenjang_KKJ_Main_GRP::select_all();

        $listgolongandarah = array('A' => 'A', 'B' => 'B', 'O' => 'O', 'AB' => 'AB');
        $listagama = array('ISLAM' => 'ISLAM', 'KRISTEN' => 'KRISTEN', 'KATHOLIK' => 'KATHOLIK', 'HINDU' => 'HINDU', 'BUDHA' => 'BUDHA', 'LAINNYA' => 'LAINNYA');
        $listgender = array('Pria' => 'Pria', 'Wanita' => 'Wanita');
        
        $listpendidikan = array('' => 'Pilih Pendidikan',
                            'SMP' => 'SMP', 
                            'SMA' => 'SMA',
                            'SMK' => 'SMK',
                            'SMEA' => 'SMEA',
                            'STM' => 'STM',
                            'SM/Program D3 Teknik' => 'SM/Program D3 Teknik',
                            'SM/Program D3 NT' => 'SM/Program D3 NT',
                            'D1 Teknik' => 'D1 Teknik',
                            'D1 Non Teknik' => 'D1 Non Teknik',
                            'S1 Teknik' => 'S1 Teknik',
                            'S1 Non Teknik' => 'S1 Non Teknik',
                            'Program S2 Teknik' => 'Program S2 Teknik',
                            'Program S2 Non Tekni' => 'Program S2 Non Tekni',
                            'SLTA Lainnya' => 'SLTA Lainnya',
                            'Sekolah Dasar' => 'Sekolah Dasar'
                            );
        $listjenis = array('' => 'Pilih Jenis Pegawai',
                            'Aktif' => 'Aktif', 
                            'DM (DUMMY)' => 'DM (DUMMY)',
                            'OJT' => 'OJT',
                            'TUGAS BELAJAR' => 'TUGAS BELAJAR',
                            'PENSIUN' => 'PENSIUN',
                            'TIDAK AKTIF' => 'TIDAK AKTIF',
                            'MPP' => 'MPP'
                            );
        $listperkawinan = array('Single' => 'Single', 'Menikah' => 'Menikah', 'Janda' => 'Janda', 'Duda' => 'Duda');

        $this->session->unset_userdata('karyawan');
        $this->session->unset_userdata('warning');
        echo $this->load->blade('master.employees.edit',
            array(
                'data' => $karyawan,
                'flashdata' => $error,
                'method' => $method,
                'listkantor' => $listkantor,
                'listjabatan' => $listjabatan,
                'listjenis' => $listjenis,
                'listgrade' => $listgrade,
                'listpendidikan' => $listpendidikan,
                'listgender' => $listgender,
                'listposisi' => $listposisi,
                'listprofesi' => $listprofesi,
                'listgolongandarah' => $listgolongandarah,
                'listagama' => $listagama,
                'listperkawinan' => $listperkawinan,
                'listjenjangkkj' => $listjenjangkkj,
                'listjenjangjabatan' => $listjenjangjabatan,
                'liststatusdefinitif' => $liststatusdefinitif,
                'listcostcenter' => $listcostcenter,
            )
        );
    }

    //update data
    public function update(){
        
        if (empty($_POST)){
            redirect('/master/employee', 'location');
        }else{
            $post = $_POST;
            $id = $this->input->post('nipeg');
            $karyawan = Model_Employee::find_by_nipeg($id);

            $karyawan->nama = $this->input->post('nama');
            $karyawan->gelar= $this->input->post('gelar');
            $karyawan->kode_jabatan= $this->input->post('kode_jabatan');
            $karyawan->kode_grade= $this->input->post('kode_grade');
            $karyawan->kode_posisi= $this->input->post('kode_posisi');
            $karyawan->kelompok_pendidikan= $this->input->post('kelompok_pendidikan');
            $karyawan->tgl_masuk= $this->input->post('tgl_masuk');
            $karyawan->jenis_pegawai= $this->input->post('jenis_pegawai');
            $karyawan->tgl_capeg= $this->input->post('tgl_capeg');
            $karyawan->tgl_tetap= $this->input->post('tgl_tetap');

            $karyawan->tempat_lahir= $this->input->post('tempat_lahir');
            $karyawan->tgl_lahir= $this->input->post('tgl_lahir');
            $karyawan->jns_kelamin= $this->input->post('jns_kelamin');
            $karyawan->status_perkawinan= $this->input->post('status_perkawinan');
            $karyawan->agama= $this->input->post('agama');
            $karyawan->gol_darah= $this->input->post('gol_darah');
            $karyawan->alamat_rumah= $this->input->post('alamat_rumah');
            $karyawan->kota_tinggal= $this->input->post('kota_tinggal');
            $karyawan->email= $this->input->post('email');

            $karyawan->pers_no_sap= $this->input->post('pers_no_sap');
            $karyawan->org_unit_sap= $this->input->post('org_unit_sap');
            $karyawan->position_sap= $this->input->post('position_sap');
            $karyawan->pers_no_superior_sap= $this->input->post('pers_no_superior_sap');


            // print_r($karyawan);
            // foreach ($_POST as $key => $value) {
            //     echo $key." | ".$value;
            //     echo "<br/>";
            // }



            if ($karyawan->is_invalid()){
                $this->session->set_flashdata('error', $karyawan->errors->full_messages());
                $this->session->set_userdata('grade', $karyawan);
                redirect('master/employee/edit/'.$id);
                //return $this->edit($id);

            }else{
                $karyawan->save();
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/master/employee', 'location');
            }

        }
    }

    // delete data
    public function destroy($id)
    {
        $karyawan = !empty($karyawan) ? $karyawan : Model_Employee::find_by_nipeg($id);
        $karyawan->delete();
        $this->session->set_flashdata('success', 'Sukses menghapus data');
        redirect('/master/employee', 'location');
    }

    

    //file upload
    public function fileupload(){

        // $flash['success'] = $this->session->flashdata('success');
        // $flash['warning'] = $this->session->flashdata('warning');        
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
            redirect('/master/employee', 'location');
        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        // print_r($data);
        echo $this->load->blade('master.employees.excel', array('data' => $data));
    }

    

    private function process($filename = ''){
        $objPHPExcel    = PHPExcel_IOFactory::load($filename);
        $objWorksheet   = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow     = $objWorksheet->getHighestRow();
        // $highestRow     = $objWorksheet->getHighestRow();
        $arrShow        = array();
        // echo "aaa";
        for ($row = 2; $row <= $highestRow; ++ $row){

            // read from row 4
            if ($row > 1){

                $nipeg              = $objWorksheet->getCellByColumnAndRow(0, $row);
                $pers_no_sap        = $objWorksheet->getCellByColumnAndRow(1, $row);
                $nama               = $objWorksheet->getCellByColumnAndRow(2, $row);
                $kode_grade         = $objWorksheet->getCellByColumnAndRow(3, $row); 
                $kode_jabatan       = $objWorksheet->getCellByColumnAndRow(6, $row); 
                $org_unit_sap       = $objWorksheet->getCellByColumnAndRow(8, $row);
                $kp                 = Model_Posisi::find_by_org_unit_sap($org_unit_sap->getValue());
                foreach ($kp as $key => $value) {
                    $kode_posisi  = $value->kode_posisi;
                } 
                $jenis_pegawai      = "Aktif";
                $nama_kantor        = $objWorksheet->getCellByColumnAndRow(11, $row);
                $kk                 = Model_Kantor::find_by_nama_kantor($nama_kantor->getValue());
                foreach ($kk as $key => $value) {
                    $kode_kantor = $value->kode_kantor;
                }
                $gender             = $objWorksheet->getCellByColumnAndRow(12, $row); 
                if ($gender->getValue() == "Male")$jns_kelamin = "Pria";
                else $jns_kelamin = "Wanita";
                $tempat_lahir       = $objWorksheet->getCellByColumnAndRow(13, $row);
                $status_perkawinan  = $objWorksheet->getCellByColumnAndRow(14, $row);
                $email              = $objWorksheet->getCellByColumnAndRow(16, $row); 
                $agama              = $objWorksheet->getCellByColumnAndRow(17, $row);
                $tl                 = $objWorksheet->getCellByColumnAndRow(23, $row);
                $temp_lahir         = (($tl->getValue()) - 25569) * 86400;
                $tgl_lahir          = gmdate("Y-m-d", $temp_lahir);
                // $temp_lahir         = explode("/", $tl->getValue());
                // $tgl_lahir          = $temp_lahir[2]."-".$temp_lahir[0]."-".$temp_lahir[1];
                $tm                 = $objWorksheet->getCellByColumnAndRow(24, $row);                   
                $temp_masuk         = (($tm->getValue()) - 25569) * 86400;
                $tgl_masuk          = gmdate("Y-m-d", $temp_masuk);       
                // $temp_masuk         = explode("/", $tm->getValue());
                // $tgl_masuk          = $temp_masuk[2]."-".$temp_masuk[0]."-".$temp_masuk[1];      
                $tc                 = $objWorksheet->getCellByColumnAndRow(25, $row);               
                $temp_capeg         = (($tc->getValue()) - 25569) * 86400;
                $tgl_capeg          = gmdate("Y-m-d", $temp_capeg);        
                // $temp_capeg         = explode("/", $tc->getValue());
                // $tgl_capeg          = $temp_capeg[2]."-".$temp_capeg[0]."-".$temp_capeg[1];          
                $tt                 = $objWorksheet->getCellByColumnAndRow(26, $row);                 
                $temp_tetap         = (($tt->getValue()) - 25569) * 86400;
                $tgl_tetap          = gmdate("Y-m-d", $temp_tetap);          
                // $temp_tetap         = explode("/", $tt->getValue());
                // $tgl_tetap          = $temp_tetap[2]."-".$temp_tetap[0]."-".$temp_tetap[1];          
                $kelompok_pendidikan= $objWorksheet->getCellByColumnAndRow(15, $row); 
                
                
                // echo "tgl_lahir = ".$tgl_lahir." | ".$tl->getValue()."\n";

                if ($nipeg->getValue()!= '' || $nipeg->getValue() != null){
                        $data = array(
                            'nipeg' => $nipeg->getValue(),                            
                            'pers_no_sap' => $pers_no_sap->getValue(),
                            'nama' => $nama->getValue(),
                            'kode_grade' => $kode_grade->getValue(),
                            'kelompok_pendidikan' => $kelompok_pendidikan->getValue(),
                            'kode_jabatan' => $kode_jabatan->getValue(),
                            'kode_posisi' => $kode_posisi,
                            'jenis_pegawai' => $jenis_pegawai,
                            'kode_kantor' => $kode_kantor,
                            'jns_kelamin' => $jns_kelamin,
                            'tempat_lahir' => $tempat_lahir->getValue(),
                            'status_perkawinan' => $status_perkawinan->getValue(),
                            'agama' => $agama->getValue(),
                            'email' => $email->getValue(),
                            'tgl_lahir' => $tgl_lahir,
                            'tgl_masuk' => $tgl_masuk,
                            'tgl_capeg' => $tgl_capeg,
                            'tgl_tetap' => $tgl_tetap
                        );

                        $obj        = new Model_Employee($data);
                        
                        if ($obj->is_valid()){
                            try {
                                $obj->save();

                                // foreach ($data as $key => $value) {
                                //     echo $key." | ".$value;
                                //     echo "<br/>";
                                // }
                            } catch (Exception $e) {

                            }
                        }
                        $arrShow[]  = $data;
                        
                }
            }
        }
        // var_dump($arrShow);
        return $arrShow;
    }

    public function test123()
    {
        $angga = Model_Kantor::find('first', array('conditions'=> array('nama_kantor = ?', 'Kantor Pusats')));
        var_dump(empty($angga));
    }
    public function saveupload()
    {
        $post = $_POST['data'];
        $has_invalid = false;
        $data = array();
        //var_dump($post); die;
        foreach ($post as $value) {
            $value['nipeg'] = $value['0'];
            unset($value['0']);
            //value nama jabatan = input kode_jabatan
            /*
            $value['kode_jabatan'] = Model_Jabatan::find_by_nama_jabatan($value['kode_jabatan']);
            $value['kode_jabatan'] = $value['kode_jabatan']->kode_jabatan;
            //value nama kantor = input kode_kantor
            $value['kode_kantor'] = Model_Kantor::find_by_nama_kantor($value['kode_kantor']);
            $value['kode_kantor'] = $value['kode_kantor']->kode_kantor;
            //value nama jenjang kkj soft = input kode_jenjang_kkj
            $value['kode_jenjang_kkj_soft'] = Model_JenjangKkj::find_by_nama_jenjang_kkj($value['kode_jenjang_kkj_soft']);
            $value['kode_jenjang_kkj_soft'] = $value['kode_jenjang_kkj_soft']->kode_jenjang_kkj;
            */
            $obj = new Model_Employee($value);
            //var_dump($obj);
            
            if ($obj->is_invalid())
            {
                $has_invalid = true;
            }
            $data[] = $obj;
            
        }
        
        if ($has_invalid)
        {

            echo $this->load->blade('master.employees.excel', array('data' => $data, 'errors' => $obj->errors->full_messages()));
            //var_dump($data);
        }
        else
        {
            
            foreach ($data as $value) {
                $value->save();
            }

            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/employee', 'location');
        }
        
    }

    public function test()
    {
        //load our new PHPExcel library
        $this->load->library('excel');
        //activate worksheet number 1
        $this->excel->getDefaultStyle()->getFont()->setName('Arial');
        $this->excel->setActiveSheetIndex(0);
        $sheet = $this->excel->getActiveSheet();
        //name the worksheet
        $sheet->setTitle('evaluasi fit');
        
        $sheet->setShowGridlines(false);
        $sheet->setCellValue('B4', 'EVALUASI MUTASI JABATAN');
        $sheet->setCellValue('B5', 'SIDANG JABATAN');

        $sheet->mergeCells('B4:AA4');
        $sheet->mergeCells('B5:AA5');
        
        $styleArray = array(
                        'font' => array(
                            'bold' => true,
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        ),
                    );

        $sheet->getStyle('B4')->applyFromArray($styleArray);
        $sheet->getStyle('B5')->applyFromArray($styleArray);

        //arrange multiple sheets into groups based on style merge
        $sheetMerge = array(
                    'B8' => 'NO.', 
                    'C8' => 'NAMA / NO. INDUK', 
                    'D8' => 'JABATAN SAAT INI/ SEJAK',
                    'E8' => 'PAY FOR POSITION (1)',
                    'F8' => 'GRADE / SEJAK',
                    'G8' => 'TKT ORG',
                    'H8' => 'HASIL ASSESSMENT',
                    'H10' => 'INT',
                    'I10' => 'LDS',
                    'J10' => 'CFO',
                    'K10' => 'ACH',
                    'L10' => 'REKOMENDASI',
                    'M8' => 'PROSES',
                    'M10' => 'DEMOSI',
                    'N10' => 'ROTASI',
                    'O10' => 'PROMOSI',
                    'P8' => 'LAMA MENJABAT TOTAL',
                    'Q8' => 'LAMA MENJABAT DI AREA',
                    'R8' => 'NILAI TALENTA',
                    'R10' =>'2013.1',
                    'S10' => '2012.2',
                    'T10' => '2012.1',
                    'U10' => '2011.2',
                    'V8' => 'ALAMAT',
                    'W8' => 'JABATAN YANG AKAN DIISI',
                    'X8' => 'PAY FOR POSITION (2)',
                    'Y8' => 'TKT ORG',
                    'Z8' => 'CATATAN LAIN',
                    'AA8' => 'KESIMPULAN',
                    );

        //arrange multiple sheets into groups based on style no merge
        $default_border = array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                //'color' => array('rgb'=>'1006A3')
                );

        $styleArrayMerge = array(
                    'font' => array(
                        'bold' => true,
                        'size' => '10',
                    ),
                    'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap' => true,
                        ),
                    'borders' => array(
                            'bottom' => $default_border,
                            'left' => $default_border,
                            'top' => $default_border,
                            'right' => $default_border,
                            ),
                    );

        $styleLastRow = array(
                    'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap' => true,
                        ),
                    'borders' => array(
                            'bottom' => $default_border,
                            'left' => $default_border,
                            'right' => $default_border,
                            ),
                    );

        $styleArrayIsi = array(
                    'font' => array(
                        'size' => '12',
                    ),
                    'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                            'wrap' => true,
                        ),
                    'borders' => array(
                            'left' => $default_border,
                            'right' => $default_border,
                            ),
                    );

        $arrayMerge = array('B8:B11','C8:C11','D8:D11','E8:E11','F8:F11','G8:G11','H8:L9','H10:H11','I10:I11','J10:J11','K10:K11','L10:L11','M8:O9','M10:M11','N10:N11','O10:O11','P8:P11','Q8:Q11','R8:U9','R10:R11','S10:S11','T10:T11', 'U10:U11','V8:V11', 'W8:W11', 'X8:X11', 'Y8:Y11', 'Z8:Z11', 'AA8:AA11');

        //merge cell
        foreach ($arrayMerge as $value) {
            $sheet->mergeCells($value);
        }

        //set value
        foreach ($sheetMerge as $key => $value) {
            $sheet->setCellValue($key, $value);
            
        }

        //apply style array
        foreach ($arrayMerge as $value) {
            $sheet->getStyle($value)->applyFromArray($styleArrayMerge);
        }

        //setting width for each column
        $sheet->getColumnDimension('B')->setWidth(6);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(8);

        $sheet->getColumnDimension('H')->setWidth(7);
        $sheet->getColumnDimension('I')->setWidth(7);
        $sheet->getColumnDimension('J')->setWidth(7);
        $sheet->getColumnDimension('K')->setWidth(7);
        $sheet->getColumnDimension('L')->setWidth(15);

        $sheet->getColumnDimension('M')->setWidth(9);
        $sheet->getColumnDimension('N')->setWidth(9);
        $sheet->getColumnDimension('O')->setWidth(9);

        $sheet->getColumnDimension('P')->setWidth(13);
        $sheet->getColumnDimension('Q')->setWidth(13);
        $sheet->getColumnDimension('R')->setWidth(8);
        $sheet->getColumnDimension('S')->setWidth(8);
        $sheet->getColumnDimension('T')->setWidth(8);
         $sheet->getColumnDimension('U')->setWidth(8);
         $sheet->getColumnDimension('V')->setWidth(11);
         $sheet->getColumnDimension('W')->setWidth(25);

        $sheet->getColumnDimension('X')->setWidth(12);
         $sheet->getColumnDimension('Y')->setWidth(8);
         $sheet->getColumnDimension('Z')->setWidth(20);
         $sheet->getColumnDimension('AA')->setWidth(20);

         //setting table isi
        for ($row=12; $row <= 14; $row++) { 
            for ($col = 'B'; $col != 'AB'; $col++) {
                    $sheet->setCellValue($col.$row, 'angka'.$row);
                    $sheet->getStyle($col.$row)->applyFromArray($styleArrayIsi);
                }
            $sheet->getRowDimension($row)->setRowHeight(150);
        }

        for ($row=15; $row <= 15; $row++) { 
            for ($col = 'A'; $col != 'AB'; $col++) {
                    $sheet->getStyle($col.$row)->applyFromArray($styleLastRow);
                }
        }

        //cell keterangan
                //arrange multiple sheets into groups based on style merge
        $cellKeterangan = array(
                    'B16' => 'no kode', 
                    'B26' => 'NAMA / NO. INDUK', 
                    'B27' => 'JABATAN SAAT INI/ SEJAK',
                    'E8' => 'PAY FOR POSITION (1)',
                    'F8' => 'GRADE / SEJAK',
                    'G8' => 'TKT ORG',
                    );

        $filename='just_some_random_name.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
             
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
        //$objWriter->save("myExcelFile.xlsx");
    }

    public function test2()
    {
        /*

        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        //merge cell A1 until D1
        $this->excel->getActiveSheet()->mergeCells('A1:D1');
        //set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


        $html = $this->load->view('table-view', $data, true);
        $tmpfile = time().'.html';
        file_put_contents($tmpfile, $html);


        $objReader = PHPExcel_IOFactory::createReader('HTML');
        $objPHPExcel = $objReader->load($tmpfile);

        $filename='just_some_random_name.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        //$objWriter->save("myExcelFile.xlsx");
        */

    
        // Load the table view into a variable
        $html = $this->load->view('table-view', $data, true);

        // Put the html into a temporary file
        $tmpfile = time().'.html';
        file_put_contents($tmpfile, $html);

        // Read the contents of the file into PHPExcel Reader class
        $reader = new PHPExcel_Reader_HTML; 
        $content = $reader->load($tmpfile); 

        $filename='just_some_random_name.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
             
        // Pass to writer and output as needed
        $objWriter = PHPExcel_IOFactory::createWriter($content, 'Excel2007');
        $objWriter->save('php://output');

        // Delete temporary file
        unlink($tmpfile);

    }


}