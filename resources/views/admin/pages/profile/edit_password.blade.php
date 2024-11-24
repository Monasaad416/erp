@extends('admin.layouts.layout')

@push('css')

@endpush

@section('title')
تغيير كلمة السر
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
                        <li class="breadcrumb-item active">تغيير كلمة السر</li>
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
                        <h3 class="card-title">تغيير كلمة السر</h3>
                        </div>
                        <div class="bg-danger-outline">
                        @include('inc.errors')
                        </div>

                        <div class="card-body">
                            <form action="{{route('user.update_password')}}" method="post">
                                @csrf

                               <div class="row mt-3">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for='password'>كلمة السر</label><span class="text-danger">*</span>
                                            <input type='password' name='password' id="password" value="{{ old('password') }}"  class= 'form-control mt-1 mb-3 @error('password') is-invalid @enderror' placeholder = "كلمة السر">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for='password'>تأكيد كلمة السر</label><span class="text-danger">*</span>
                                            <input type='password' name='password_confirmation' value="{{ old('password_confirmation') }}"  class= 'form-control mt-1 mb-3 @error('password') is-invalid @enderror' placeholder = "تعديل كلمة السر">
                                        </div>
                                    </div>
                                </div>

                                            <div class="col-sm-9">
                   
                                                <input type="checkbox"  onclick="show_password()">
                                                <label class="form-check-label" for="exampleCheck1">إظهار كلمة السر؟</label>
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

@push('scripts')
    <script>
        function show_password()
        {
            let password = document.getElementById('password');
            if (password.type === "password"){
                password.type = "text";
                console.log(password.type )
            }else {
                password.type = "password";
            }
        }
    </script>
@endpush

