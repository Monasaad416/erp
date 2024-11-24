<?php

namespace App\Livewire\Offers;

use Exception;
use App\Models\Offer;
use App\Models\Branch;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\BranchOffer;
use App\Models\ProductCode;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Offers\DisplayOffers;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddOffer extends Component
{
    public $branches_ids,$price,$percentage,$product_id,$from_date,$to_date,$description;


    public function mount()
    {
        $this->dispatch('newProduct');
    }

    public function hydrate()
{
    $this->dispatch('newProducts');
}



    public function rules() {
        return [
            'product_id' => "required|exists:products,id",
            'percentage' => 'required_without:price|nullable|numeric|min:0|max:100',
            'price' => 'required_without:percentage|nullable|numeric|min:0',
            'branches_ids' => "required",
            'branches_ids.*' => "exists:branches,id",
            'from_date' => "required|date",
            'to_date' => "required|date",
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'المنتج مطلوب',
            'product_id.exists' => 'المنتج الذي تم ادخالة غير موجود بقاعدة البيانات',

            'percentage.required_without' => 'النسبة المئوية مطلوبة في حالة عدم تحديد السعر',
            'percentage.numeric' => 'النسبة المئوية يجب أن تكون رقم',
            'percentage.min' => 'النسبة المئوية يجي الا تقل عن 0',
            'percentage.max' => 'النسبة المئوية مطليجي الا تزيد عن 100',

            'price.required_without' => ' سعر العرض مطلوب في حالة عدم تحديد النسبة المئوية',
            'price.numeric' => 'سعر العرض يجب ان يكون رقم',
            'price.min' => 'سعر العرض يجب الا يقل عن 0',
            'price.max' => 'سعر العرض يجب الا يزيد عن 100',

            'branches_ids.required' => 'مطلوب تحديد فرع واحد علي الاقل',
            'branches_ids.*.exists' => 'الفرع الذي تم ادخاله غير موجود بقاعدة البيانات',

            'from_date.required' => 'تاريخ بداية العرض مطلوب',
            'from_date.date' => 'ادخل صيغة صحيحة لتاريخ بداية العرض',

            'to_date.required' => 'تاريخ نهاية العرض مطلوب',
            'to_date.date' => 'ادخل صيغة صحيحة لتاريخ نهاية العرض',
        ];
    }

    public function create()
    {
        //dd($this->all());

        $this->validate($this->rules() ,$this->messages());
        // try {

            DB::beginTransaction();
            //return dd($this->all());
            $offer  = new Offer();
            $offer->product_id = $this->product_id;
            $offer->percentage = $this->percentage;
            $offer->description = $this->description;
            $offer->price = $this->price ? $this->price : Product::where('id',$this->product_id)->first()->sale_price * (1-$this->percentage/100);
            $offer->from_date = $this->from_date;
            $offer->to_date = $this->to_date;
            $offer->save();

            foreach ($this->branches_ids as $id){
                $branchOffer = new BranchOffer();
                $branchOffer->offer_id = $offer->id;
                $branchOffer->branch_id = $id;
                $branchOffer->save();
            }


            DB::commit();
            $this->reset(['branches_ids','percentage','description','price','product_id']);

            $this->dispatch('createModalToggle');

            $this->dispatch('refreshData')->to(DisplayOffers::class);

            $this->dispatch(
           'alert',
                text: 'تم إضافة العرض بنجاح',
                icon: 'success',
                confirmButtonText: trans('admin.done')
            );


        // } catch (Exception $e) {
        //     DB::rollBack();
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }



    }

    public function render()
    {
        return view('livewire.offers.add-offer');
    }
}
