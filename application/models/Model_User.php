<?php

class Model_User extends ActiveRecord\Model
{
    static $table_name = "t_user";
    static $primary_key = "user_id";

    static $before_validation_on_create = array('apply_user_id');
    static $after_validation_on_create = array('hash_passwords');

    public function apply_user_id($validate=true){
        $this->user_id  = round(microtime(true)*1000);
    }

    public function hash_passwords(){
        $this->password = get_instance()->load->encrypt($this->password);
    }

    static $validates_presence_of = array(
        array('email', 'message' => 'tidak boleh kosong.'),
        array('role', 'message' => 'tidak boleh kosong.'),
        array('password', 'message' => 'tidak boleh kosong.')
    );

    static $validates_length_of = array(
        array('password',
            'minimum' => 6,
            'message' => 'tidak boleh kurang dari 6 karakter.'
        )
    );

    static $validates_format_of = array(
        array(
            'email',
            'with' => '/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/',
            'message' => 'tidak valid.'),
        array(
            'role',
            'with' => '/^(alumni|administrator)/',
            'message' => 'tidak valid.')
    );

    public function alumni(){
        return Model_Alumni::find_by_nipeg($this->nim);
    }




}