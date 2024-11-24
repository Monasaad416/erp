@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> دفتر الاستاذ العام</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">دفتر الاستاذ العام</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <livewire:ledgers.display-ledgers :filter="$filter ?? ''" :key="$filter?? ''" />
            </div>
        </section>

        <livewire:ledgers.add-ledger>
        <livewire:ledgers.update-ledger>
        <livewire:ledgers.delete-ledger>
        <livewire:ledgers.show-ledger>
    </div>
@endsection
