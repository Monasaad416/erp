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
            <li class="breadcrumb-item"><a href="{{ route('customers.invoices') }}">فواتير العملاء</a></li>
            <li class="breadcrumb-item active">سداد فاتورة أجلة</li>
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

                            @php
                                $InvNum_with_prefix = $inv_num;
                                $InvNum_without_prefix =  str_replace("C-", "", $InvNum_with_prefix);
                                $invoice = App\Models\CustomerInvoice::where('customer_inv_num',$InvNum_without_prefix)->first();
                            @endphp

                            <div class="card-body">
                                <livewire:customer-invoices.pay-invoice :invoice="$invoice"/>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
