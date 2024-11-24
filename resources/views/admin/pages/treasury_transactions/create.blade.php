@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> حركات نقدية الخزينة</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('treasury.transactions')}}">حركات نقدية الخزينة</a></li>
            <li class="breadcrumb-item active"> إضافة حركة  </li>
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
                $invoice = App\MOdels\SupplierInvoice::where('supp_inv_num',$inv_num)->first();
            }elseif ($desiredSegment == "customers/invoices") {
                $invoice = App\MOdels\CustomerInvoice::where('customer_inv_num',$inv_num)->first();
            }
        @endphp    

        <section class="content">
            <div class="container-fluid">
                @php
                    $segment = request()->segment(3);
                    $exchange = false;
                    $collection = false;
                    if($segment == 'exchange-receipts') {
                        $exchange = true;
                    }
                    if($segment == 'collection-receipts') {
                        $collection = true;
                    }

                @endphp
                @if($exchange == true)
                    <livewire:treasury-transactions.add-exchange :invoice="$invoice ?? ''" :key="$invoice ?? ''"  >
                @elseif($collection == true)   
                    <livewire:treasury-transactions.add-collection :invoice="$invoice ?? ''" :key="$invoice ?? ''"  >
                @endif
            </div>
        </section>


    </div>
@endsection
