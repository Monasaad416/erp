@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> ميزان المراجعة بعد القوائم المالية</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">ميزان المراجعة بعد القوائم المالية</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <livewire:trail-balances-after.display-trail-balances-after :filter="$filter ?? ''" :key="$filter?? ''" />
            </div>
        </section>

        <livewire:trail-balances-after.add-trail-balance-after>
        <livewire:trail-balances-after.update-trail-balance-after>
        <livewire:trail-balances-after.delete-trail-balance-after>
    </div>
@endsection
