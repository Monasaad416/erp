<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class ShowUser extends Component
{
    protected $listeners = ['showUser'];
    public $user,$name, $email, $password,$password_confirmation, $roles_name,$branch,$fingerprint_code,
    $date_of_birth,$address,$phone,$age,$has_driving_license=0,$has_medical_insurance=0,$id_num,$id_exp_date,
    $marital_status,$gender,$joining_date,$bloodType,$nationality,$passport_num,$passport_exp_date,
    $resignation_date,$working_status,$image,$vacations_balance,$work_status,$salary,$code,$overtime_hour_price;



    public function showUser($id)
    {
      
        $this->user = User::where('id',$id)->first();
       
        $this->name = $this->user->name;
        $this->email = $this->user->email;
         $this->code = $this->user->code;
          $this->fingerprint_code = $this->user->fingerprint_code;
        $this->roles_name = $this->user->roles_name;
        $this->branch = $this->user->branch->name;

        $this->fingerprint_code = $this->user->fingerprint_code;

        $this->date_of_birth = $this->user->date_of_birth;
        $this->address = $this->user->address;

        $this->phone = $this->user->phone ?? null;
        $this->age = $this->user->age;
        $this->has_driving_license = $this->user->has_driving_license;
        $this->has_medical_insurance = $this->user->has_medical_insurance;
        $this->id_num = $this->user->id_num;
        $this->id_exp_date = $this->user->id_exp_date;
        $this->marital_status = $this->user->marital_status;
        $this->gender = $this->user->gender;
        $this->joining_date = $this->user->joining_date;

        $this->bloodType = $this->user->bloodType->name;
        $this->nationality = $this->user->nationality->name ?? null;
        $this->passport_num = $this->user->passport_num ?? null;
        $this->passport_exp_date = $this->user->passport_exp_date ?? null;
        $this->resignation_date = $this->user->resignation_date ;
        $this->working_status = $this->user->working_status;
        $this->image = $this->user->image;
        $this->vacations_balance = $this->user->vacations_balance;
        $this->salary = $this->user->salary;
        $this->overtime_hour_price = $this->user->overtime_hour_price;

        $this->dispatch('showModalToggle');
    }    
    public function render()
    {
        return view('livewire.users.show-user');
    }
}
