<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//function to generate url in local
	if ( ! function_exists('local_a_href')){
		function local_a_href($url,$text,$attrib=""){
			return anchor(base_url()."index.php/".$url,$text,$attrib);
		}
	}
	if ( ! function_exists('ext_a_href')){
		function ext_a_href($url,$text,$attrib=""){
			return "<a href='$url' $attrib>$text</a>";
		}
	}

	//function to generate link
	if ( ! function_exists('local_url')){
		function local_url($url){
			return base_url()."index.php/".$url;
		}
	}

	//function to generate link
	if ( ! function_exists('local_path')){
		function local_path($url){
			return base_url().$url;
		}
	}

	//function to generate link
	if ( ! function_exists('total_performance')){
		function total_performance($var){
			$jml = $var->nilai_sasaran_kerja + $var->nilai_penugasan_peran_khusus;
			$jml += $var->nilai_prestasi_diklat + $var->nilai_ide_terobosan;
			$jml += $var->nilai_knowledge_management + $var->nilai_penugasan_luar_peran_jabatan;
			$jml += $var->nilai_sertifikasi_kompetensi + $var->nilai_assesment_hard_competency;
			return $jml;
		}
	}

	if ( ! function_exists('per_one_step')){
		function per_one_step($data){
			if ($data->periode == 2){
				$arr[0] = $data->tahun;
				$arr[1] = $data->periode-1;
			}
			else{
				$arr[0] = $data->tahun-1;
				$arr[1] = $data->periode+1;
			}
			return $arr;
		}
	}

	if ( ! function_exists('per_two_step')){
		function per_two_step($data){
			$arr[0] = $data->tahun -1;
			$arr[1] = $data->periode;
			return $arr;
		}
	}

	if ( ! function_exists('one_step')){
		function one_step(){
			$per = date('m') < 7 ? 1 : 2;
			if ($per == 2){
				$arr[0] = date('Y');
				$arr[1] = $per-1;
			}
			else{
				$arr[0] = date('Y')-1;
				$arr[1] = $per+1;
			}
			return $arr;
		}
	}

	if ( ! function_exists('two_step')){
		function two_step(){
			$per = date('m') < 7 ? 1 : 2;
			$arr[0] = date('Y')-1;
			$arr[1] = $per;
			return $arr;
		}
	}

	if ( ! function_exists('total_potensi')){
		function total_potensi($var){
			$jml = $var->nilai_kompetensi + $var->nilai_assesment_soft_competency;
			return $jml;
		}
	}


	//function to generate link foto restaurant
	if ( ! function_exists('admin_assets')){
		function admin_assets($url){
			return base_url()."assets/admin/".$url;
		}
	}

	//function to generate timestamp
	if ( ! function_exists('getTimeStamp')){
		function getTimeStamp(){
			date_default_timezone_set ("Asia/Jakarta");
			return date("Y-m-d H:i:s");
		}
	}


	//function to generate timestamp
	if ( ! function_exists('getDateNow')){
		function getDateNow(){
			date_default_timezone_set ("Asia/Jakarta");
			return date("Y-m-d");
		}
	}


	if ( ! function_exists('readable_date')){
		function readable_date($tgl){
			$tgl = explode("-", $tgl);
			$bulan = array("","January","February","March","April","May","June","July","August","September","October","November","December");
			return $tgl[2]." ".$bulan[intval($tgl[1])]." ".$tgl[0];
		}
	}


	if ( ! function_exists('escape')){
		function escape($var,$post=true){
			$var=($post==true)?getPost($var):$var;
			if(is_array($var)){
				foreach($var as $id=>$val){
					$var[$id]=htmlentities(trim(mysql_real_escape_string($val)));
				}
				return $var;
			}else{
				return htmlentities(trim(mysql_real_escape_string($var)));
			}
		}
	}

	if ( ! function_exists('getPost')){
		function getPost($var){
			if (!isset($_POST[$var])){
			    return "";
			}else{
			    return $_POST[$var];
			}
		}
	}

	if ( ! function_exists('doGet')){
		function doGet($var){
			if (!isset($_GET[$var])){
			    return "";
			}else{
			    return $_GET[$var];
			}
		}
	}

	if ( ! function_exists('filter_tag')){
		function filter_tag($var,$alw=""){
			$allowTag=($alw=="")?"<br>":$alw;
			if(is_array($var)){
				foreach($var as $id=>$val){
					$var[$id]=str_replace("\n","<br />",$var[$id]);
					$var[$id]=str_replace("\r","",$var[$id]);
					$var[$id]=str_replace("\\r","",$var[$id]);
					$var[$id]=str_replace("\\n","<br />",$var[$id]);
					$var[$id]=strip_tags(trim(mysql_real_escape_string($val)),$allowTag);
				}
				return $var;
			}else{
				$var=str_replace("\n","<br />",$var);
				$var=str_replace("\r","",$var);
				$var=str_replace("\\r"," ",$var);
				$var=str_replace("\\n","<br />",$var);
				return strip_tags(trim(mysql_real_escape_string($var)),$allowTag);
			}
		}
	}

	if ( ! function_exists('my_select')){
		function my_select($data, $name, $selected = '', $disable = false){
			if ($disable)
			{
				$str = '<select class="form-control" name="'.$name.'" disabled>';
			}
			else
			{
				$str = '<select class="form-control" name="'.$name.'">';
			}

			foreach ($data as $key => $value)
			{
				if ($selected == $key)
				{
					$str .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
				}
				else
				{
					$str .= '<option value="'.$key.'">'.$value.'</option>';
				}
			}
			$str .= '</select>';
			return $str;
		}
	}

	if ( ! function_exists('try_display')){
		function try_display($var){
			if(isset($var)) {
				echo $var;
			} else {
				echo "";
			}
		}
	}

	if ( ! function_exists('split_hard_kompetensi')){
		function split_hard_kompetensi($var){
			$arr = explode("Contoh", $var);
			$output = "<div>".$arr[0]."</div>";
			if(isset($arr[1]))
			{
				$output .= "<div style='margin-top:5px;border-top:1px solid #ccc'>Contoh".$arr[1]."</div>";
			}
			echo $output;
		}
	}


	if ( ! function_exists('RecurseArray')){
		function RecurseArray( $data, $kode, $c )
		{
			if (count($data->all_jabatan_bawahan()) > 0){
			    echo '<ul>';
			    foreach ($data->all_jabatan_bawahan() as $key => $cat)
			    {
			        echo '<li data-kode="'.$cat->kode_self.'" data-jabatan="'.$cat->kode_jabatan.'" class="unic'.$c++.' child" id="s'.substr(md5(rand()), 0, 7).'s">';
			        echo '<p class="titles">'.$cat->jabatan()->nama_jabatan.'</p>';

			        if (count($cat->all_jabatan_bawahan()) > 0){
			        	RecurseArray($cat, $kode, $c);
			        }

			        echo '</li>';
			    }
			    echo '</ul>';
			}
		}
	}

	if ( ! function_exists('RecurseArrays')){
		function RecurseArrays( $data, $kode, $c, $arr)
		{
			if (count($data->all_jabatan_bawahan()) > 0){
			    echo '<ul>';
			    foreach ($data->all_jabatan_bawahan() as $key => $cat)
			    {
			        echo '<li data-kode="'.$cat->kode_self.'" data-jabatan="'.$cat->kode_jabatan.'" class="unic'.$c++.' child" id="s'.substr(md5(rand()), 0, 7).'s">';
			        echo '<p class="indikator"></p>';
			        echo '<p class="titles">'.$cat->jabatan()->nama_jabatan.'</p>';
			        echo '<p class="names">'.$cat->employee($arr)->nama.'</p>';
                	echo '<p class="nipes">'.$cat->employee($arr)->nipeg.'</p>';
                	$arr[] = $cat->employee()->nipeg;
			        if (count($cat->all_jabatan_bawahan()) > 0){
			        	RecurseArrays($cat, $kode, $c, $arr);
			        }

			        echo '</li>';
			    }
			    echo '</ul>';
			}
		}
	}

	if ( ! function_exists('kategori_makalah')){
		function kategori_makalah($var){
			$output = '';
			if($var >= 90)
				$output = "Sangat Baik";
			else if ($var >=80)
				$output = "Baik";
			else if ($var >=70)
				$output = "Cukup";
			else
				$output = "Tidak Baik";
			echo $output;
		}
	}
