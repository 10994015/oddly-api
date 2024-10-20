<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class UserComponent extends Component
{
    use WithPagination;
    public $deviceUsername;
    public $deviceCustmoer;
    public $deviceToken;
    public $pwdModalUsername;
    public $pwdModalPassword;

    public $defaultCreateUserNumber = 1;
    public $defaultCreateUserPassword = 'password';

    public $perPage = 10;
    public $search = '';
    public $category = 'all';
    public $salesChart = [];
    public $currentYear;
    public $totalSoldPrice;
    public $totalSoldNumber;
    public $initYear;

    public $customPassword = false;
    public function mount()
    {
        $this->currentYear = (int)now()->format('Y');
        $this->initYear = $this->currentYear;
        $this->reloadChart();
    }
    public function reloadChart(){
        $solds = User::whereYear('sold_date', (int)$this->currentYear)->where('sold', 1)->get();
        $this->totalSoldPrice = $this->formatNumber($solds->sum('sold_price'));
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
    public function changeCustomPassword($stauts){
        $this->customPassword = $stauts==1 ? true : false;
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
        $this->validate([
           'defaultCreateUserPassword'=>'required|min:3|max:50', 
        ]);
        if($this->defaultCreateUserNumber > 1000){
            $this->dispatch('error-create-useres');
            return;
        }
        DB::transaction(function(){
            for($n=1;$n<=$this->defaultCreateUserNumber;$n++){
                $id = DB::table('users')->insertGetId([
                    'name' => 'USER',
                    'username' => null,
                    'password' =>  $this->customPassword ? $this->defaultCreateUserPassword : $this->generateRandomString(),
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
    public function forceOffline($id){
        $user = User::find($id);
        $user->is_online = false;
        $user->save();
    }
    #[Layout('livewire.layouts.app')]
    public function render()
    {
        // $this->resetPage();
        $now = Carbon::now();
        $users = $this->getFilteredUsers();

        $users = $users->where('is_admin', false)
                ->where(function($query) {
                $query->where('username', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('customer', 'like', '%' . $this->search . '%')
                    ->orWhere('device_token', 'like', '%' . $this->search . '%')
                    ->orWhere('expiration', 'like', '%' . $this->search . '%');
            })->paginate($this->perPage);
        $count = $users->count();
        return view('livewire.user-component', compact('users', 'count'));
    }

    public function getFilteredUsers(){
        switch ($this->category) {
            case 'sold':
                return User::where('sold', true);
            case 'unsold':
                return User::where('sold', false);
            case 'unactive':
                return User::where('status', false);
            default:
                return User::query();
        }
    }
    public function updateFilter($newCategory)
    {
        $this->category = $newCategory;
    }
    public function formatNumber($number) {
        return number_format($number, 0, '.', ',');
    }
    function generateRandomString($length = 15)
    {
        // 定義要包含的字符集
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        // 循環生成隨機字符
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }


}
