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
            <li class="breadcrumb-item"><a href="{{ route('suppliers.invoices') }}">{{trans('admin.suppliers_invoices')}}</a></li>
            <li class="breadcrumb-item active">{{trans('admin.edit_supplier_invoice')}}</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            @php
         
                $InvNum_with_prefix = $inv_num;
                $InvNum_without_prefix =  str_replace("S-", "", $InvNum_with_prefix);
   //dd($InvNum_without_prefix);
                $invoice = App\Models\SupplierInvoice::where('supp_inv_num',$InvNum_without_prefix)->first();
                //dd($invoice);
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
                                <livewire:supplier-invoices.update-invoice :invoice="$invoice"/>
                                <livewire:supplier-invoices.update-invoice-item :invoice="$invoice"/>
                                <livewire:supplier-invoices.delete-invoice-item :invoice="$invoice"/>
                                <livewire:supplier-invoices-returns.return-item :invoice="$invoice"/>
                                <livewire:supplier-invoices-returns.return-item-partially :invoice="$invoice"/>
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
