@extends('admin.layouts.layout')

@push('css')
 <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@section('title')
    إضافة شهر مالي
@endsection

@section('content')
    <div class="content-wrapper" style="min-height: 1345.6px;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">الرئيسية</a></li>
                            <li class="breadcrumb-item active">إضافة شهر مالي </li>
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
                            <h3 class="card-title">إضافة شهر مالي </h3>
                            </div>
                            <div class="bg-danger-outline">
                            @include('inc.errors')
                            </div>

                            <div class="card-body">
                                <form action="{{route('admin.financial_months.store')}}" method="post">
                                    @csrf

                                    <div class="row mt-4">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for='month_name'>إسم الشهر</label><span class="text-danger">*</span>
                                                <input type='text' name='month_name' value="{{ old('month_name') }}" class= 'form-control mt-1 mb-3 @error('month_name') is-invalid @enderror' placeholder = "إسم الشهر ">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for='year'>السنة</label>
                                                <input type='number' name='year' value="{{ old('year') }}" class= 'form-control mt-1 mb-3 @error('year') is-invalid @enderror' placeholder = "السنة" >
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for='month_id'>رقم الشهر</label>
                                                <select  name='month_id' value="{{ old('month_id') }}" class= 'form-control mt-1 mb-3 @error('month_id') is-invalid @enderror' placeholder = " رقم الشهر">
                                                    <option value="">--إختر رقم الشهر--</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for='financial_year_id'>السنة المالية</label><span class="text-danger">*</span>
                                                <select name='financial_year_id'  class= 'form-control mt-1 mb-3 @error('financial_year_id') is-invalid @enderror'>
                                                    <option value="">--إختر السنة المالية--</option>
                                                    @foreach (App\Models\FinancialYear::all() as $year)
                                                         <option value="{{$year->id}}" >{{$year->year}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for='no_of_days'>عدد أيام الشهر</label>
                                                <select name='no_of_days'value="{{ old('no_of_days') }}" class= 'form-control mt-1 mb-3 @error('no_of_days') is-invalid @enderror' placeholder = "عدد أيام الشهر ">
                                                    <option value="">--إختر عدد أيام الشهر--</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>


                                     <div class="row mt-4">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for='start_date'> تاريخ بداية الشهر المالي</label><span class="text-danger">*</span>
                                                <input type="text" class="form-control datepicker-input  mt-1 mb-3 @error('start_date') is-invalid @enderror"
                                                data-target="#start_date" id="start_date"
                                                name='start_date' value="{{ old('start_date') }}" placeholder = "تاريخ  بداية الشهر    ">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for='end_date'> تاريخ نهاية الشهر المالي</label><span class="text-danger">*</span>
                                                <input type="text" class="form-control datepicker-input  mt-1 mb-3 @error('end_date') is-invalid @enderror"
                                                data-target="#end_date" id="end_date"
                                                name='end_date' value="{{ old('end_date') }}" placeholder = "تاريخ نهاية الشهر    ">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for='signature_start_date'> تاريخ بداية البصمة للشهر</label><span class="text-danger">*</span>
                                                <input type="text" class="form-control datepicker-input  mt-1 mb-3 @error('signature_start_date') is-invalid @enderror"
                                                data-target="#signature_start_date" id="signature_start_date"
                                                name='signature_start_date' value="{{ old('signature_start_date') }}" placeholder = "تاريخ بداية البصمة">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for='signature_end_date'> تاريخ نهاية البصمة للشهر</label><span class="text-danger">*</span>
                                                <input type="text" class="form-control datepicker-input  mt-1 mb-3 @error('signature_end_date') is-invalid @enderror"
                                                data-target="#signature_end_date" id="signature_end_date"
                                                name='signature_end_date' value="{{ old('signature_end_date') }}" placeholder = "تاريخ نهاية البصمة">
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

