@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> {{trans('admin.account-statements')}}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">{{trans('admin.account-statements')}}</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <livewire:account-statements.display-account-statements :filter="$filter ?? ''" :key="$filter?? ''" />
            </div>
        </section>

        <livewire:account-statement.add-account-statement>
        <livewire:account-statement.update-account-statement>
        <livewire:account-statement.delete-account-statement>
    </div>
@endsection
