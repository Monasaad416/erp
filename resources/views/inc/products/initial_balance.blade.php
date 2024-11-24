<table class="table table-bordered">
    <thead>
        <tr>
            <th style="width: 10px">#</th>
            <th>{{ trans('admin.initial_balance') }}</th>
            <th>{{ trans('admin.current_financial_year') }}</th>
            <th>{{ trans('admin.updated_by') }}</th>
        </tr>
    </thead>
    <tbody>
        @php
            $inventories = App\Models\Inventory::where('product_id', $product->id)
            ->orderBy('current_financial_year', 'ASC')
            ->get()
            ->groupBy(function ($inventory) {
                return $inventory->current_financial_year;
            })
            ->map(function ($group) {
                return $group->first();
            });
        @endphp
        @foreach ($inventories as $inventory)
            <tr>
                <td style="width:2%">{{$loop->iteration}}</td>
                <td>{{ $inventory->initial_balance }}</td>
                <td>{{ $inventory->current_financial_year }}</td>
                <td>{{ App\Models\User::where('id',$inventory->updated_by)->first() ? App\Models\User::where('id',$inventory->updated_by)->first()->name : '----' }}</td>
            </tr>

            {{-- <livewire:inventoryoices.update-product :product="$inventory" /> --}}
        @endforeach
    </tbody>
</table>
