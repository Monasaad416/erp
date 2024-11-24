<?php

namespace App\Livewire\JournalEntries;

use Livewire\Component;
use App\Models\JournalEntry;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class DisplayEntries extends Component
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
        if(Auth::user()->roles_name == 'سوبر-ادمن') {

            return view('livewire.journal-entries.display-entries',[
            'entries' => JournalEntry::where('entry_num','like','%'.$this->searchItem.'%')
            ->latest()->paginate(config('constants.paginationNo'))
        ]);
        } else{
            return view('livewire.journal-entries.display-entries',[
            'entries' => JournalEntry::where('branch_id',Auth::user()->branch_id)->where('entry_num','like','%'.$this->searchItem.'%')
            ->latest()->paginate(config('constants.paginationNo'))
        ]);
        }

    }
}
