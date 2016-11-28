@extends('layouts.login')

<!-- content -->
@section('content')
        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">

                <!-- Tabbed form -->
                <div class="tabbable panel login-form width-400">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="active"><a href="#basic-tab1" data-toggle="tab"><h6><i class="icon-checkmark3 position-left"></i> Already a user?</h6></a></li>
                        <li><a href="#basic-tab2" data-toggle="tab"><h6><i class="icon-plus3 position-left"></i> Create an account</h6></a></li>
                    </ul>

                                       
                    <div class="tab-content panel-body">
                        <div class="tab-pane fade in active" id="basic-tab1">
                            <form action="{{$base_url}}/sessions/create" method="post">
                                <div class="text-center">
                                    <div class="">
                                        <img src="{{$base_url}}/resources/assets/images/fast-logo.png" width="90px" height="90px" alt="">
                                    </div>
                                    <h5 class="content-group">Login to your account <small class="display-block">Your credentials</small></h5>
                                </div>

                                <div class="form-group has-feedback has-feedback-left">
                                    <input type="text" class="form-control" placeholder="Username" name="email" required="required">
                                    <div class="form-control-feedback">
                                        <i class="icon-user text-muted"></i>
                                    </div>
                                </div>

                                <div class="form-group has-feedback has-feedback-left">
                                    <input type="password" class="form-control" placeholder="Password" name="password" required="required">
                                    <div class="form-control-feedback">
                                        <i class="icon-lock2 text-muted"></i>
                                    </div>
                                </div>

                                <div class="form-group login-options">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- <label class="checkbox-inline">
                                                <input type="checkbox" class="styled" checked="checked">
                                                Remember
                                            </label> -->
                                        </div>

                                        <div class="col-sm-6 text-right">
                                            <a href="">Forgot password?</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn bg-blue btn-block">Login <i class="icon-arrow-right14 position-right"></i></button>
                                </div>
                            </form>
                         </div>

                        <div class="tab-pane fade" id="basic-tab2">
                            <form action="{{$base_url}}/sessions/register" method="post">
                                <div class="text-center">
                                    <div class="">
                                        <img src="http://localhost/fast/resources/assets/images/fast-logo.png" width="90px" height="90px" alt="">
                                    </div>
                                    <h5 class="content-group">Create new account <small class="display-block">All fields are required</small></h5>
                                </div>

                                <div class="form-group has-feedback has-feedback-left">
                                    <input type="text" class="form-control" name="nim" placeholder="Your NIM">
                                    <div class="form-control-feedback">
                                        <i class="icon-user-check text-muted"></i>
                                    </div>
                                </div>

                                <div class="form-group has-feedback has-feedback-left"> 
                                    <select class="form-control" name="jurusan">
                                        <option value="">- Choose Your Major -</option>
                                    </select>
                                    <div class="form-control-feedback">
                                        <i class="fa fa-graduation-cap text-muted"></i>
                                    </div>
                                </div>

                                <div class="form-group has-feedback has-feedback-left">
                                    <input type="email" class="form-control" name ="email" placeholder="Your Email">
                                    <div class="form-control-feedback">
                                        <i class="icon-mention text-muted"></i>
                                    </div>
                                </div>

                                <div class="form-group has-feedback has-feedback-left">
                                    <input type="number" class="form-control" name ="no_telp" placeholder="Your Mobile Phone">
                                    <div class="form-control-feedback">
                                        <i class="fa fa-mobile-phone text-muted"></i>
                                    </div>
                                </div>


                                <button type="submit" class="btn bg-indigo-400 btn-block">Register <i class="icon-circle-right2 position-right"></i></button>
                               <span class="help-block text-center no-margin">By continuing, you're confirming that you've read our <a href="#">Terms &amp; Conditions</a> and <a href="#">Privacy Policy</a></span>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /tabbed form -->


                <!-- Footer -->
                <div class="footer text-white">
                    <p class="made-with-love">
                        &copy; {{date("Y")}} <a href="#" class="text-white">Made with</a>  <img src="{{$base_url}}/resources/assets/images/heart.svg" alt=""> <i> by </i> <a href="#" class="text-white" target="_blank">ICT Department FAST</a>
                    </p>
                </div>
                <!-- /footer -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

@stop
