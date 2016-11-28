<?php

class SoftCompetency
{
    private $pegawai;
    private $nilai;
    private $SANGAT_POTENSIAL = 350;
    private $POTENSIAL        = 300;
    private $CUKUP_POTENSIAL  = 250;
    private $KURANG_POTENSIAL = 200;
    private $TIDAK_POTENSIAL  = 100;
    private $criticals        = array('LDS', 'CSO', 'CLE');
    private $above_grey, $on_grey, $below_grey, $critical_below, $zero = 0;


    public function __construct($pegawai)
    {
        $this->pegawai = $pegawai;
    }

    public function calculate()
    {
        $arrAcuan = $this->acuan_to_array();
        $arrSoft  = $this->soft_to_array();
        $this->process($arrAcuan, $arrSoft);
        $this->mapping_evaluation($arrAcuan);
        return $this->nilai;
    }

    public function calculate_psikolog()
    {
        $arrAcuan = $this->acuan_to_array();
        $arrSoft  = $this->psikolog_to_array();
        $this->process($arrAcuan, $arrSoft);
        $this->mapping_evaluation($arrAcuan);
        return $this->nilai;
    }

    private function acuan_to_array()
    {
        $return = array();
        $acuan  = $this->pegawai->acuan_soft_competencies();
        foreach ($acuan as $key => $value) {
            $return[$value->kode_kompetensi] = $value->nilai;
        }
        return $return;
    }

    private function soft_to_array()
    {
        $return = array();
        $soft   = $this->pegawai->this_kriteria('soft');
        foreach ($soft as $key => $value) {
            $return[$value->kode_kompetensi] = $value->nilai;
        }
        return $return;
    }

    private function psikolog_to_array()
    {
        $return = array();
        $soft   = $this->pegawai->this_kriteria_psikolog();
        foreach ($soft as $key => $value) {
            $return[$value->kode_kompetensi] = $value->nilai;
        }
        return $return;
    }

    private function process($arrAcuan, $arrSoft)
    {
        foreach ($arrAcuan as $key => $value) {
            //calulate grey
            if ($arrSoft[$key] < $arrAcuan[$key]){
                $this->below_grey++;
                if ($arrSoft[$key] == 0)
                    $this->zero++;
            }else if ($arrSoft[$key] == $arrAcuan[$key])
                $this->on_grey++;
            else
                $this->above_grey++;

            //calculate critical
            if(in_array($key, $this->criticals))
            {
                if ($arrSoft[$key] < $arrAcuan[$key])
                    $this->critical_below++;
            }
            $this->on_grey          = intval($this->on_grey);
            $this->below_grey       = intval($this->below_grey);
            $this->above_grey       = intval($this->above_grey);
            $this->zero             = intval($this->zero);
            $this->critical_below   = intval($this->critical_below);
        }
    }

    private function mapping_evaluation($arrAcuan)
    {
        if ($this->below_grey == 0 && $this->above_grey >= 6)
            $this->nilai = $this->SANGAT_POTENSIAL;
        else if ($this->critical_below == 0 && $this->below_grey <= 4 && $this->above_grey <= (count($arrAcuan)-6))
            $this->nilai = $this->POTENSIAL;
        else if ($this->below_grey <= 4 && $this->critical_below == 0 && $this->on_grey >=10)
            $this->nilai = $this->POTENSIAL;
        else if ($this->zero == 0 && $this->below_grey <= 3 && $this->critical_below >= 1 && $this->on_grey >= 8 )
            $this->nilai = $this->CUKUP_POTENSIAL;
        else if ($this->zero == 0 && $this->below_grey <= 6 && $this->critical_below <= 2 && $this->on_grey >= 6)
            $this->nilai = $this->KURANG_POTENSIAL;
        else if($this->below_grey > 6 && $this->critical_below >=2)
            $this->nilai = $this->TIDAK_POTENSIAL;
        else
            $this->nilai = $this->TIDAK_POTENSIAL;
    }
}