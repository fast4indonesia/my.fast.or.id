<?php

class Role
{
    static $all_names = array(
        'administrator'     => 'Administrator',
        'sdm'               => 'SDM',
        'karyawan'          => 'Karyawan',
        'printing'          => 'Printing'
        // 'peserta_fitproper' => 'Peserta Fit & Proper',
        // 'penguji_fitproper' => 'Penguji Fit & Proper'
    );

    public $name;
    public $idx;

    public function __construct($idx = '', $name = '')
    {
        $this->name = $name;
        $this->idx  = $idx;
    }

    static function all()
    {
        $arrObj = array();
        foreach (Role::$all_names as $key => $value) {
            $arrObj[] = new Role($key, $value);
        }
        return $arrObj;
    }

    static function find_by_idx($idx = '')
    {
        if (isset(Role::$all_names[$idx]))
            return new Role($idx, Role::$all_names[$idx]);
    }

}