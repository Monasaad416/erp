@extends('admin.layouts.layout')

@push('css')

@endpush

@section('title')
    الشهور المالية
@endsection

@section('content')
    <div class="content-wrapper" style="min-height: 1345.6px;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض الشهور المالية</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row my-auto">
                    <div class="col-12">
                        <livewire:financial-months.display-months/>
                        <livewire:financial-months.add-month/>
                        <livewire:financial-months.update-month/>
                        <livewire:financial-months.delete-month/>
                        <livewire:financial-months.toggle-month/>
                    </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

@push('script')

@endpush

