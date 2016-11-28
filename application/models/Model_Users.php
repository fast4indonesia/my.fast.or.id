<?php

class Model_Users extends ActiveRecord\Model{
    static $table_name = "USERS";
    static $primary_key = "user_id";
    public $listrole = array('administrator' => 'administrator', 'sdm' => 'sdm',  'diklat' => 'diklat', 'karyawan' => 'karyawan', 'print' => 'print');
    // public $listrole = array('administrator' => 'administrator', 'sdm' => 'sdm', 'atasan' => 'atasan', 'bawahan' => 'bawahan');
    static $before_validation_on_create = array('apply_user_id');
    static $after_validation_on_create = array('hash_passwords');


    public function apply_user_id($validate=true){
        $this->user_id  = round(microtime(true)*1000);
    }

    // validation
    public function validate(){
        $data = $this->check_pk($this->user_id);
        if ($this->is_new_record() && !empty($data)){
            $this->errors->add('user_id', "telah digunakan.");
        }
    }

    public function hash_passwords(){
        $this->password = get_instance()->load->encrypt($this->username);
    }

    static $validates_presence_of = array(
        array('user_id', 'message' => 'tidak boleh kosong.')
    );


    private function check_pk($str){
        return $this::find('first', array('conditions'=> array('user_id = ?', $str)));
    }


    // static function select_all(){
    //     $all = Model_Users::all();
    //     $return = array('' => 'Pilih Nama Pengguna');
    //     foreach ($all as $key => $value){
    //             $return[$value->nipeg] = $value->user_id;
    //     }
    //     return $return;
    // }



    // public function employee(){
    //     return Model_Employee::find_by_nipeg($this->nipeg);
    // }

}