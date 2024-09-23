<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" x-show="createUserModalShow" x-cloak>
    <!-- Modal 內容 -->
    <div class="relative top-1/3 mx-auto p-5 border w-1/3 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">新增帳號</h3>
            <div class="mt-2 px-7 py-3">
                <table class="min-w-full divide-y divide-gray-200 w-full">
                    <tr>
                        <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 w-[100px]">新增數量</td>
                        <td class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 ">
                            <input
                                wire:model="defaultCreateUserNumber"
                                type="number" 
                                class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 ">
                            預設密碼
                        </td>
                        <td class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 ">
                            @if($customPassword)
                            <input
                                wire:model="defaultCreateUserPassword"
                                type="text" 
                                class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                            />
                            <button wire:click="changeCustomPassword(0)" class="px-4 py-2 mt-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">系統隨機產生</button>
                            @else
                            (系統隨機產生)
                            <button wire:click="changeCustomPassword(1)" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">自訂</button>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            @error('defaultCreateUserPassword')
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                  <span class="font-medium">錯誤!</span>  {{ $message }}
                </div>
              </div>
            @enderror
            <div class="items-center px-4 py-3 flex justify-between">
                <button @click="createUserModalShow=false" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300 mr-2">
                    關閉
                </button>
                <button wire:click="createUsers()" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 ml-2">
                    新增
                </button>
            </div>
        </div>
    </div>
</div>
