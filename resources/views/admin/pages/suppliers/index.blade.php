@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> {{trans('admin.suppliers')}}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">{{trans('admin.suppliers')}}</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <livewire:suppliers.display-suppliers :filter="$filter ?? ''" :key="$filter?? ''" />
            </div>
        </section>

        <livewire:suppliers.add-supplier>
        <livewire:suppliers.update-supplier>
        <livewire:suppliers.delete-supplier>
        {{-- <livewire:suppliers.toggle-supplier> --}}
    </div>
@endsection
