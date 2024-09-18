<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class UserDetailComponent extends Component
{
    public $id;
    public $username;
    public $device_token;
    public $name;
    public $customer;
    public $sold;
    public $sold_price;
    public $status;
    public $expiration;
    public $cerated_at;
    public $updated_at;
    public function mount($id){
        $this->id = $id;
        $user = User::find($id);
        $this->username = $user->username;
        $this->device_token = $user->device_token;
        $this->name = $user->name;
        $this->customer = $user->customer;
        $this->sold = $user->sold == 1 ? true : false;
        $this->sold_price = $user->sold_price;
        $this->status = $user->status==1 ? true : false ;
        Log::info($this->status);
        $this->expiration = $user->expiration;
        $this->cerated_at = $user->created_at;
        $this->updated_at = $user->updated_at;

    }
    public function save(){
        try{
            $user = User::find($this->id);
            $user->username = $this->username;
            $user->device_token = $this->device_token;
            $user->name = $this->name;
            $user->customer = $this->customer;
            $user->sold = $this->sold ? 1 : 0;
            $user->sold_price = $this->sold_price;
            $user->status = $this->status ? 1 : 0;
            $user->expiration = $this->expiration;
            $user->save();
            session()->flash('success', '儲存成功。Updated successfully.');

        }catch (\Exception $exception){
            session()->flash('error', '儲存失敗。Failed to update.');
        }
    }
    #[Layout('livewire.layouts.app')]
    public function render()
    {
        return view('livewire.user-detail-component');
    }
}
