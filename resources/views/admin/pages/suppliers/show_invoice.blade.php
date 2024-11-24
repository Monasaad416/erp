@extends('admin.layouts.layout')
@section('content')
            @php
                $invoice = App\Models\SupplierInvoice::where('id',$id)->first();
            @endphp
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            {{-- <h1>قائمة فولاتير الجرد</h1> --}}
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('suppliers.invoices') }}">{{trans('admin.suppliers_invoices')}}</a></li>
            <li class="breadcrumb-item active">{{trans('admin.supplier_invoice_details')}} {!! "&nbsp;" !!}{{ $invoice->supp_inv_num }}</li>
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
                            {{-- <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title">قائمة فواتير الجرد</h4>
                                    <button type="button" class="btn bg-gradient-cyan" data-toggle="modal" data-target="#create_modal" style="border-radius: 50%" title="إضافة بند للفاتورة">
                                        <span style="font-weight: bolder; font-size:">+</span>
                                    </button>
                                </div>

                            </div> --}}

                            <div class="card-body">
                                <livewire:supplier-invoices.show-invoice :invoice="$invoice"/>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
