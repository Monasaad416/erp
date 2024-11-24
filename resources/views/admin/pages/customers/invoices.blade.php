@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> {{trans('admin.customers_invoices')}}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">{{trans('admin.customers_invoices')}}</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <livewire:customer-invoices.display-invoices :filter="$filter ?? ''" :key="$filter?? ''" />
                <livewire:customer-invoices.delete-invoice  />
               {{--  <livewire:customer-invoices.approve-invoice  />
                <livewire:customer-invoices-returns.return-invoice  /> --}}
                <livewire:customer-invoices-returns.return-invoice  />
            </div>
        </section>

    </div>
@endsection
