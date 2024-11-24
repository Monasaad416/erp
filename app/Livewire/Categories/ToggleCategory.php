<?php

namespace App\Livewire\Categories;

use Exception;
use Livewire\Component;
use App\Models\Category;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ToggleCategory extends Component
{
    public $id,$category ,$is_active,$categoryName;
    protected $listeners = ['toggleCategory'];
    public function toggleCategory($id)
    {
        $this->id = $id;
        $this->category = Category::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','is_active')->where('id',$id)->first();

        $this->categoryName = $this->category->name;
        // return dd($this->category);
        $this->is_active = $this->category->is_active;


        $this->dispatch('changeStateModalToggle');
    }


    public function toggle()
    {
        try{
            if( $this->category->is_active == 1 ){
                $this->category->is_active = 0;
                $this->category->save();
            }else {
                $this->category->is_active = 1;
                $this->category->save();
            }
            $this->dispatch('changeStateModalToggle');

            $this->dispatch('refreshData')->to(DisplayCategories::class);

            $this->dispatch(
            'alert',
                text: trans('admin.category_state_changed_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }
    public function render()
    {
        return view('livewire.categories.toggle-category',['category' => $this->category]);
    }
}
