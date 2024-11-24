<?php

namespace App\Livewire\CapitalSettings;

use App\Models\Setting;
use Livewire\Component;
use Alert;
use Livewire\WithFileUploads;

class UpdateSettings extends Component
{
    use WithFileUploads;
    public $settings ,$address,$vat,$min_exchange_pos,$max_exchange_pos,$percentage_for_pos,$expiry_days, $point_price,$num_of_points;

    public function mount ()
    {
        $this->settings = Setting::firstOrCreate();
        //dd($this->settings);
        $this->vat = $this->settings->vat;
        $this->min_exchange_pos = $this->settings->min_exchange_pos;
        $this->max_exchange_pos = $this->settings->max_exchange_pos;
        $this->percentage_for_pos = $this->settings->percentage_for_pos;
        $this->expiry_days = $this->settings->expiry_days;
        $this->point_price = $this->settings->point_price;
        $this->num_of_points = $this->settings->num_of_points;
        $this->address = $this->settings->address;

    }
    public function rules() {
        return [
            'settings.vat' => "nullable|numeric|min:0,max:1",
            'settings.min_exchange_pos' => "nullable|numeric",
            'settings.max_exchange_pos' => "nullable|numeric",
            'settings.percentage_for_pos' => 'nullable|numeric',
            'settings.point_price' => 'nullable|numeric',
            'settings.expiry_days' => 'nullable|numeric',
        ];
    }
    public function messages()
    {
        return [
            'settings.vat.numeric' => 'نسبة يجب أن تكون رقم',
            'settings.min_exchange_pos.numeric' => 'أقل عدد نقاط للإستبدال يجب أن تكون رقم',
            'settings.max_exchange_pos.numeric' => 'أقصي عدد نقاط للإستبدال يجب أن تكون رقم',
            'settings.percentage_for_pos.numeric' => 'نسبة الفاتورة لحساب نقاط العميل يجب أن تكون رقم',
            'settings.expiry_days.numeric' => 'عدد أيام صلاحية نقاط البيع يجب أن تكون رقم',
            'settings.point_price.numeric' => 'تكلفة النقطة يجب أن تكون رقم',
            'settings.name.string' => 'إسم المتجر يجي ان يتكون من حروف وأرقام',
            'settings.address.string' => 'عنوان المتجر يجي ان يتكون من حروف وأرقام',
        ];

    }
    public function updatSettings()
    {
     
        $this->validate($this->rules(), $this->messages());

        //dd($this->settings);

        $this->settings->vat = $this->vat;
        $this->settings->min_exchange_pos = $this->min_exchange_pos;
        $this->settings->max_exchange_pos = $this->max_exchange_pos;
        $this->settings->percentage_for_pos = $this->percentage_for_pos;
        $this->settings->expiry_days = $this->expiry_days;
        $this->settings->point_price = $this->point_price;
        $this->settings->num_of_points = $this->num_of_points;
        $this->settings->save();



        $this->resetValidation();

            Alert::success('تم تعديل إعدادات رأس المال بنجاح');
            return redirect()->route('settings.edit');

    }

    public function render()
    {
        $settings = Setting::firstOrCreate([]);
        return view('livewire.capital-settings.update-settings',compact('settings'));
    }
}
