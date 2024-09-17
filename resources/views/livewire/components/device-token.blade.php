<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" x-show="deviceModalShow">
    <!-- Modal 內容 -->
    <div class="relative top-1/3 mx-auto p-5 border w-2/3 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">裝置指紋</h3>
            <div class="mt-2 px-7 py-3">
                <table class="min-w-full divide-y divide-gray-200 w-full">
                    <tr>
                        <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 w-[100px]">帳號</td>
                        <td class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 ">{{$deviceUsername}}</td>
                    </tr>
                    <tr>
                        <td class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 ">客戶名稱</td>
                        <td class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 ">{{$deviceCustmoer}}</td>
                    </tr>
                    <tr>
                        <td class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 ">裝置指紋</td>
                        <td class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300 ">{{$deviceToken}}</td>
                    </tr>
                </table>
            </div>
            <div class="items-center px-4 py-3">
                <button @click="deviceModalShow=false" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    關閉
                </button>
            </div>
        </div>
    </div>
</div>
