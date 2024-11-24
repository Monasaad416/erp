@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> {{trans('admin.deliver_users_shifts')}}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('index')}}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">{{trans('admin.deliver_users_shifts')}}</li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <livewire:treasury-shifts.display-treasury-shifts :filter="$filter ?? ''" :key="$filter?? ''" />
            </div>
        </section>

        <livewire:treasury-shifts.add-treasury-shift>
        <livewire:treasury-shifts.update-treasury-shift>
        <livewire:treasury-shifts.delete-treasury-shift>
        <livewire:treasury-shifts.approve-recieving-shift>

    </div>
@endsection

{{-- @push('scripts')
    <script>
        $(document).ready(function () {
            $('select[name="amount_state"]').on('change', function () {
                var amount_state = $(this).val();
                if (amount_state) {
                    $.ajax({
                        url: "{{ URL::to('/user-shifts/amount') }}/" + amount_state,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="city_id"]').empty();
                            $.each(data, function (key, value) {
                                $('select[name="city_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
    </script>
@endpush --}}

