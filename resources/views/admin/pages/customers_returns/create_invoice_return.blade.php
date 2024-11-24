@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                   <h3>إضافة إشعار <span class="text-danger">دائن</span></h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('customers.returns') }}">مردودات العملاء</a></li>
            <li class="breadcrumb-item active">إضافة مردود </li>
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
                            <div class="card-body">
                            <livewire:customer-invoices-returns.add-customer-return :inv_num="$inv_num ?? null" />
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
