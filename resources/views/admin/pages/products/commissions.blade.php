@extends('admin.layouts.layout')
@push('css')
    <style>
        @media print {
            /* body {
            -webkit-print-color-adjust: exact !important;
              -webkit-print-color-adjust:exact !important;
            -webkit-print-color-adjust:exact !important;
            } */
            #print_button {
                display: none;
            }
        }
        .table thead th  {
            text-align: center;
        }
    </style>
    <style media="print" type="text/css">
        .inv_total td {
            background-color: gray !important;
        }
    </style>
@endpush
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> منتجات العمولة</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('products')}}">{{trans('admin.products')}}</a></li>
            <li class="breadcrumb-item active">منتجات العمولة</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <livewire:commissions.display-commissions  />
            </div>
        </section>

        <livewire:commissions.add-commission/>

        <livewire:commissions.delete-commission/>

        <livewire:commissions.update-commission/>
    </div>
@endsection




