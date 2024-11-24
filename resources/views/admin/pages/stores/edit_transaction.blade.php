@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> تعديل التحويل </h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">تعديل التحويل </li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        @php
            $transaction = App\Models\InventoryTransaction::where('trans_num', $trans_num)->first();
        @endphp

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="card">
       

                            <div class="card-body">
                                <livewire:stores-transactions.update-store-transaction :transaction="$transaction" />
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



    </div>
@endsection
