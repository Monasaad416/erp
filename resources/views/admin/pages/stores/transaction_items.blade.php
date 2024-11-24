@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> بنود التحويل  </h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('stores.transactions')}}">تحويلات المخازن</a></li>
            <li class="breadcrumb-item active">بنود التحويل </li>
            </ol>
            </div>
            </div>
            </div>
        </section>
        @php
            $transaction = App\Models\InventoryTransaction::where('trans_num' , $trans_num)->first();
        @endphp

        <section class="content">
            <div class="container-fluid">
                <livewire:stores-transactions.transaction-items :transaction="$transaction"/>
            </div>
        </section>



    </div>
@endsection
