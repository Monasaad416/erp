
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="w-25">{{ trans('admin.product_codes') }}</th>
                            <th>{{trans('admin.print_product_code')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->productCodes as $code)
                            <tr>
                                <td class="w-25">{{ $code->code }}</td>
                     
      
                            <td>
                          <a target="_blank" href="{{ route('product.print_code',['id'=>$code->product_id ,'code' => $code->code ]) }}">
                            <button type="button" class="btn btn-outline-secondary btn-sm mx-1" title="{{trans('admin.print_code')}}">
                                <i class="fas fa-print"></i>
                            </button>
                          </a>
                            </div>

   
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>

