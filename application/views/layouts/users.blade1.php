<?php
    include (base_url()."/lib/db_connect.php");
    $sql = "SELECT * FROM karyawan";
    $res = mysql_query($sql);

    // echo $sql;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Aplikasi Talent Management System | Management SDM</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="{{$base_url}}assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="{{$base_url}}assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="{{$base_url}}assets/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{$base_url}}assets/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />

        <link href="{{$base_url}}assets/css/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="{{$base_url}}assets/css/datepicker.css" rel="stylesheet" type="text/css" />
        <!-- <link href="{{$base_url}}assets/js/plugins//select2/select2.css" rel="stylesheet" type="text/css" /> -->
        <link href="{{$base_url}}assets/css/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css"
        />

        <link href="{{$base_url}}assets/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo local_path('assets/js/plugins/select2/select2.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{$base_url}}assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.../../js/1.3.0/respond.min.js"></script>

        <![endif]-->


        <script type="text/javascript">
            function get_data(){

                nipeg = document.getElementById('nipeg').value;

                <?php
                    while ($user_info = mysql_fetch_array($res)) {
                        $email      = $user_info["email"];
                        $temp       = explode("@", $email);
                        $username   = $temp[0];
                        // echo "alert('".$email."')";
                        // echo "alert('".$username."')";
                ?>
                if (nipeg == <?=$user_info["nipeg"]?>{
                    document.getElementById('email').value = <?=$email?>;
                    document.getElementById('username').value = <?=$username?>;
                }
                <?php
                    }
                ?>

            }
        </script>
       
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        @include('includes.header')

        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            @yield('sidebar')

            <!-- Right side column. Contains the navbar and content of the page -->
            @yield('content')
        </div><!-- ./wrapper -->

        <script src="{{$base_url}}assets/js/jquery.min.js"></script>
        <script src="{{$base_url}}assets/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <script src="{{$base_url}}assets/js/bootstrap.js" type="text/javascript"></script>
        <script src="{{$base_url}}assets/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="{{$base_url}}assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <script src="{{$base_url}}assets/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        <script src="{{$base_url}}assets/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="{{$base_url}}assets/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <script src="{{$base_url}}assets/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="{{$base_url}}assets/js/files.js" type="text/javascript"></script>
        <script src="{{$base_url}}assets/js/conf.js" type="text/javascript"></script>
        <script src="{{$base_url}}assets/js/datepicker.js" type="text/javascript"></script>


        <script src="{{$base_url}}assets/js/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo local_path('assets/js/plugins/select2/select2.js'); ?>" type="text/javascript"></script>
        <script src="{{$base_url}}assets/js/plugins/colorpicker/bootstrap-colorpicker.js" type="text/javascript"></script>
        <script src="{{$base_url}}assets/js/plugins/select2/select2.min.js" type="text/javascript"></script>
        <script src="{{$base_url}}assets/js/AdminLTE/app.js" type="text/javascript"></script>
        <script src="{{$base_url}}assets/js/AdminLTE/angga.js" type="text/javascript"></script>
        <script src="{{$base_url}}assets/js/AdminLTE/evan.js" type="text/javascript"></script>
        <script src="{{$base_url}}assets/js/AdminLTE/demo.js" type="text/javascript"></script>
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $('[data-toggle="confirmation"]').confirmation({

                });
                $("#example1").dataTable({
                    "fnDrawCallback": function (oSettings) {
                        $("[data-toggle='confirmation']").confirmation();
                    }
                });

                $(".examples").dataTable({
                    "fnDrawCallback": function (oSettings) {
                        $("[data-toggle='confirmation']").confirmation();
                    }
                });
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });

                $('.dates').datepicker({
                    format: 'dd-mm-yyyy'
                });
                $("select").select2();
                $(".my-colorpicker2").colorpicker();
                $('.timepicker').timepicker();

            });
        </script> 
        <span class="hide" id="urlx">{{$base_url}}</span>
    </body>
</html>