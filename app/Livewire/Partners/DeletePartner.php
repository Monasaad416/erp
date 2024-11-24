<?php

namespace App\Livewire\Partners;

use Alert;
use Exception;
use App\Models\Capital;
use App\Models\Partner;
use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DeletePartner extends Component
{
    protected $listeners = ['deletePartner'];
    public $partner ,$partnerName;

    public function deletePartner($id)
    {
        $this->partner = Partner::where('id',$id)->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->first();
        //dd($this->partner);
        $this->partnerName = $this->partner->name;
        $this->dispatch('deleteModalToggle');
    }


    public function delete()
    {
        try{
            $partner = Partner::where('id',$this->partner->id)->first();
            foreach(Capital::all() as $capital) {
                if($capital->partner_id == $partner->id) {
                    $this->dispatch('deleteModalToggle');
                    Alert::error('عفوا لا يمكن حذف الشريك لوجود رأس مال خاص به');
                    return redirect()->route('partners');
                } else {
                    $partner->delete();
                    $this->dispatch('deleteModalToggle');
                    Alert::success('تم  حذف الشريك بنجاح');
                    return redirect()->route('partners');
                }
            }

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }
    public function render()
    {
        return view('livewire.partners.delete-partner');
    }
}
