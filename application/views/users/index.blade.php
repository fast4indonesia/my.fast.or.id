@extends('layouts.application')
@section('sidebar')
    @include('includes.sidebar_sdm')
@stop

<!-- content -->
@section('content')
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Manejemen Pengguna
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{$base_url}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#"> Manajemen Pengguna
</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Pengguna</h3>
                        </div><!-- /.box-header -->

                        <div class="box-body table-responsive">
                            @foreach ($flash as $key => $value)
                            @if($value)
                            <div class="alert alert-{{$key}} alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                {{$value}}
                            </div>
                            @endif
                            @endforeach
                            <div class="wraps">
                                <div class="left">
                                     <a href="{{$base_url}}users/create" class="btn btn-flat btn-primary">
                                        Tambah Pengguna
                                    </a>
                                </div>
                            </div>

                            <br/>
                            <br/>
                            <br>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User ID</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Nipeg</th>
                                        <th>Last Login</th>
                                        <th>Action Menu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($users))
                                        @foreach ($users as $key => $element)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $element->user_id }}</td>
                                                <td>{{ $element->email }}</td>
                                                <td>{{ $element->role }}</td>
                                                <td>{{ $element->nipeg }}</td>
                                                <td>{{ $element->last_login }}</td>
                                                <td>
                                                    <a href="{{$base_url}}users/edit/{{$element->user_id}}"><button class="fa fa-pencil" title="edit"></button></a>
                                                    <a href="{{$base_url}}users/destroy/{{$element->user_id}}" data-toggle="confirmation" data-placement="top" data-original-title="" title=""><button class="fa fa-times"  title="delete"></button></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div>
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
@stop