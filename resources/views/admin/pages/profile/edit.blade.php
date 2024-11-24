@extends('admin.layouts.layout')

@push('css')

@endpush

@section('title')
تعديل الملف الشخصي
@endsection

@section('content')


<div class="content-wrapper" style="min-height: 1345.6px;">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h2></h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('index')}}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">تعديل الملف الشخصي</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row my-auto">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                        <h3 class="card-title">تعديل الملف الشخصي</h3>
                        </div>
                        <div class="bg-danger-outline">
                        @include('inc.errors')
                        </div>

                        <div class="card-body">
                            <form action="{{route('user.update_profile')}}" method="post">
                                @csrf

                                <div class="row mt-3">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for='name'>الإسم</label><span class="text-danger">*</span>
                                            <input type='text' name='name' value="{{ old('name',$user->name) }}"  class= 'form-control mt-1 mb-3 @error('name') is-invalid @enderror' placeholder = "الإسم">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for='email'>البريد الإلكتروني</label><span class="text-danger">*</span>
                                            <input type='email' name='email' value="{{ old('email',$user->email) }}"  class= 'form-control mt-1 mb-3 @error('email') is-invalid @enderror' placeholder = "البريد الإلكتروني">
                                        </div>
                                    </div>

                                </div>

                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <div class="col-xs-12 col-sm-12 col-md-12 my-4 text-center">
                                    <button type="submit" class="btn btn-secondary">تعديل</button>
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

