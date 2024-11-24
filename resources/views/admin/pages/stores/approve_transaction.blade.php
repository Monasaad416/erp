@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">
        @php
            $transaction = App\Models\InventoryTransaction::where('trans_num', $trans_num)->first();
        @endphp
        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h5> قبول بنود التحويل رقم   {{ $transaction->trans_num }} من   {{ $transaction->fromStore->name}}</h5>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('stores.transactions')}}">تحويلات المخازن</a></li>
            <li class="breadcrumb-item active">قبول التحويل </li>
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
                                <livewire:stores-transactions.approve-store-transaction :transaction="$transaction" />
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>



    </div>
@endsection
