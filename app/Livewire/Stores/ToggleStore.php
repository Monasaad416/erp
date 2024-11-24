<?php

namespace App\Livewire\Stores;

use Exception;
use Livewire\Component;
use App\Models\Store;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Togglestore extends Component
{
    public $id,$store ,$is_active,$storeName;
    protected $listeners = ['togglestore'];
    public function togglestore($id)
    {
        $this->id = $id;
        $this->store = Store::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','is_active')->where('id',$id)->first();

        $this->storeName = $this->store->name;
        // return dd($this->store);
        $this->is_active = $this->store->is_active;


        $this->dispatch('changeStateModalToggle');
    }


    public function toggle()
    {
        try{
            if( $this->store->is_active == 1 ){
                $this->store->is_active = 0;
                $this->store->save();
            }else {
                $this->store->is_active = 1;
                $this->store->save();
            }
            $this->dispatch('changeStateModalToggle');

            $this->dispatch('refreshData')->to(DisplayStores::class);

            $this->dispatch(
            'alert',
                text: 'تم تغيير حالة التفعيل للمخزن بنجاح',
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }
    public function render()
    {
        return view('livewire.stores.toggle-store',['store' => $this->store]);
    }
}
