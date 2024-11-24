@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> ميزان المراجعة للفروع</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">ميزان المراجعة للفروع</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <livewire:trail-balances-before.display-trail-balances-before :filter="$filter ?? ''" :key="$filter?? ''" />
            </div>
        </section>

        <livewire:trail-balances-before.add-trail-balance-before>
        <livewire:trail-balances-before.update-trail-balance-before>
        <livewire:trail-balances-before.delete-trail-balance-before>
    </div>
@endsection
