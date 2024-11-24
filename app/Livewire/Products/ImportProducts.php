<?php

namespace App\Livewire\Products;

use Excel;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\ProductsImport;
use Alert;

class ImportProducts extends Component
{
    use WithFileUploads;
    public $file;
    protected $listeners = ['importProducts'];

    public function importProducts()
    {
        $this->reset(['file']);
        $this->resetValidation();
        $this->dispatch('importModalToggle');
    }
    public function rules() {
        return [
            'file'=>'required|max:50000|mimes:xlsx,application/excel,csv'
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'لم يتم اختيار ملف للتحميل',
            'file.max' => 'أقصي حجم للملف يجب الا يتعدي 50MB',
            'file.mimes' => 'يجب تحميل ملف إكسل  ذات امتداد .xlsx',
        ];

    }
    public function storeImportedProdcts()
    {
        $this->validate($this->rules() ,$this->messages());
 //dd ($this->file);
        Excel::import(new ProductsImport, $this->file);
        
        $this->reset(['file']);
        $this->resetValidation();
        //dispatch browser events (js)
        //add event to toggle import modal after save
        $this->dispatch('importModalToggle');


        //refrsh data after adding new row
        Alert::success('تم إستيراد المنتجات من ملف اكسل بنجاح');
        return redirect()->route('products');
    }
    public function render()
    {
        return view('livewire.products.import-products');
    }
}
