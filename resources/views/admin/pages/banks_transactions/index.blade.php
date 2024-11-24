@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">
        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> حركات البنوك</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">حركات البنوك </li>
            </ol>
            </div>
            </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <livewire:bank-transactions.display-transactions />
            </div>
        </section>
        <livewire:bank-transactions.update-transaction />
        <livewire:bank-transactions.delete-transaction />
    </div>
@endsection
