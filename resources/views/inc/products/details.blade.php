
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="w-25">{{ trans('admin.item') }}</th>
                            <th class="w-75">{{ trans('admin.details') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="w-25">{{ trans('admin.name') }}</td>
                            <td class="w-75">{{ $product->name }}</td>
                        </tr>

                        {{-- <tr>
                            <td class="w-25">{{ trans('admin.product_code') }}</td>
                            <td class="w-75">{{ $product->product_code }}</td>
                        </tr> --}}
                        <tr>
                            <td class="w-25">{{ trans('admin.description') }}</td>
                            <td class="w-75">{{ $product->description ? $product->description : '---' }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">{{ trans('admin.serial_num') }}</td>
                            <td class="w-75">{{ $product->serial_num  }}</td>
                        </tr>

                              <tr>
                            <td class="w-25">{{ trans('admin.unit') }}</td>
                            <td class="w-75">{{ $product->unit->name  }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">{{ trans('admin.category') }}</td>
                            <td class="w-75">{{ $product->category->name  }}</td>
                        </tr>

                       <tr>
                            <td class="w-25">{{ trans('admin.size') }}</td>
                            <td class="w-75">{{ $product->size }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">{{ trans('admin.max_dose') }}</td>
                            <td class="w-75">{{ $product->max_dose }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">{{ trans('admin.manufactured_date') }}</td>
                            <td class="w-75">{{ $product->manufactured_date }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">{{ trans('admin.expiry_date') }}</td>
                            <td class="w-75">{{ $product->expiry_date }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">{{ trans('admin.import_date') }}</td>
                            <td class="w-75">{{ $product->import_date }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('admin.purchase_price') }}</td>
                            <td class="w-75">{{ $product->purchase_price }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('admin.sale_price') }}</td>
                            <td class="w-75">{{ $product->sale_price }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">{{ trans('admin.discount_price') }}</td>
                            <td class="w-75">{{ $product->discount_price }}</td>
                        </tr>

                        <tr>
                            <td class="w-25">{{ trans('admin.status') }}</td>
                            <td class="w-75 text-{{ $product->is_active == 1 ? 'success' : 'danger' }}">{{ $product->is_active == 1 ? trans('admin.active') :  trans('admin.inactive') }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">{{ trans('admin.fraction_available') }}</td>
                            <td class="w-75 text-{{ $product->fraction == 1 ? 'success' : 'danger' }}" >{{ $product->fraction == 1 ? trans('admin.yes') :  trans('admin.no') }}</td>
                        </tr>
                                   <tr>
                            <td class="w-25">{{ trans('admin.taxable') }}</td>
                            <td class="w-75 text-{{ $product->taxes == 1 ? 'success' : 'danger' }}"> {{ $product->taxes == 1 ? trans('admin.yes') :  trans('admin.no') }}</td>
                        </tr>
                    </tbody>
                </table>

