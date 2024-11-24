@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> إضافة حركة صرف </h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('treasury.transactions')}}">حركات البنوك</a></li>
            <li class="breadcrumb-item active"> إضافة حركة صرف  </li>
            </ol>
            </div>
            </div>
            </div>
        </section>


        @php
            $previousUrl = url()->previous();
            $path = parse_url($previousUrl, PHP_URL_PATH);
            $segments = explode('/', $path);
            $desiredSegment = implode('/', array_slice($segments, 2,2));
            if ($desiredSegment == "suppliers/invoices") {
                // $invNumWithPrefix = $inv_num;
                // $invNumWithoutPrefix =  str_replace("S-", "", $invNumWithPrefix);

                $invoice = App\Models\SupplierInvoice::where('supp_inv_num',$inv_num)->first();
            }   
            // }elseif ($desiredSegment == "customers/invoices") {
            //     // $invNumWithPrefix = $inv_num;
            //     // $invNumWithoutPrefix =  str_replace("C-", "", $invNumWithPrefix);
            //     $invoice = App\Models\CustomerInvoice::where('customer_inv_num',$inv_num)->first();
            // } else {
            //     $invoice = null;
            // }
        @endphp

        <section class="content">
            <div class="container-fluid">
                <livewire:bank-transactions.add-exchange-transaction :invoice="$invoice ?? ''" :key="$invoice?? ''"  >

            </div>
        </section>


    </div>
@endsection
