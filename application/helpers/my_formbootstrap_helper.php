<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//MY_FormBootstrap_helper.php

//function to form select dynamic
	if ( ! function_exists('form_selectd')){
		function form_selectd($label, $str,$list, $name, $kode_pk, $kode_banding, $value_pk){
			$form = '<div class="form-group">
                <label>'.$label.'</label>
                    <div class="input-group">
                       	<select class="form-control" name="'.$name.'">
                            <option value="">'.$str.'</option>';
			foreach ($list as $key => $value) 
            {
                $angga = $kode_banding == $value->$kode_pk ? 'selected="selected"' : '';
            	$form .= '<option '.$angga.' value="'.$value->$kode_pk.'">'.$value->$kode_pk.'<?</option>';
            }
            $form .= '</select></div></div>';
            return $form;
		}
	}

	//function to form select dynamic
    if ( ! function_exists('form_select')){
        function form_select($label, $str,$list, $name, $key_banding){
            $form = '<div class="form-group">
                        <label>'.$label.'</label>
                        <div class="input-group">
                            <select class="form-control" name="'.$name.'">
                                <option value="">'.$str.'</option>';
                                foreach ($list as $key => $value) 
                                {
                                    $angga = $key_banding == $key ? 'selected="selected"' : '';
                                    $form .= '<option '.$angga.'value="'.$key.'">'.$value.'<?</option>';
                                }
            $form .= '</select></div></div>';
            return $form;
        }
    }

    if ( ! function_exists('form_selectx')){
        function form_selectx($label, $str,$list, $name, $key_banding){
            $form = '<div class="col-xs-12">
                        <div class="form-group col-xs-2"> 
                            <label>'.$label.'</label>                     
                        </div>
                        <div class="form-group col-xs-3">                        
                            <div class="input-group" style="width: 100%;">
                                <select class="form-control" name="'.$name.'">
                                    <option value="">'.$str.'</option>';
                                    foreach ($list as $key => $value) 
                                    {
                                        $angga = $key_banding == $key ? 'selected="selected"' : '';
                                        $form .= '<option '.$angga.'value="'.$key.'">'.$value.'<?</option>';
                                    }
            $form .= '</select></div></div></div>';
            return $form;
        }
    }

    //function to form select dynamic
    if ( ! function_exists('form_select_array')){
        function form_select_array($label, $str,$list, $name, $key_banding, $valueP, $key, $id){
            $form = '<div class="form-group">
                <label>'.$label.'</label>
                    <div class="input-group">
                        <select class="form-control" name="'.$name.'" id="'.$id.'">
                            <option value="">'.$str.'</option>';
            foreach ($list as $key => $value) 
            {
                //$angga = $key_banding == $key ? 'selected="selected"' : '';
                $form .= '<option value="'.$value->$key.'">'.$value->$valueP.'<?</option>';
            }
            $form .= '</select></div></div>';
            return $form;
        }
    }


	//function to form text
	if ( ! function_exists('form_text')){
		function form_text($label, $name, $value, $placeholder, $id){
			$form = '<div class="form-group">
                    <label>'.$label.'</label>
                    <div class="input-group">
                    <input type="text" class="form-control" name="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.'" id="'.$id.'">
                   	</div>
                    </div>';
			return $form;
		}
	}

	//function to form text
	if ( ! function_exists('form_text_disabled')){
		function form_text_disabled($label, $name, $value){
			$form = '<div class="form-group">
                    <label>'.$label.'</label>
                    <div class="input-group disabled">
                    <input type="text" class="form-control" disabled="true" name="'.$name.'" value="'.$value.'">
                   	</div>
                    </div>';
			return $form;
		}
	}

    //function to form text
    if ( ! function_exists('form_date')){
        function form_date($label, $name, $id, $value){
            $form = '<div class="form-group">
                    <label>'.$label.'</label>
                    <div class="input-group disabled">
                    <input type="text" class="form-control" id="'.$id.'" name="'.$name.'" value="'.$value.'">
                    </div>
                    </div>';
            return $form;
        }
    }
