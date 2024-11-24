<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayUsers extends Component
{
    use WithPagination;
    public $searchItem;
    public $listeners = ['refreshData' =>'$refresh'];

    public $name,$email,$roles_name,$user,$branch_id;


    public function updatingSearchItem()
    {
        $this->resetPage();
    }

    public function render()
    {

        return view('livewire.users.display-users',['users' => 
        User::where('name','like','%'.$this->searchItem.'%')
            ->orWhere('email','like','%'.$this->searchItem.'%')
            ->orWhere('roles_name','like','%'.$this->searchItem.'%')
            ->latest()->paginate(config('constants.paginationNo'))
        ]);
    }
}
