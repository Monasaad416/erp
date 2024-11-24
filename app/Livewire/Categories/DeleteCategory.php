<?php

namespace App\Livewire\Categories;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use SebastianBergmann\Template\Exception;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class DeleteCategory extends Component
{
    protected $listeners = ['deleteCategory'];
    public $category ,$categoryName;

    public function deleteCategory($id)
    {
        $this->category = Category::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('id',$id)->first();
    //dd($this->category);
        $this->categoryName = $this->category->name;

        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        try{
            $category = Category::where('id',$this->category->id)->first();

            $products = Product::where('category_id',$this->category->id)->get();
            if($products->count() > 0) {
                $this->dispatch('deleteModalToggle');
                $this->dispatch(
                'alert',
                    text: trans('admin.cannot_delete_category'),
                    icon: 'error',
                    confirmButtonText: trans('admin.done'),

                );
            } else {
                $category->delete();
                $this->reset('category');

                $this->dispatch('deleteModalToggle');

                $this->dispatch('refreshData')->to(DisplayCategories::class);

                $this->dispatch(
                'alert',
                    text: trans('admin.category_deleted_successfully'),
                    icon: 'success',
                    confirmButtonText: trans('admin.done'),

            );
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }
    public function render()
    {
        return view('livewire.categories.delete-category');
    }
}

