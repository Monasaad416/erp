<?php

namespace App\Livewire\Categories;

use Exception;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Validation\Rule;
use App\Livewire\categories\DisplayCategories;

class UpdateCategory extends Component
{
    protected $listeners = ['updateCategory'];
    public $name_ar,$name_en,$description_en,$description_ar,$id, $category,$is_active,$parent_id;

    public function updateCategory($id)
    {
        $this->category = Category::findOrFail($id);

        $this->name_en = $this->category->name_en;
        $this->name_ar = $this->category->name_ar;
        $this->description_en = $this->category->description_en;
        $this->description_ar = $this->category->description_ar;
        $this->is_active = $this->category->is_active;
        $this->parent_id = $this->category->parent_id;

        $this->resetValidation();

        $this->dispatch('editModalToggle');

    }

    public function rules() {
        return [
            'name_ar' => [
                'string',
                'max:255',
                Rule::unique('categories')->ignore($this->category->id, 'id')
            ],
            'name_en' => [
                'string',
                'max:255',
                Rule::unique('categories')->ignore($this->category->id, 'id')
            ],
            'description_ar' => 'string',
            'description_en' => 'string',
            'parent_id' =>'nullable'
        ];
    }

    public function messages()
    {
        return [
            'name_ar.string' => trans('validation.name_ar_string'),
            'name_ar.max' => trans('validation.name_ar_max'),
            'name_ar.unique' => trans('validation.name_ar_unique'),

            'name_en.string' => trans('validation.name_en_string'),
            'name_en.max' => trans('validation.name_en_max'),
            'name_en.unique' => trans('validation.name_en_unique'),

            'description_ar.string' => trans('validation.description_ar_string'),
            'description_en.string' => trans('validation.description_en_string'),
        ];

    }

    public function update()
    {
        $data = $this->validate($this->rules() ,$this->messages());

        try {

            $this->category->update($data);

            $this->reset(['name_en','name_ar','description_ar','description_en']);

            $this->dispatch('editModalToggle');

            $this->dispatch('refreshData')->to(DisplayCategories::class);

            $this->dispatch(
            'alert',
                text: trans('admin.category_updated_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }
    public function render()
    {
        return view('livewire.categories.update-category');
    }
}
