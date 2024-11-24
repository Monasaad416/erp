@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> ورديات السنة المالية الحالية</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">ورديات السنة المالية الحالية</li>
            </ol>
            </div>
            </div>
            </div>
        </section>
        @php
            $user = App\Models\User::where('id',$user_id)->first();
        @endphp

        <section class="content">
            <div class="container-fluid">
                 <livewire:shifts.add-current-year-shifts :user="$user"/>
            </div>
        </section>



    </div>
@endsection



