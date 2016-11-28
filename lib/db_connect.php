<?php

	$db=mysql_connect("localhost","root","");
	if(!$db){
		die('could not connect:'.mysql_error());
	}else{
        echo "bisa";
    }
	mysql_select_db('siakpool_beta');

?>