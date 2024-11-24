<div>
    {{-- <div>
        <input type="text">
    </div> --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>المخزن</th>
                <th>ملاحظات</th>
                <th>الكمية الموردة</th>
                <th>الكمية المنصرفة</th>
                <th>تاريخ وتوقيت الحركة</th>
                <th>رصيد المخزن الحالي </th>
                <th>تكلفة الوحدة</th>
                {{-- <th>اجمالي التكلفة</th> --}}
            </tr>
        </thead>
        <tbody>
            @php
                $inventories = App\Models\Inventory::where('product_id',$product->id)->latest()->get();
            @endphp
            @if($inventories->count() > 0 )
            @foreach ($inventories as $inventory)

                 
                <tr>
                    <td style="width:2%">{{$loop->iteration}}</td>
                    <td>{{ $inventory->store->name }}</td>
                    <td>{{ $inventory->notes }}</td>
                    <td>{{ $inventory->in_qty }}</td>
                    <td>{{ $inventory->out_qty }}</td>
                    <td>{{ Carbon\Carbon::parse($inventory->created_at)->format('Y-m-d') }} 
                        <br/>
                        {{ Carbon\Carbon::parse($inventory->created_at)->format('H:i:s') }}
                    </td>
                    <td>{{ $inventory->inventory_balance }}</td>
                    <td>{{ $product->sale_price }}</td>
                    {{-- <td>{{ $inventory->total_price }}</td> --}}
                    {{-- <td>{{ $inventory->trans_inv_date_time->format('Y-m-d') }}<br>{{ $inventory->trans_inv_date_time->format('H:i:s') }}</td> --}}
                    {{-- <td>{{ $user->updated_by ? $user->updated_by->name  : '---'}}</td> --}}
                </tr>

                {{-- <livewire:inventoryoices.update-product :product="$inventory" /> --}}
            @endforeach
            @else
            <p>لايوجد تحويلات بين المخازن لهذا المنتج</p>
            @endif
        </tbody>
    </table>
</div>