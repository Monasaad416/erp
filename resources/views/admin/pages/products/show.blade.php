@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">
        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> {{trans('admin.show_product')}}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('products')}}">{{trans('admin.products')}}</a></li>
            <li class="breadcrumb-item active">{{trans('admin.show_product')}}</li>
            </ol>
            </div>
            </div>
            </div>
        </section>
        @php
            $product = App\Models\Product::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','description','category_id','supplier_id','serial_num',
            'unit_id','is_active','size','max_dose','manufactured_date','expiry_date'
            ,'import_date','sale_price','discount_price','fraction','taxes','serial_num','gtin')->where('id',$id)->first();
        @endphp

        <section class="content">
            <div class="container-fluid">
                <livewire:products.show-product :product="$product"/>
            </div>
        </section>
    </div>
@endsection
