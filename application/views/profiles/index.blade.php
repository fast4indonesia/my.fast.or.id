@extends('layouts.application')
@section('sidebar')
    @include('includes.sidebar_sdm')
@stop
@section('content')


<!-- Main content -->
            <div class="content-wrapper">

                <!-- Page header -->
                <div class="page-header no-padding">
                    <div class="page-header-content">
                        <div class="page-title">
                            <h4>
                                <i class="icon-arrow-left52 position-left"></i> 
                                <span class="text-semibold">User Pages</span> - Profile
                            </h4>
                        </div>
                    </div>

                    <div class="breadcrumb-line breadcrumb-line-wide no-margin">
                        <ul class="breadcrumb">
                            <li><a href=""><i class="icon-home2 position-left"></i> Home</a></li>
                            <li class="active">Profile</li>
                        </ul>

                       
                    </div>
                </div>
                <!-- /page header -->


                <!-- Cover area -->
                <div class="profile-cover">
                    <div class="profile-cover-img" style="height:150px"></div>
                    <div class="media">
                        <div class="media-left">
                            <a href="#" class="profile-thumb">
                                <img src="{{$base_url}}resources/assets/images/placeholder.jpg" class="img-circle" alt="">
                            </a>
                        </div>

                        <div class="media-body">
                            <h1>Hanna Dorman <small class="display-block">UX/UI designer</small></h1>
                        </div>
                    </div>
                </div>
                <!-- /cover area -->


                <!-- Toolbar -->
                <div class="navbar navbar-default navbar-xs content-group">
                    <ul class="nav navbar-nav visible-xs-block">
                        <li class="full-width text-center"><a data-toggle="collapse" data-target="#navbar-filter"><i class="icon-menu7"></i></a></li>
                    </ul>

                    <div class="navbar-collapse collapse" id="navbar-filter">
                        <ul class="nav navbar-nav element-active-slate-400">
                            <li class="active"><a href="#activity" data-toggle="tab"><i class="icon-menu7 position-left"></i> Activity</a></li>
                            <li><a href="#basic" data-toggle="tab"><i class="fa fa-user position-left"></i> Basic Info </a></li>
                            <li><a href="#work" data-toggle="tab"><i class="fa fa-university position-left"></i> Work & Education </a></li>
                            <li><a href="#company" data-toggle="tab"><i class="fa fa-building position-left"></i> Company </a></li>
                            <li><a href="#organization" data-toggle="tab"><i class="fa fa-connectdevelop position-left"></i> Organization </a></li>
                        </ul>

                        <!-- <div class="navbar-right">
                            <ul class="nav navbar-nav">
                                <li><a href="#"><i class="icon-stack-text position-left"></i> Notes</a></li>
                                <li><a href="#"><i class="icon-collaboration position-left"></i> Friends</a></li>
                                <li><a href="#"><i class="icon-images3 position-left"></i> Photos</a></li>                                
                            </ul>
                        </div> -->
                    </div>
                </div>
                <!-- /toolbar -->


                <!-- Content area -->
                <div class="content">

                    <div class="alert alert-info alert-styled-left alert-arrow-left alert-component">
                        <h6 class="alert-heading text-semibold">Kerahasiaan Data</h6>
                        Data yang Anda isikan akan dijamin kerahasiaannya dan hanya dipergunakan untuk kepentingan alumni atas izin pemiliknya.
                    </div>

                    <!-- User profile -->
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="tabbable">
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="activity">
                                        <div class="timeline timeline-left content-group">
                                            <div class="timeline-container">

                                                <!-- Sales stats -->
                                                <div class="timeline-row">
                                                    <div class="timeline-icon">
                                                        <a href="#"><img src="{{$base_url}}resources/assets/images/placeholder.jpg" alt=""></a>
                                                    </div>

                                                    <div class="panel panel-flat timeline-content">
                                                        <div class="panel-heading">
                                                            <h6 class="panel-title">Coming Soon</h6>
                                                            <div class="heading-elements">
                                                                <!-- <span class="heading-text"><i class="icon-history position-left text-success"></i> Updated 3 hours ago</span> -->

                                                                <ul class="icons-list">
                                                                    <!-- <li><a data-action="reload"></a></li> -->
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="basic">
                                        <div class="panel">
                                            <div class="panel-heading bg-info">
                                                <h6 class="panel-title">Profile Information</h6>
                                            </div>

                                            <div class="panel-body">
                                                <form action="#">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Full Name</label>
                                                                <input type="text" value="Mahmud Abbas" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Place of Birth</label>
                                                                <input type="text" value="Majenang" class="form-control">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Date of Birth</label>
                                                                <input type="text" value="17 August 1945" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Blood Type</label>
                                                                <select class="form-control" name="bloodtype" >
                                                                    <option value="A" selected="selected">A</option> 
                                                                    <option value="B">B</option> 
                                                                    <option value="O">O</option> 
                                                                    <option value="AB">AB</option> 
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Religion</label>
                                                                <select class="form-control" name="religion" >
                                                                    <option value="Moslem" selected="selected">Moslem</option> 
                                                                    <option value="Christian">Christian</option> 
                                                                    <option value="Protestan">Protestan</option> 
                                                                    <option value="Hindu">Hindu</option> 
                                                                    <option value="Budha">Budha</option> 
                                                                    <option value="Konghucu">Konghucu</option> 
                                                                    <option value="other">...</option> 
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Current Address</label>
                                                                <textarea value="Ring street 12" class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>City</label>
                                                                <input type="text" value="Munich" class="form-control">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>State/Province</label>
                                                                <input type="text" value="Bayern" class="form-control">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Country</label>
                                                                <select class="form-control">
                                                                    <option value="germany" selected="selected">Germany</option> 
                                                                    <option value="france">France</option> 
                                                                    <option value="spain">Spain</option> 
                                                                    <option value="netherlands">Netherlands</option> 
                                                                    <option value="other">...</option> 
                                                                    <option value="uk">United Kingdom</option> 
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>Phone</label>
                                                                <input type="text" value="+621-555-9999" class="form-control">
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>Mobile Phone 1</label>
                                                                <input type="text" value="+628-456-9999" class="form-control">
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>Mobile Phone 2</label>
                                                                <input type="text" value="+628-675-9999" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>


                                            <div class="panel-heading bg-info">
                                                <h6 class="panel-title">Bank Account</h6>
                                            </div>

                                            <div class="panel-body">
                                                <form action="#">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Account Number</label>
                                                                <input type="text" value="131000127008" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Bank</label>
                                                                <input type="text" value="Mandiri" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Account Name</label>
                                                                <input type="text" value="Mahmud Abbas" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>


                                            <div class="panel-heading bg-info">
                                                <h6 class="panel-title">Social Account</h6>
                                            </div>

                                            <div class="panel-body">
                                                <form action="#">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Current Email</label>
                                                                <input type="text" value="" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Company Email</label>
                                                                <input type="text" value="" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Blog</label>
                                                                <input type="text" value="" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Website</label>
                                                                <input type="text" value="http://" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Social Media</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-addon"><i class="fa fa-linkedin-square"></i></div>
                                                                    <input type="text" name="linkedin" class="form-control" placeholder="your linkedin account" aria-required="true">
                                                                </div>
                                                                <br/>
                                                                <div class="input-group">
                                                                    <div class="input-group-addon"><i class="fa fa-facebook-square"></i></div>
                                                                    <input type="text" name="facebook" class="form-control" placeholder="your fb account" aria-required="true">
                                                                </div>
                                                                <br/>
                                                                <div class="input-group">
                                                                    <div class="input-group-addon"><i class="fa fa-instagram"></i></div>
                                                                    <input type="text" name="instagram" class="form-control" placeholder="your instagram account" aria-required="true">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>


                                            <div class="panel-heading bg-info">
                                                <h6 class="panel-title">Account Settings</h6>
                                                <!-- <div class="heading-elements">
                                                    <ul class="icons-list">
                                                        <li><a data-action="collapse"></a></li>
                                                        <li><a data-action="reload"></a></li>
                                                        <li><a data-action="close"></a></li>
                                                    </ul>
                                                </div> -->
                                            </div>

                                            <div class="panel-body">
                                                <form action="#">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Username</label>
                                                                <input type="text" value="Kopyov" readonly="readonly" class="form-control">
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label>Current password</label>
                                                                <input type="password" value="password" readonly="readonly" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>New password</label>
                                                                <input type="password" placeholder="Enter new password" class="form-control">
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label>Repeat password</label>
                                                                <input type="password" placeholder="Repeat new password" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="text-right">
                                                        <button type="submit" class="btn btn-primary">Save <i class="icon-arrow-right14 position-right"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane fade" id="work">
                                        <div class="panel">
                                            <div class="panel-heading bg-info">
                                                <h6 class="panel-title">Work Information</h6>
                                            </div>

                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Full Name</label>
                                                            <input type="text" value="Kopyov" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="panel-heading bg-info">
                                                <h6 class="panel-title">Education Information</h6>
                                            </div>

                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Full Name</label>
                                                            <input type="text" value="Kopyov" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane fade" id="company">
                                        <div class="panel">
                                            <div class="panel-heading bg-info">
                                                <h6 class="panel-title">Company Information</h6>
                                            </div>

                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Full Name</label>
                                                            <input type="text" value="Kopyov" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane fade" id="organization">
                                        <div class="panel">
                                            <div class="panel-heading bg-info">
                                                <h6 class="panel-title">Organization Information</h6>
                                            </div>

                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Organization Name</label>
                                                            <input type="text" value="Kopyov" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="panel panel-flat">
                                <div class="panel-heading">
                                    <h6 class="panel-title">Latest connections</h6>
                                    <div class="heading-elements">
                                        <span class="badge badge-success heading-text">- </span>
                                    </div>
                                </div>

                                <ul class="media-list media-list-linked pb-5">
                                    <li class="media-header">Coming Soon</li>

                                </ul>
                            </div>
                        </div>
                    </div>



                    @include('includes.footer')

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

@stop