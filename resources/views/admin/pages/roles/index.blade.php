@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        @include('inc.errors')
        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            {{-- <h1>قائمة المهام</h1> --}}
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{ trans('admin.home') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('admin.roles') }}</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title"> {{ trans('admin.roles_list') }} </h4>
                                     @can('اضافة-مهمة')
                                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" title="{{trans('admin.create_role')}}">
                                        <span>{{ trans('admin.create_role') }}</span>
                                    </button>
                                    @endcan
                                </div>

                            </div>

                            <div class="card-body">
                                @if($roles->count() > 0)
                                    <style>
                                        tr , .table thead th  {
                                            text-align: center;
                                        }
                                    </style>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                            <th style="width: 10px">#</th>
                                            <th>{{ trans('admin.name') }}</th>
                                            <th>{{ trans('admin.show') }}</th>
                                            @can('تعديل-مهمة')
                                            <th>{{ trans('admin.edit') }}</th>
                                            @endcan
                                            @can('حذف-مهمة')
                                            <th>{{ trans('admin.delete') }}</th>
                                            @endcan
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{ $role->name }}</td>
                                                @can('قائمة-المهام')
                                                <td>

                                       
                                                    <button type="button" class="btn btn-outline-secondary btn-sm mx-1"  title="التفاصيل"
                                                        data-toggle="modal"
                                                        data-target="#show_modal_{{ $role->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                                @endcan
                                                @can('تعديل-مهمة')
                                                <td>
                                                    @if($role->name == 'سوبر-ادمن')
                                                    <i class="fas fa-lock text-muted"></i>
                                                    @else
                                                    <button type="button" class="btn btn-outline-info btn-sm mx-1" title="تعديل"
                                                        data-toggle="modal"
                                                        data-target="#edit_modal_{{$role->id}}">
                                                        <i class="far fa-edit"></i>
                                                    </button>
                                                    @endif
                                                    
                                                </td>
                                                 @endcan
                                                @can('حذف-مهمة') 
                                                <td>
                                                    @if($role->name == 'سوبر-ادمن')
                                                    <i class="fas fa-lock text-muted"></i>
                                                    @else
                                                    <button type="button" class="btn btn-outline-danger btn-sm mx-1"  title="حذف"
                                                        data-toggle="modal"
                                                        data-target="#delete_modal_{{$role->id}}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    @endif
                                                   
                                                </td>
                                                 @endcan

                                                @include('inc.roles.show_role')
                                                @include('inc.roles.edit_role')
                                                @include('inc.roles.delete_role')
                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>
                                @else
                                    <p class="h4 text-muted text-center">{{trans('admin.not_found')}} </p>
                                @endif


                                <div class="d-flex justify-content-center my-4">
                                    {{$roles->links()}}
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @include('inc.roles.create_role')
        </section>
    </div>
@endsection


