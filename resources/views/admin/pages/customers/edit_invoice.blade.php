@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            {{-- <h1>قائمة فولاتير الجرد</h1> --}}
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">{{$type=="debit"?'إضافة إشعار دائن':'إضافة إشعار مدين'}}</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            @php
                //   $invNumWithPrefix = $inv_num;
                //   $invNumWithoutPrefix =  str_replace("C-", "", $invNumWithPrefix);
                $invoice = App\Models\CustomerInvoice::where('customer_inv_num', $inv_num)->first();
                // dd($invoice);
            @endphp
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
                                <livewire:customer-invoices.update-invoice :invoice="$invoice" :type="$type"/>
                                <livewire:customer-invoices.update-invoice-item :invoice="$invoice"/>
                                <livewire:customer-invoices.delete-invoice-item :invoice="$invoice"/>
                                <livewire:customer-invoices-returns.return-item :invoice="$invoice"/>
                                <livewire:customer-invoices-returns.return-item-partially :invoice="$invoice"/>
                                <livewire:products.update-product/>
                                <livewire:products.print-code/>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
