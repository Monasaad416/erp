@extends('admin.layouts.layout')

@push('css')
 <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@section('title')
    إضافة سنة مالية
@endsection

@section('content')
    <div class="content-wrapper" style="min-height: 1345.6px;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">الرئيسية</a></li>
                            <li class="breadcrumb-item active">إضافة سنة مالية</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row my-auto">
                    <div class="col-12">
                        <div class="card card-info">
                            <div class="card-header">
                            <h3 class="card-title">إضافة سنة مالية</h3>
                            </div>
                            <div class="bg-danger-outline">
                            @include('inc.errors')
                            </div>

                            <div class="card-body">
                                <form action="{{route('admin.financial_years.store')}}" method="post">
                                    @csrf
                                    <div class="row mt-4">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for='year'>السنة المالية </label><span class="text-danger">*</span>
                                                <input type='text' name='year' value="{{ old('year') }}" class= 'form-control mt-1 mb-3 @error('year') is-invalid @enderror' placeholder = "السنة المالية">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for='year_desc'>الوصف</label>
                                                <input type='text' name='year_desc'value="{{ old('year_desc') }}" class= 'form-control mt-1 mb-3 @error('year_desc') is-invalid @enderror' placeholder = "وصف السنة المالية">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for='start_date'> تاريخ البداية</label><span class="text-danger">*</span>
                                                <input type="text" class="form-control datepicker-input  mt-1 mb-3 @error('start_date') is-invalid @enderror"
                                                data-target="#start_date" id="start_date"
                                                name='start_date' value="{{ old('start_date') }}" placeholder = "تاريخ بداية السنة المالية">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for='end_date'> تاريخ البداية</label><span class="text-danger">*</span>
                                                <input type="text" class="form-control datepicker-input  mt-1 mb-3 @error('end_date') is-invalid @enderror"
                                                data-target="#end_date" id="end_date"
                                                name='end_date' value="{{ old('end_date') }}" placeholder = "تاريخ بداية السنة المالية">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for='code'>كود الشركة</label><span class="text-danger">*</span>
                                                <input type='number' min="0" name='code' value="{{ auth()->user()->code }}" readonly class= 'form-control mt-1 mb-3 @error('code') is-invalid @enderror' placeholder = "تمت الاضافة بواسطة">
                                            </div>
                                        </div>

                                    <div class="col-6" style="margin-top: 30px">
                                        <div class="checkbox col">
                                             <label>
                                                 <input type="checkbox" name="is_opened" checked data-toggle="toggle" class="btn-outline-secondary mx-4" data-onstyle="success" data-offstyle="danger" data-on="حالية" data-off="مغلقة" data-onstyle="success" data-offstyle="danger">
                                            </label>
                                        </div>
                                    </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-12 col-md-12 my-4 text-center">
                                        <button type="submit" class="btn btn-info">حفظ</button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                    </div>
                </div>

        </section>
    </div>
@endsection

@push('script')

@endpush

