@extends('admin.layouts.layout')

@push('css')

@endpush

@section('title')
    السنوات المالية
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
                            <li class="breadcrumb-item active">عرض السنوات المالية</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row my-auto">
                    <livewire:financial-years.display-years/>
                    <livewire:financial-years.add-year/>
                    <livewire:financial-years.update-year/>
                    <livewire:financial-years.delete-year/>
                    {{-- <livewire:financial-years.toggle-year/> --}}
                    </div>
                </div>
        </section>
    </div>
@endsection

@push('script')

@endpush

