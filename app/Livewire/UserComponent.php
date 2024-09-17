<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithoutUrlPagination;

class UserComponent extends Component
{
    use WithoutUrlPagination;
    public $deviceUsername;
    public $deviceCustmoer;
    public $deviceToken;
    public $pwdModalUsername;
    public $pwdModalPassword;
    public function openDeviceModal($id){
        $user = User::find($id);
        $this->deviceUsername = $user->username;
        $this->deviceCustmoer = $user->customer;
        $this->deviceToken = $user->device_token;
        $this->dispatch('open-device-model');
    }
    public function openPasswordModal($id){
        $user = User::find($id);
        $this->pwdModalUsername = $user->username;
        $this->pwdModalPassword = $user->password;
        $this->dispatch('open-password-model');
    }
    public function render()
    {
        $users = User::where('is_admin', false)->paginate(5);
        return view('livewire.user-component', compact('users'))->layout('livewire.layouts.app');
    }
}
