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
                <li><a href="#"> Manajemen Akses</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Pengaturan Akses Role {{$role->name}}</h3>
                        </div><!-- /.box-header -->
                        <form method="post" action="{{$base_url}}access/store/{{$role->idx}}">
                        <div class="box-body table-responsive">

                            <table id="example" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="15%"><input type="checkbox" id="selAll" class="control-form"> Select all</th>
                                        <th>Nama Modul / Submodul</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($module))
                                        @foreach ($module as $element)
                                            <tr class="module">
                                                <td><input name="data[]" {{$element->has_permission($role->idx) ? 'checked' : ''}} value="{{$element->modul_id}}" type="checkbox" class="checks parent {{$element->modul_id}}"></td>
                                                <td>{{$element->modul_name}}</td>
                                            </tr>
                                            @if(!is_null($element->submodule()))
                                                @foreach ($element->submodule() as $el)
                                                    <tr class="submodule">
                                                        <td><input {{$el->has_permission($role->idx) ? 'checked' : ''}} name="data[]" value="{{$el->modul_id}}" type="checkbox" class="checks childs submodul-{{$element->modul_id}}"></td>
                                                        <td>{{$el->modul_name}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{$base_url}}access" class="btn btn-default">Cancel</a>
                        </div>
                        </form>
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div>
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
@stop