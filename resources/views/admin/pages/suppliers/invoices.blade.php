@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> {{trans('admin.suppliers_invoices')}}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">{{trans('admin.suppliers_invoices')}}</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <livewire:supplier-invoices.display-invoices :filter="$filter ?? ''" :key="$filter?? ''" />
                <livewire:supplier-invoices.delete-invoice  />
                <livewire:supplier-invoices.approve-invoice  />
                <livewire:supplier-invoices-returns.return-invoice  />
            </div>
        </section>

    </div>
@endsection
