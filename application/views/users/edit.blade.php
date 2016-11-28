@extends('layouts.application')
@section('sidebar')
    @include('includes.sidebar_sdm')
@stop

<!-- content -->
@section('content')
 <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Manajemen Pengguna
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo local_path('') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo local_path('users') ?>">Manajemen Pengguna</a></li>
                    </ol>
                </section>


                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">Form Edit Manajemen Pengguna</h3>
                                </div>
                               {{ Former::open()->action($base_url.'users/store') }}
                                <div class="box-body">
                                    @if(!empty($flashdata))
                                        <div class="callout callout-danger">
                                            <h4>Gagal menyimpan data karena kesalahan berikut:</h4>
                                             <ul>
                                                @foreach ($flashdata as $val)
                                                    <li>{{$val}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif 

                                    <!-- {{ Former::select('nipeg')->label('Nama Pegawai')->options($listkaryawan)->class('form-control small-form')->id('nipeg')->name('nipeg')}}  

                                    {{ Former::text('email')->label('Email')->class('form-control small-form')->id('email')->name('email')}}

                                    {{ Former::select('role')->options($data->listrole)->class('form-control small-form')->id('role')->name('role')}}
 -->
                                    @foreach ($data->attributes() as $key => $value)

                                        {{ Former::text($key)->value($value)->class('form-control small-form')->state($data->is_invalid($key) ? 'error' : '') }}
                                         
                                        
                                    @endforeach

                                    
                                    
                                </div>
                            <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn">Reset</button>
                            </div><!-- /.input group -->
                            {{ Former::close() }}

                    </div>
                </section>
            </aside>
           
@stop