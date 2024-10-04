<div class="py-6 flex items-center justify-center">
    <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-xl shadow-md">
      <div>
        <h2 class="mt-6 text-center text-lg font-extrabold text-gray-900">
          更改密碼
        </h2>
        <p class="text-center">
            {{ $username }} / {{$name}}
        </p>
      </div>
      <form class="mt-8 space-y-6" wire:submit.prevent="submitForm">
        <div class="rounded-md shadow-sm -space-y-px">
          <div>
            <label for="password" class="sr-only">輸入密碼</label>
            <input id="password" name="password" type="password" wire:model.live="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="輸入密碼">
          </div>
          <div>
            <label for="confirmPassword" class="sr-only">確認密碼</label>
            <input wire:model.live='confirmPassword' id="confirmPassword" name="confirmPassword" type="password" wire:model.defer="confirmPassword" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="確認密碼">
          </div>
        </div>
  
        @error('password') 
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
        @error('confirmPassword') 
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
  
        <div>
          <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            送出
          </button>
        </div>
      </form>
  
      @if (session()->has('success'))
      <div class="my-2 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <span class="font-medium">{{session('success')}}</span> 
    </div>
      @endif
      @if (session()->has('error'))
      <div class="my-1 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <span class="font-medium">{{ session('error') }}</span> 
    </div>
      @endif
      <a href="{{route('backend.users')}}" class="block text-center px-4 py-2 border border-gray-300  text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">回列表</a>
    </div>
  </div>