@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> دفتر الاستاذ العام</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('financial_accounts')}}">قائمة الحسابات المالية</a></li>
            <li class="breadcrumb-item active">دفتر الاستاذ العام</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        @php 
            $account = App\Models\Account::where('id',$account_id)->first();
        @endphp
        <section class="content">
            <div class="container-fluid">
              <livewire:ledgers.show-ledger :account="$account">
            </div>
        </section>

    </div>
@endsection
