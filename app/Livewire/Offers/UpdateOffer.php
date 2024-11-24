<?php

namespace App\Livewire\Offers;

use Throwable;
use App\Models\Offer;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\OfferCode;
use App\Models\BranchOffer;
use App\Models\InvoiceOffer;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\SupplierInvoiceItem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Suppliers\DisplaySuppliers;
use App\Livewire\SupplierInvoices\AddInvoice;
use App\Livewire\SupplierInvoices\ShowInvoice;
use App\Livewire\SupplierInvoices\UpdateInvoice;
use App\Livewire\SupplierInvoices\AddInvoiceItems;
use App\Livewire\SupplierInvoices\DisplayInvoices;

class UpdateOffer extends Component
{
    protected $listeners = ['updateOffer'];

    public $offer,$offer_id,$product_id,$branches_ids,$price,$percentage,$from_date,$to_date,$description;



    public function updateOffer($id)
    {

        $this->offer = Offer::findOrFail($id);
        $this->offer_id = $this->offer->id;
        $this->product_id = $this->offer->product_id;
        $this->price = $this->offer->price;
        $this->description = $this->offer->description;
        $this->percentage = $this->offer->percentage;
        $this->from_date = $this->offer->from_date;
        $this->to_date = $this->offer->to_date;

        $this->branches_ids = BranchOffer::where('offer_id', $this->offer->id)->pluck('branch_id')->toArray() ?? [];
 


        $this->dispatch('editModalToggle');
    }


    public function rules() {
        return [
            'product_id' => "nullable|exists:products,id",
            'percentage' => 'required_without:price|nullable|numeric|min:0|max:100',
            'price' => 'required_without:percentage|nullable|numeric|min:0',
            'branches_ids' => "nullable",
            'branches_ids.*' => "exists:branches,id",
            'from_date' => "nullable|date",
            'to_date' => "nullable|date",
        ];
    }

    public function messages()
    {
        return [
            'product_id.nullable' => 'المنتج مطلوب',
            'product_id.exists' => 'المنتج الذي تم ادخالة غير موجود بقاعدة البيانات',

            'percentage.required_without' => 'النسبة المئوية مطلوبة في حالة عدم تحديد السعر',
            'percentage.numeric' => 'النسبة المئوية يجب أن تكون رقم',
            'percentage.min' => 'النسبة المئوية يجي الا تقل عن 0',
            'percentage.max' => 'النسبة المئوية مطليجي الا تزيد عن 100',

            'price.required_without' => ' سعر العرض مطلوب في حالة عدم تحديد النسبة المئوية',
            'price.numeric' => 'سعر العرض يجب ان يكون رقم',
            'price.min' => 'سعر العرض يجب الا يقل عن 0',
            'price.max' => 'سعر العرض يجب الا يزيد عن 100',

            'branches_ids.nullable' => 'مطلوب تحديد فرع واحد علي الاقل',
            'branches_ids.*.exists' => 'الفرع الذي تم ادخاله غير موجود بقاعدة البيانات',

            'from_date.nullable' => 'تاريخ بداية العرض مطلوب',
            'from_date.date' => 'ادخل صيغة صحيحة لتاريخ بداية العرض',

            'to_date.nullable' => 'تاريخ نهاية العرض مطلوب',
            'to_date.date' => 'ادخل صيغة صحيحة لتاريخ نهاية العرض',
        ];
    }


    public function update()
    {


        $data = $this->validate($this->rules() ,$this->messages());
        $this->offer->update($data);

        foreach(BranchOffer::where('offer_id',$this->offer_id)->get() as $branchOffer) {
            $branchOffer->delete();
        }
        foreach($this->branches_ids as $id) {
            BranchOffer::create([
                'offer_id' => $this->offer_id,
                'branch_id' => $id,
            ]);
        }





            

            DB::commit();

            $this->reset(['branches_ids','percentage','description','price','product_id']);

            //dispatch browser events (js)
            //add event to toggle update modal after save
            $this->dispatch('editModalToggle');

            //refrsh data after adding update row
            $this->dispatch('refreshData')->to(DisplayOffers::class);

            $this->dispatch(
            'alert',
                text: trans('admin.offer_updated_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done'),
            );

        // } catch (Throwable $e) {
            //DB::rollback();
        //     report($e);
        //     return false;
        // }

    }

    public function render()
    {
        return view('livewire.offers.update-offer',['offer', $this->offer]);
    }
}
