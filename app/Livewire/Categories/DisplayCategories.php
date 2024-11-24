<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayCategories extends Component
{
    use WithPagination;
    public $listeners = ['refreshData' =>'$refresh'];

    public $searchItem='';
        public function updatingSearchItem()
    {
        $this->resetPage();
    }
    public function render()
    {
        return view('livewire.categories.display-categories',[
            'categories' => Category::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name',
            'description_'.LaravelLocalization::getCurrentLocale().' as description' ,
            'parent_id','is_active')
            ->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
            ->latest()->paginate(config('constants.paginationNo'))
        ]);
    }
}
