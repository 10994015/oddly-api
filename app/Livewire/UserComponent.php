<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
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

    public $defaultCreateUserNumber = 1;
    public $defaultCreateUserPassword = 'password';

    public $perPage = 10;
    public $search = '';
    public $category = 1;
    public $salesChart = [];
    public $currentYear;
    public $totalSoldPrice;
    public $totalSoldNumber;
    public $initYear;
    public function mount()
    {
        $this->currentYear = (int)now()->format('Y');
        $this->initYear = $this->currentYear;
        $this->reloadChart();
    }
    public function reloadChart(){
        $solds = User::whereYear('sold_date', (int)$this->currentYear)->get();
        $this->totalSoldPrice = $solds->sum('sold_price');
        $this->totalSoldNumber = $solds->count();
    }
    /**
     * Reset the filter value to $category.
     *
     * @param  int  $category
     * @return void
     */
    public function resetFilter($catgory){
        $this->category = $catgory;
    }
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
    public function createUsers(){
        if($this->defaultCreateUserNumber > 1000){
            $this->dispatch('error-create-useres');
            return;
        }
        DB::transaction(function(){
            for($n=1;$n<=$this->defaultCreateUserNumber;$n++){
                $id = DB::table('users')->insertGetId([
                    'name' => 'USER',
                    'username' => null,
                    'password' =>  $this->defaultCreateUserPassword,
                    'is_admin' => false,
                    'created_at' => now(),
                ]);
                DB::table('users')
                ->where('id', $id)
                ->update([
                    'username' => 'username' . $id,
                    'name' => 'USER' . $id,
                ]);
            }
        });
        $this->dispatch('success-create-users');
        $this->reset('defaultCreateUserNumber');
        $this->reset('defaultCreateUserPassword');
    }
    #[Layout('livewire.layouts.app')]
    public function render()
    {

        $now = Carbon::now();
        $users = User::where('is_admin', false)
            ->where(function($query) {
                $query->where('username', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('customer', 'like', '%' . $this->search . '%')
                    ->orWhere('device_token', 'like', '%' . $this->search . '%')
                    ->orWhere('expiration', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            });

        // 其餘代碼保持不變
        if ($this->category == 1) {
            $users = $users->paginate($this->perPage);
        } elseif ($this->category == 2) {
            $users = $users->where('sold', 1)->paginate($this->perPage);
        } elseif ($this->category == 3) {
            $users = $users->where('sold', 0)->paginate($this->perPage);
        } elseif ($this->category == 4) {
            $users = $users->where('status', 0)->paginate($this->perPage);
        }
        return view('livewire.user-component', compact('users',));
    }
}
