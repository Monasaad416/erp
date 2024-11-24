@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">
        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> إعدادات رأس المال</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">إعدادات رأس المال</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        @php
                            $locale = Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale();
                        @endphp
       
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-two-tab">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is($locale.'/settings/edit') ? 'active' : '' }}" id="{{ route('settings.edit') }}-tab"  href="{{ route('settings.edit') }}">إعدادات الموقع</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is($locale.'/zatca/settings/edit') ? 'active' : '' }}" id="{{ route('zatca_settings.edit') }}-tab"  href="{{ route('zatca_settings.edit') }}">إعدادات الزكاة والضريبة </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is($locale.'/capital/settings/edit') ? 'active' : '' }}" id="{{ route('capital_settings.edit') }}-tab"  href="{{ route('capital_settings.edit') }}">إعدادات رأس المال</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-two-tabContent">
                                <div class="tab-pane fade {{ request()->is($locale.'/settings/edit') ? 'show active' : '' }}" id="{{ route('settings.edit') }}" >
                                    <livewire:settings.update-settings />
                                </div>
                                <div class="tab-pane fade {{ request()->is($locale.'/zatca/settings/edit') ? 'show active' : '' }}" id="{{ route('zatca_settings.edit') }}">
                                    <livewire:zatca-setting.create-integration-keys />
                                </div>
                                <div class="tab-pane fade {{ request()->is($locale.'/capital/settings/edit') ? 'show active' : '' }}" id="{{ route('capital_settings.edit') }}">
                                    <livewire:capital-settings.update-settings />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
