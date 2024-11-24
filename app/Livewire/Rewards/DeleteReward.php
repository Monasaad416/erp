<?php

namespace App\Livewire\Rewards;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Reward;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Alert;

class DeleteReward extends Component
{
    protected $listeners = ['deleteReward'];
    public $reward ,$rewardName,$rewardAmount,$rewardMonth;

    public function deletereward($id)
    {
        $this->reward = Reward::where('id',$id)->first();
        //dd($this->reward);
        $this->rewardName = User::where('id',$this->reward->user_id)->first()->name;
        $this->rewardAmount = $this->reward->amount;
        $this->rewardMonth = $this->reward->financialMonth->month_name;

        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        try{
                $reward = Reward::where('id',$this->reward->id)->first();
                if($reward->financial_month_id < Carbon::now()->format('m')  || Carbon::parse($reward->created_at)->format('Y') < Carbon::now()->format('Y')){
                    $this->dispatch('deleteModalToggle');
                    Alert::error('عفوا لا يمكن حذف مكافاءة  من راتب تم إستلامه');
                 
                } else {
                    $this->dispatch('deleteModalToggle');

                    $reward->delete();
                    Alert::success('تم حذف المكافاءة بنجاح');
                    return redirect()->route('users.rewards');
                }


        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }
    public function render()
    {
        return view('livewire.rewards.delete-reward');
    }
}
