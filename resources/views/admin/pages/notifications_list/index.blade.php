@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1>قائمة الإشعارات</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">الرئيسية</a></li>
            <li class="breadcrumb-item active">الإشعارات </li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
               <div class="row">
                    <div class="col">
                        <div class="card">
                            {{-- <div class="card-header">

                            </div> --}}
                            <style>
                                tr , .table thead th  {
                                    text-align: center;
                                }
                            </style>
                            <div class="card-body">
                                @if($notifications->count() > 0)

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                            <th style="width: 10px">#</th>
                                            <th>التوقيت</th>
                                            <th>العنوان</th>
                                            <th>الإشعار</th>
                                            <th>البنود</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    @foreach ($notifications as $notification)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ $notification->created_at->diffForHumans() }}</td>
                                            <td>{{ $notification->data['title'] }}</td>
                                            <td>{{ $notification->data['body'] }}</td>
                                            <td><a href="{{ url($notification->data['action']) }}" class="text-success"><i class="fas fa-file-invoice"></i> </a></td>

                                    @endforeach

                                        </tbody>
                                    </table>
                                @else
                                    <p class="h4 text-muted text-center">لا يوجد إشعارات للعرض</p>
                                @endif


                                <div class="d-flex justify-content-center my-4">
                                    {{$notifications->links()}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>

    </div>
@endsection
