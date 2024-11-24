@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> تقرير نواقص المخزون </h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">تقرير نواقص المخزون </li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <livewire:shortcomings.display-shortcomings :filter="$filter ?? ''" :key="$filter?? ''" />
            </div>
        </section>

        <livewire:shortcomings.add-shortcoming>
        <livewire:shortcomings.update-shortcoming>
        <livewire:shortcomings.delete-shortcoming>

    </div>
@endsection
