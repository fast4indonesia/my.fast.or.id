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
                Manejemen Akses
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{$base_url}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#"> Manajemen Akses
</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data User Role</h3>
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
                            <table id="example" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Role</th>
                                        <th width="15%">Action Menu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($data))
                                        @foreach ($data as $key => $value)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>
                                                    <a href="{{$base_url}}access/setting/{{$value->idx}}" class=""><button class="fa fa-pencil" title="edit"></button></a>

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