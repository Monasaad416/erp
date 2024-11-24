<div class="modal" id="statistics_modal" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    {{ trans('admin.statistics_product') }} {!! "&nbsp;" !!}
                    <span class="text-muted" class="text-muted">{{ $name }}</spn>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('admin.item') }}</th>
                            <th>{{ trans('admin.details') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ trans('admin.name') }}</td>
                            <td>{{ $name }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('admin.description') }}</td>
                            <td>{{ $description ? $description : '---' }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('admin.serial_num') }}</td>
                            <td>{{ $serial_num  }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('admin.unit') }}</td>
                            <td>{{ $unit  }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('admin.category') }}</td>
                            <td>{{ $category  }}</td>
                        </tr>

                       <tr>
                            <td>{{ trans('admin.size') }}</td>
                            <td>{{ $size }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('admin.max_dose') }}</td>
                            <td>{{ $max_dose }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('admin.manufactured_date') }}</td>
                            <td>{{ $manufactured_date }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('admin.expiry_date') }}</td>
                            <td>{{ $expiry_date }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('admin.import_date') }}</td>
                            <td>{{ $import_date }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('admin.purchase_price') }}</td>
                            <td>{{ $purchase_price }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('admin.sale_price') }}</td>
                            <td>{{ $sale_price }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('admin.discount_price') }}</td>
                            <td>{{ $discount_price }}</td>
                        </tr>
                                   <tr>
                            <td>{{ trans('admin.inventory_balance') }}</td>
                            <td>{{ $inventory_balance }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('admin.status') }}</td>
                            <td class="text-{{ $is_active == 1 ? 'success' : 'danger' }}">{{ $is_active == 1 ? trans('admin.active') :  trans('admin.inactive') }}</td>
                        </tr>
                        <tr>
                            <td >{{ trans('admin.fraction_available') }}</td>
                            <td class="text-{{ $fraction == 1 ? 'success' : 'danger' }}" >{{ $fraction == 1 ? trans('admin.yes') :  trans('admin.no') }}</td>
                        </tr>
                                   <tr>
                            <td>{{ trans('admin.taxable') }}</td>
                            <td class="text-{{ $taxes == 1 ? 'success' : 'danger' }}"> {{ $taxes == 1 ? trans('admin.yes') :  trans('admin.no') }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('admin.close')}}</button>
            </div>
        </div>
    </div>
</div>
