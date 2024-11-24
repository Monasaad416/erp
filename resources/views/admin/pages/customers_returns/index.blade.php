@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1>مردودات العملاء -إشعارات دائن</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('customers.invoices')}}"> فواتير العملاء </a></li>
            <li class="breadcrumb-item active">مردودات فواتير العملاء </li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <livewire:customer-invoices-returns.display-returns  />
            </div>
        </section>
    </div>
@endsection
