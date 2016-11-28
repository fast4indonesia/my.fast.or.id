<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'controllers/Masters.php';
class Employee extends Masters {
    public $controller_name = "employee";
    public function __construct()
    {
        parent::__construct();
        $this->load->driver('session');
        ini_set('max_execution_time', 300);
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
            array('flash'=>$flash, 'karyawan' => Model_Employee::all()));
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
        echo $this->load->blade('master.employees.create',
            array(
                'data' => $karyawan,
                'flashdata' => $error,
                'method' => $method,
                'listkantor' => $listkantor,
                'listjabatan' => $listjabatan,
                'listgrade' => $listgrade,
                'listposisi' => $listposisi,
                'listprofesi' => $listprofesi,
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
        $karyawan = new Model_Employee($post);
        
        //var_dump($karyawan);

        if ($karyawan->is_valid())
        {

            
            $karyawan->save();
            $this->session->set_flashdata('success', 'Sukses menyimpan data');
            redirect('/master/employee', 'location');
            
        }
        else
        {
            
            if (!empty($post))
            {
                //var_dump(expression)
                return $this->create($karyawan, $karyawan->errors->full_messages(), 'store');
            }
            else
            {

               return $this->create($karyawan);
            }
            
        }
        

    }

    // show edit form
    public function edit($id)
    {
        $error = $this->session->userdata('warning');
        $karyawan = $this->session->userdata('karyawan');
        $karyawan = !empty($karyawan) ? $karyawan : Model_Employee::find_by_nipeg($id);
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
        $this->session->unset_userdata('karyawan');
        $this->session->unset_userdata('warning');
        echo $this->load->blade('master.employees.edit',
            array(
                'data' => $karyawan,
                'flashdata' => $error,
                'method' => $method,
                'listkantor' => $listkantor,
                'listjabatan' => $listjabatan,
                'listgrade' => $listgrade,
                'listposisi' => $listposisi,
                'listprofesi' => $listprofesi,
                'listjenjangkkj' => $listjenjangkkj,
                'listjenjangjabatan' => $listjenjangjabatan,
                'liststatusdefinitif' => $liststatusdefinitif,
                'listcostcenter' => $listcostcenter,
                  ));
    }

    //update data
    public function update()
    {
        if (empty($_POST)){
            redirect('/master/employee', 'location');
        }
        else
        {
            $id = $this->input->post('nipeg');
            $karyawan = Model_Employee::find_by_nipeg($id);



            $karyawan->tahun_pengangkatan =  $this->input->post('tahun_pengangkatan');
            $karyawan->nama = $this->input->post('nama');
            $karyawan->kode_jabatan= $this->input->post('kode_jabatan');
            $karyawan->tgl_mulai_jabatan= $this->input->post('tgl_mulai_jabatan');
            $karyawan->kode_grade= $this->input->post('kode_grade');
            $karyawan->tgl_grade_terakhir= $this->input->post('tgl_grade_terakhir');
            $karyawan->kode_posisi= $this->input->post('kode_posisi');
            $karyawan->lama_di_organisasi= $this->input->post('lama_di_organisasi');


            $karyawan->kode_profesi_1= $this->input->post('kode_profesi_1');
            $karyawan->kode_profesi_2= $this->input->post('kode_profesi_2');
            $karyawan->kode_profesi_3= $this->input->post('kode_profesi_3');


            $karyawan->kelompok_pendidikan= $this->input->post('kelompok_pendidikan');
            $karyawan->institusi= $this->input->post('institusi');
            $karyawan->kode_jenjang_kkj_soft= $this->input->post('kode_jenjang_kkj_soft');
            $karyawan->kode_jenjang_kkj_hard= $this->input->post('kode_jenjang_kkj_hard');
            $karyawan->kode_jenjang_kkj_main_grp= $this->input->post('kode_jenjang_kkj_main_grp');
            $karyawan->kode_jenjang_kkj_sub_grp= $this->input->post('kode_jenjang_kkj_sub_grp');
            $karyawan->tgl_masuk= $this->input->post('tgl_masuk');
            $karyawan->tgl_capeg= $this->input->post('tgl_capeg');
            $karyawan->tgl_tetap= $this->input->post('tgl_tetap');
            $karyawan->tgl_sk_penggajian_awal= $this->input->post('tgl_sk_penggajian_awal');
            $karyawan->tgl_sk_organizational_assi= $this->input->post('tgl_sk_organizational_assi');
            $karyawan->tgl_mulai= $this->input->post('tgl_mulai');
            $karyawan->tgl_berakhir= $this->input->post('tgl_berakhir');
            $karyawan->tgl_lahir= $this->input->post('tgl_lahir');
            $karyawan->kode_tpt_lahir= $this->input->post('kode_tpt_lahir');
            $karyawan->jns_kelamin= $this->input->post('jns_kelamin');
            $karyawan->status_perkawinan= $this->input->post('status_perkawinan');
            $karyawan->agama= $this->input->post('agama');
            $karyawan->gol_darah= $this->input->post('gol_darah');
            $karyawan->alamat_rumah= $this->input->post('alamat_rumah');
            $karyawan->kode_kota_tinggal= $this->input->post('kode_kota_tinggal');
            $karyawan->kelas_organisasi= $this->input->post('kelas_organisasi');
            $karyawan->tunjangan_posisi= $this->input->post('tunjangan_posisi');
            $karyawan->kode_status_definitif= $this->input->post('kode_status_definitif');
            $karyawan->email= $this->input->post('email');
            $karyawan->kode_cost_center= $this->input->post('kode_cost_center');




            if ($karyawan->is_invalid())
            {
                $this->session->set_flashdata('error', $karyawan->errors->full_messages());
                $this->session->set_userdata('grade', $karyawan);
                redirect('master/employee/edit/'.$id);
                //return $this->edit($id);

            }
            else{
                $karyawan->save();
                $this->session->set_flashdata('success', 'Sukses mengupdate data');
                redirect('/master/employees', 'location');
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
            redirect('/master/employee', 'location');
        }
        $data = $this->process(APPPATH.'storage/'.$file->getNameWithExtension());
        
        /*
        foreach ($data as $key => $element) {
            var_dump($element->tgl_mulai_jabatan);
        }
        */
        //var_dump($data);
        //$karyawan = isset($karyawan) ? $karyawan : new Model_Employee();
        echo $this->load->blade('master.employees.excel', array('data' => $data));
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
            //cell nipeg
            $nipeg = $objWorksheet->getCellByColumnAndRow(0, $row);
             //cell nama 
            $nama = $objWorksheet->getCellByColumnAndRow(1, $row);
            //cell tahun_pengangkatan
            $tahun_pengangkatan = $objWorksheet->getCellByColumnAndRow(2, $row); 

            $kode_jabatan = $objWorksheet->getCellByColumnAndRow(3, $row); 
            
            $tgl_mulai_jabatan = $objWorksheet->getCellByColumnAndRow(4, $row);
            
            $kode_grade = $objWorksheet->getCellByColumnAndRow(5, $row); 
            
            $tgl_grade_terakhir = $objWorksheet->getCellByColumnAndRow(6, $row);
            
            $kode_posisi = $objWorksheet->getCellByColumnAndRow(7, $row);
            
            $lama_di_organisasi = $objWorksheet->getCellByColumnAndRow(8, $row);
            
            $kode_profesi_1 = $objWorksheet->getCellByColumnAndRow(9, $row);
            
            $kode_profesi_2 = $objWorksheet->getCellByColumnAndRow(10, $row);
            
            $kode_profesi_3 = $objWorksheet->getCellByColumnAndRow(11, $row);
            
            $kelompok_pendidikan = $objWorksheet->getCellByColumnAndRow(12, $row);
            
            $institusi = $objWorksheet->getCellByColumnAndRow(13, $row);
            
            $kode_jenjang_kkj_soft= $objWorksheet->getCellByColumnAndRow(14, $row);
            
            $kode_jenjang_kkj_hard= $objWorksheet->getCellByColumnAndRow(15, $row);
            
            //$kode_jenjang_kkj_main_grp= $objWorksheet->getCellByColumnAndRow(16, $row);
            
            $kode_jenjang_kkj_sub_grp= $objWorksheet->getCellByColumnAndRow(17, $row);
            
            $tgl_masuk= $objWorksheet->getCellByColumnAndRow(18, $row);
            
            $tgl_capeg= $objWorksheet->getCellByColumnAndRow(19, $row);
            
            $tgl_tetap= $objWorksheet->getCellByColumnAndRow(20, $row);
            
            $tgl_sk_penggajian_awal= $objWorksheet->getCellByColumnAndRow(21, $row);
            
            $tgl_sk_organizational_assi= $objWorksheet->getCellByColumnAndRow(22, $row);
            
            $tgl_mulai= $objWorksheet->getCellByColumnAndRow(23, $row);
            
            $tgl_berakhir= $objWorksheet->getCellByColumnAndRow(24, $row);
            
            $tgl_lahir= $objWorksheet->getCellByColumnAndRow(25, $row);
            
            $tempat_lahir= $objWorksheet->getCellByColumnAndRow(26, $row);
            
            $jns_kelamin= $objWorksheet->getCellByColumnAndRow(27, $row);
            
            $status_perkawinan= $objWorksheet->getCellByColumnAndRow(28, $row);
            
            $agama= $objWorksheet->getCellByColumnAndRow(29, $row);
            
            $gol_darah= $objWorksheet->getCellByColumnAndRow(30, $row);
            
            $alamat_rumah= $objWorksheet->getCellByColumnAndRow(31, $row);
            
            $kota_tinggal = $objWorksheet->getCellByColumnAndRow(32, $row);
            
            $kelas_organisasi= $objWorksheet->getCellByColumnAndRow(33, $row);
            
            $tunjangan_posisi= $objWorksheet->getCellByColumnAndRow(34, $row);
            
            $kode_status_definitif= $objWorksheet->getCellByColumnAndRow(35, $row);
            
            $email= $objWorksheet->getCellByColumnAndRow(36, $row);
            
            $kantor = $objWorksheet->getCellByColumnAndRow(37, $row);

            //$kode_cost_center= $objWorksheet->getCellByColumnAndRow(37, $row);
            
            

            //$unit = $objWorksheet->getCellByColumnAndRow(39, $row);
            
            if ($nipeg->getValue()!= '' || $nipeg->getValue() != null)
            {
                    $data = array(
                        'nipeg' => $nipeg->getValue(),
                        'nama' => $nama->getValue(),
                        'tahun_pengangkatan' => $tahun_pengangkatan->getValue(),

                        'kode_jabatan' => $kode_jabatan->getValue(), //ganti jadi nama_jabatan

                        'tgl_mulai_jabatan' => $tgl_mulai_jabatan->getFormattedValue(),
                        'kode_grade' => $kode_grade->getValue(),
                        'tgl_grade_terakhir' => $tgl_grade_terakhir->getFormattedValue(),

                        'kode_posisi' => $kode_posisi->getValue(), 

                        'lama_di_organisasi' => $lama_di_organisasi->getValue(),
                        'kode_profesi_1' => $kode_profesi_1->getValue(),
                        'kode_profesi_2' => $kode_profesi_2->getValue(),
                        'kode_profesi_3' => $kode_profesi_3->getValue(),
                        'kelompok_pendidikan' => $kelompok_pendidikan->getValue(),
                        'institusi' => $institusi->getValue(),
                        'kode_jenjang_kkj_soft' => $kode_jenjang_kkj_soft->getValue(), //ganti jadi nama_jenjang_kkj
                        'kode_jenjang_kkj_hard' => $kode_jenjang_kkj_hard->getValue(),
                        //'kode_jenjang_kkj_main_grp' => $kode_jenjang_kkj_main_grp->getValue(),
                        'kode_jenjang_kkj_sub_grp' => $kode_jenjang_kkj_sub_grp->getValue(),
                        'tgl_masuk' => $tgl_masuk->getFormattedValue(),
                        'tgl_capeg' => $tgl_capeg->getFormattedValue(),
                        'tgl_tetap' => $tgl_tetap->getFormattedValue(),
                        'tgl_sk_penggajian_awal' => $tgl_sk_penggajian_awal->getFormattedValue(),
                        'tgl_sk_organizational_assi' => $tgl_sk_organizational_assi->getFormattedValue(),
                        'tgl_mulai' => $tgl_mulai->getFormattedValue(),

                        'tgl_berakhir' => $tgl_berakhir->getFormattedValue(),
                        'tgl_lahir' => $tgl_lahir->getFormattedValue(),
                        'tempat_lahir' => $tempat_lahir->getValue(),
                        'jns_kelamin' => $jns_kelamin->getValue(),
                        'status_perkawinan' => $status_perkawinan->getValue(),
                        'agama' => $agama->getValue(),

                        'gol_darah' => $gol_darah->getValue(),
                        'alamat_rumah' => $alamat_rumah->getValue(),
                        'kota_tinggal' => $kota_tinggal->getValue(),
                        'kelas_organisasi' => $kelas_organisasi->getValue(),
                        'tunjangan_posisi' => $tunjangan_posisi->getValue(),
                        'status_definitif' => $kode_status_definitif->getValue(),

                        'email' => $email->getValue(),
                        'kode_kantor' => $kantor->getValue(),
                        //'kode_cost_center' => $kode_cost_center->getValue(),
                        
                        //'unit' => $unit->getValue(),
                                                );
                    //var_dump($data);die;
                    
                    $obj        = new Model_Employee($data);
                    //var_dump($obj);die;
                    
                    if ($obj->is_valid())
                    {
                        try {
                            
                            $obj->save();
                        } catch (Exception $e) {
                            //var_dump($obj->errors->full_messages());
                        }
                    }
                    else
                    {
                        //echo 'gagal';
                        //var_dump($obj->errors->full_messages());
                    }
                    $arrShow[]  = $obj;
                    
                }
            }
        }
        //var_dump($arrShow);
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