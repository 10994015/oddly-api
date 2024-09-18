<div class=" mx-auto mt-8 px-4 w-full"
x-data="{
    deviceModalShow: false,
    passwordModalShow:false,
    openDeviceModel() {
        this.deviceModalShow =  true;
    },
    openPasswordModel() {
        this.passwordModalShow =  true;
    }
}"
x-on:open-device-model.window="openDeviceModel()"
x-on:open-password-model.window="openPasswordModel()"
>
    @include('livewire.components.device-token')
    @include('livewire.components.show-password')
    <h2 class="text-lg mb-4">帳號列表</h2>
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col justify-center space-y-4 md:flex-row md:space-y-0 md:space-x-4 p-4 bg-white rounded-lg shadow">
            <select wire:model.live="perPage" class="p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-[100px]">
                <option value="10">10 筆</option>
                <option value="20">20 筆</option>
                <option value="50">50 筆</option>
                <option value="100">100 筆</option>
                <option value="200">200 筆</option>
                <option value="500">500 筆</option>
            </select>

            <!-- 搜尋輸入框 -->
            <input
                wire:model.live.debounce.250ms="search"
                type="text"
                placeholder="搜尋..."
                class="p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 flex-grow"
            >
        </div>
        <div class="flex flex-col justify-center items-center space-y-4 md:flex-row md:space-y-0 md:space-x-4 p-4 bg-white rounded-lg shadow">

            <!-- 分類按鈕 -->
            <div class="flex space-x-2">
                <button wire:click="resetFilter(1)" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    全部顯示
                </button>
                <button wire:click="resetFilter(2)" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    已售出
                </button>
                <button wire:click="resetFilter(3)" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                    未售出
                </button>
                <button wire:click="resetFilter(4)" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                    已停用
                </button>
            </div>
            <div>
                分類:全部顯示
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg w-full">
      <table class="min-w-full divide-y divide-gray-200 w-full">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID(流水號)</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">姓名</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">帳號</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">密碼</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">裝置指紋</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">啟用狀態</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">客戶名稱</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">售出狀態</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">有效日期</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">建立時間</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">最後更新時間</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($users as $user)
            <tr wire:key="{{$user->id}}">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$user->id}}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$user->name}}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$user->username}}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <button wire:click='openPasswordModal({{$user->id}})' class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">查看密碼</button>
              </td>
              <td  class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                @if($user->device_token)
                    <button wire:click='openDeviceModal({{$user->id}})' class="bg-green-700 hover:bg-green-900 text-white font-bold py-2 px-4 rounded">查看裝置指紋</button>
                @else
                    <span class="text-gray-400">尚未綁定</span>
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-black ">
                  @if($user->status==1)
                  <div class="text-green-500">啟用</div>

                  @else
                  <span class="text-red-500">停用</span>
                  @endif
                </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->customer }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-black">
                @if($user->sold)
                    <span class="text-green-500">已售出</span>
                @else
                    <span class="">-</span>
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$user->expiration ?? '-'}}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$user->created_at}}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$user->updated_at}}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <a href="{{route('user.edit', $user->id)}}" class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">編輯</a>
                <a href="{{route('user.update-password', $user->id)}}" class=" bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-center">更改密碼</a>
            </td>
            </tr>
            @empty
                <td class="px-6 py-12 whitespace-nowrap text-sm text-gray-500 text-center" colspan="12">查無資料。</td>
            @endforelse
        </tbody>
      </table>
    </div>
    <div class="mt-10">
        {{$users->links()}}
      </div>
</div>
