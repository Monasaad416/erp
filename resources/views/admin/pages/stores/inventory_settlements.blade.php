@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1>  تسوية المخزون</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">جرد المخزون</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <livewire:inventory-settlements.display-inventory-settlements :filter="$filter ?? ''" :key="$filter?? ''" />
            </div>
        </section>

        <livewire:inventory-settlements.add-inventory-settlements />
        <livewire:inventory-settlements.update-inventory-settlements />
        <livewire:inventory-settlements.delete-inventory-settlements />

    </div>
@endsection
