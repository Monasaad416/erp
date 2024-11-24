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
            <h1> العروض</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">العروض</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <livewire:offers.display-offers :filter="$filter ?? ''" :key="$filter?? ''" />
            </div>
        </section>

        <livewire:offers.add-offer/>

        <livewire:offers.delete-offer/>
        <livewire:offers.toggle-offer/>
        <livewire:offers.update-offer/>
    </div>
@endsection




