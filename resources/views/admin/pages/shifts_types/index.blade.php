@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> {{trans('admin.shifts_types')}}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">{{trans('admin.shifts_types')}}</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <livewire:shifts-types.display-shifts-types :filter="$filter ?? ''" :key="$filter?? ''" />
            </div>
        </section>

        <livewire:shifts-types.add-shift-type>
        <livewire:shifts-types.update-shift-type>
        <livewire:shifts-types.delete-shift-type>
        <livewire:shifts-types.toggle-shift-type>
    </div>
@endsection
