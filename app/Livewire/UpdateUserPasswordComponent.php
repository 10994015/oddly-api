<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class UpdateUserPasswordComponent extends Component
{
    public $password = '';
    public $confirmPassword = '';
    public $id;
    public $username;
    public $name;
    protected $rules = [
        'password' => 'required|min:3',
        'confirmPassword' => 'required|same:password',
    ];
    public function  mount($id){
        $this->id = $id;
        $user = User::find($id);
        $this->username = $user->username;
        $this->name = $user->name;
    }

    public function submitForm()
    {
        $this->validate();

        // 處理密碼更新邏輯
        // 例如：更新用戶密碼，發送確認郵件等
        try{
            $user = User::find($this->id);
            $user->password = $this->password;
            $user->save();
            session()->flash('success', '密碼已成功更新！');
        }catch (\Exception $exception){
            session()->flash('error', '更新失敗。Failed to update.');
        }
    }

    #[Layout('livewire.layouts.app')]
    public function render()
    {
        return view('livewire.update-user-password-component');
    }

}
