
  <header class="header-outer">
    <div class="header-inner responsive-wrapper">
      <div class="header-logo">
        <a href="{{route('users')}}">HOME</a>
      </div>
      <nav class="header-navigation">
        @if(Auth::check())
          <form action="{{route('logout')}}" method="post">
            @csrf
            <button type="submit" class="navbar__link"><i data-feather="settings"></i><span>登出</span></button>
          </form>
        @endif
      </nav>
    </div>
  </header>