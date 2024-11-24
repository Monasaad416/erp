<?php

namespace App\Livewire\Categories;

use Exception;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Validation\Rule;
use App\Livewire\Categories\DisplayCategories;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddCategory extends Component
{
    public $categories,$name_ar,$name_en,$description_en,$description_ar,$parent_id,$id,$is_active;

    public function rules() {
        return [
            'name_ar' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')
            ],
            'name_en' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories')
            ],
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'parent_id' => "nullable|exists:categories,id",
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => trans('validation.name_ar_required'),
            'name_ar.string' => trans('validation.name_ar_string'),
            'name_ar.max' => trans('validation.name_ar_max'),
            'name_ar.unique' => trans('validation.name_ar_unique'),

            'name_en.string' => trans('validation.name_en_string'),
            'name_en.max' => trans('validation.name_en_max'),
            'name_en.unique' => trans('validation.name_en_unique'),

            'description_ar.string' => trans('validation.description_ar_string'),
            'description_en.string' => trans('validation.description_en_string'),

            'parent_id.exists' => trans('validation.parent_id_exists'),
        ];

    }

    public function create()
    {
        $this->validate($this->rules() ,$this->messages());
        try {

            Category::create([
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
                'description_ar' => $this->description_ar,
                'description_en' => $this->description_en,
                'is_active' => 1,
                'parent_id' => $this->parent_id
            ]);

            $this->reset(['name_ar','name_en','description_ar','description_en','parent_id','is_active' ]);

            $this->dispatch('createModalToggle');

            $this->dispatch('refreshData')->to(DisplayCategories::class);

            $this->dispatch(
            'alert',
                text: trans('admin.category_created_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')
            );
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }
    public function render()
    {
        return view('livewire.categories.add-category');
    }
}
