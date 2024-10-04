<div class="py-2 flex flex-col justify-center sm:py-2">
    <div class="sm:max-w-2xl sm:mx-auto w-full">
      <div class="bg-white shadow-md  overflow-hidden">
        <div class="px-6 py-8">
          <h2 class="text-lg font-bold text-gray-800 mb-6">Account Information</h2>
          <form class="space-y-6" wire:submit.prevent="save">
            <div class="grid grid-cols-2 gap-6">
              <div class="col-span-2 sm:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="username">帳號</label>
                <input type="text" wire:model.live="username" id="username" disabled class="bg-gray-100 cursor-not-allowed border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
              </div>
              <div class="col-span-2 sm:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="name">使用者名稱</label>
                <input type="text" wire:model.live="name" id="name" class="bg-white border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
              </div>
              <div class="col-span-2 sm:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="device_token">裝置指紋</label>
                <input type="text" wire:model.live="device_token" id="device_token" disabled class="bg-gray-100 cursor-not-allowed border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
              </div>
              <div class="col-span-2 sm:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="customer">客戶名稱</label>
                <input type="text" wire:model.live="customer" id="customer" class="bg-white border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
              </div>
              <div class="col-span-1">
                <label for="" class="flex items-center">
                  <span class="text-sm font-medium text-gray-700 mr-3">啟用帳號</span>
                  <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                    <input type="checkbox" id="status" wire:model.live="status" class="toggle-checkbox rounded-full absolute block w-6 h-6  bg-white border-4 appearance-none cursor-pointer"/>
                    <label for="status" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                  </div>
                </label>
              </div>
              <div class="col-span-1">
                <label for="" class="flex items-center">
                  <span class="text-sm font-medium text-gray-700 mr-3">售出狀態:<b>{{ $sold ? '已售出' : '未售出' }}</b></span>
                  <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                    <input type="checkbox" id="sold" wire:model.live="sold" class="toggle-checkbox absolute rounded-full block w-6 h-6  bg-white border-4 appearance-none cursor-pointer"/>
                    <label for="sold" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                  </div>
                </label>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="sold_price">售出金額</label>
                <input type="number" wire:model.live="sold_price" id="sold_price" class="bg-white border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
              </div>
              <div class="col-span-2 sm:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="expiration">有效日期</label>
                <input type="date" wire:model.live="expiration" id="expiration" class="bg-white border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
              </div>
              <div class="col-span-2 sm:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="created_at">建立日期</label>
                <input type="date" wire:model.live="created_at" disabled id="created_at" class="bg-gray-100 cursor-not-allowed border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
              </div>
              <div class="col-span-2 sm:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="updated_at">最後更新日期</label>
                <input type="date" wire:model.live="updated_at" disabled id="updated_at" class="bg-gray-100 cursor-not-allowed border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
              </div>
            </div>
            <div class="flex items-center justify-end space-x-4 mt-8">
              <a href="{{route('backend.user.update-password', $id)}}" type="button" class="mr-auto px-4 py-2 border border-gray-300  text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                更改密碼
              </a>
              <a href="{{route('backend.users')}}" class="px-4 py-2 border border-gray-300  text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">回列表</a>
              <button type="submit" class="px-4 py-2 border border-transparent  shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                存檔
              </button>
            </div>
          </form>
          <div>
            @if(session()->has('success'))
            <div class="my-2 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-medium">{{session('success')}}</span> 
            </div>
            @endif
            @if(session()->has('error'))
            <div class="my-2 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">{{ session('error') }}</span> 
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  