<div>
    @push('css')
        <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

        @php
            $branches = App\Models\Branch::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('is_active',1)->get();
        @endphp

    @endpush

            <div class="row">
                <div class="col-12">
                    <div class="row" style="background-color: #f5f6f9; padding:30px ;border-radius:5px ">


                        <div class="col-12 mb-2">
                            <h3 class="text-muted">معلومات الجرد</h3>
                        </div>
                        @if(Auth::user()->roles_name == 'سوبر-ادمن')
                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label for='branch_id'>الفرع</label>

                                    <select wire:model='branch_id'  wire:change='branchIdChanged' style="height: 45px;" class='form-control pb-3 @error('branch_id') is-invalid @enderror'>
                                        <option value="">إختر الفرع</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                @include('inc.livewire_errors',['property'=>'branch_id'])
                            </div>
                        @endif
                        <div class="col-3 mb-2">
                            <div class="form-group">
                                <label for="from_date">من تاريخ:</label><span class="text-danger">*</span>
                                <input type="date" wire:model.defer="from_date" class="form-control @error('from_date') is-invalid @enderror" placeholder="من تاريخ:">
                                @include('inc.livewire_errors', ['property' => 'from_date'])
                            </div>
                        </div>
                        <div class="col-3 mb-2">
                            <div class="form-group">
                                <label for="to_date">إلي تاريخ:</label><span class="text-danger">*</span>
                                <input type="date" wire:model.live="to_date" class="form-control @error('to_date') is-invalid @enderror" placeholder="إلي تاريخ:">
                                @include('inc.livewire_errors', ['property' => 'to_date'])
                            </div>
                        </div>
                        <div class="col-3">
                                <label for="selectedProducts">الاصناف</label><span class="text-danger">*</span>
                                <select wire:model="selectedProducts"   wire:change="branchInvCount" class="form-control  @error('selectedProducts') is-invalid @enderror">
                                    <option>إختر الاصناف للجرد</option>
                                    <option value="الكل">الكل</option>
                                    <option value="محددة">محددة</option>
                                </select>
                            {{-- <button type="button" class="btn btn-primary" wire:click="branchInvCount">إضافة بنود الجرد</button> --}}
                        </div>


                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <h3 class="text-muted">بنود الجرد</h3>
                        </div>

                        <style>
                            .table thead tr th{
                                text-align:center;
                                font-size: 12px;
                            }
                        </style>
                           <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                            <script>
                            console.log("dispatched");
                             window.addEventListener('newRowAdded', event => {
                                //console.log("dispatched");
                                $(document).ready(function () {
                                        $('.select2bs4').select2();

                                        $(document).on('change', '.select2bs4', function (e) {
                                            var rowIndex = $(this).data('row-index');
                                            var selectedProductId = $(this).val();
                                            console.log(rowIndex);
                                            if (selectedProductId) {
                                                @this.call('fetchByName', rowIndex , selectedProductId);
                                            }
                                        });
                                });
                            });
                        </script>


                        @if ($selectedProducts == 'الكل')
                             @livewire('inventory-counts.count-all-products', ['branch_id' => $branch_id,'from_date' => $from_date,'to_date' => $to_date])
                        @elseif ($selectedProducts == 'محددة')
                            @livewire('inventory-counts.count-selected-products', ['branch_id' => $branch_id,'from_date' => $from_date,'to_date' => $to_date ,'rows' =>$rows])
                        @endif



                    </div>
                </div>


            </div>



</div>

