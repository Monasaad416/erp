@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> المخازن</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">المخازن</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <livewire:stores.display-stores :filter="$filter ?? ''" :key="$filter?? ''" />
            </div>
        </section>

        <livewire:stores.add-store>
        <livewire:stores.update-store>
        <livewire:stores.delete-store>
        <livewire:stores.toggle-store>
    </div>
@endsection
