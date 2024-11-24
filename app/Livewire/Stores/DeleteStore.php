<?php

namespace App\Livewire\Stores;

use App\Models\Product;
use Livewire\Component;
use App\Models\Store;
use SebastianBergmann\Template\Exception;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class DeleteStore extends Component
{
    protected $listeners = ['deleteStore'];
    public $store ,$storeName;

    public function deleteStore($id)
    {
        $this->store = Store::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('id',$id)->first();
        //dd($this->Store);
        $this->storeName = $this->store->name;

        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        try{
            $store = Store::where('id',$this->store->id)->delete();
                $this->dispatch('deleteModalToggle');
                $this->dispatch('refreshData')->to(DisplayStores::class);
                $this->dispatch(
                'alert',
                    text: 'تم حذف المخزن بنجاح',
                    icon: 'success',
                    confirmButtonText: trans('admin.done'),
                );

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }
    public function render()
    {
        return view('livewire.stores.delete-store');
    }
}

