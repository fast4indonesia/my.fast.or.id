<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Member Forum Alumni Universitas Telkom</title>

        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="{{$base_url}}resources/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="{{$base_url}}resources/assets/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
        <link href="{{$base_url}}resources/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="{{$base_url}}resources/assets/css/core.css" rel="stylesheet" type="text/css">
        <link href="{{$base_url}}resources/assets/css/components.css" rel="stylesheet" type="text/css">
        <link href="{{$base_url}}resources/assets/css/colors.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->

        <!-- Core JS files -->

        <script type="text/javascript" src="{{$base_url}}resources/assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="{{$base_url}}resources/assets/js/core/libraries/jquery.min.js"></script>
        <script type="text/javascript" src="{{$base_url}}resources/assets/js/core/libraries/bootstrap.min.js"></script>
        <script type="text/javascript" src="{{$base_url}}resources/assets/js/plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->

        <!-- Theme JS files -->
        <script type="text/javascript" src="{{$base_url}}resources/assets/js/plugins/visualization/d3/d3.min.js"></script>
        <script type="text/javascript" src="{{$base_url}}resources/assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
        <script type="text/javascript" src="{{$base_url}}resources/assets/js/plugins/forms/styling/switchery.min.js"></script>
        <script type="text/javascript" src="{{$base_url}}resources/assets/js/plugins/forms/styling/uniform.min.js"></script>
        <script type="text/javascript" src="{{$base_url}}resources/assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
        <script type="text/javascript" src="{{$base_url}}resources/assets/js/plugins/ui/moment/moment.min.js"></script>
        <script type="text/javascript" src="{{$base_url}}resources/assets/js/plugins/pickers/daterangepicker.js"></script>

        <script type="text/javascript" src="{{$base_url}}resources/assets/js/core/app.js"></script>
        <!-- /theme JS files -->

        <!-- Theme JS files -->
        <script type="text/javascript" src="{{$base_url}}resources/assets/js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>
        <script type="text/javascript" src="{{$base_url}}resources/assets/js/pages/extra_fullcalendar.js"></script>
        <!-- /theme JS files -->

    </head>



    <body>

        @include('includes.header')
        <div class="page-container">
            <div class="page-content">
                @yield('sidebar')


                @yield('content')

            </div>
        </div>
    </body>
</html>