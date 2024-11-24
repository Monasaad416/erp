@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> ميزان المراجعة الموحد لكل الفروع</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">ميزان المراجعة الموحد لكل الفروع</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <livewire:uni-trail-balances-before.display-uni-trail-balances-before :filter="$filter ?? ''" :key="$filter?? ''" />
            </div>
        </section>

        <livewire:uni-trail-balances-before.add-uni-trail-balance-before>
        {{-- <livewire:uni-trail-balances-before.update-uni-trail-balance-before>
        <livewire:uni-trail-balances-before.delete-uni-trail-balance-before> --}}
    </div>
@endsection
