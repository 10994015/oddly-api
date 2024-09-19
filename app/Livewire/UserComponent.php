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
        $this->getSold();
        
    }
    public function reloadChart($isUpdate=null){
        $this->getSold();
        $this->dispatch('update-chart', $this->salesChart);
    }
    public function getSold(){
        $solds = User::whereYear('sold_date', (int)$this->currentYear)->get();
        $this->totalSoldPrice = $solds->sum('sold_price');
        $this->totalSoldNumber = $solds->count();
        // 按月份分組並計算每月銷售額
        $monthlySales = $solds->groupBy(function($sale) {
            return Carbon::parse($sale->sold_date)->format('n'); // 'n' 返回不帶前導零的月份數字
        })->map(function($group) {
            return $group->sum('sold_price');
        });

        // 準備12個月的銷售額數據
        $monthlyData = collect(range(1, 12))->map(function($month) use ($monthlySales) {
            return $monthlySales->get($month, 0); // 如果沒有數據，返回 0
        })->values()->all();
        log::info($monthlyData);
        $this->salesChart = [
            'labels' => ['一月', '二月', '三月', '四月', '五月','六月','七月','八月','九月','十月','十一月','十二月'],
            'datasets' => [
                [
                    'label' => '年度銷售額',
                    'data' => $monthlyData,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];
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
