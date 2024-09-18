<div class="header">
    <div class="header__logo">
      <strong>Boying</strong>
    </div>
    <nav class="navbar">
      <ul class="navbar__menu">
        <li class="navbar__item">
          <a href="#" class="navbar__link"><i data-feather="home"></i><span>首頁</span> </a>
        @if(!Auth::check())
        <li class="navbar__item">
          <a href="#" class="navbar__link"><i data-feather="settings"></i><span>登入</span></a>
        </li>
        @else
        <li class="navbar__item">
          <form action="{{route('logout')}}" method="post">
            @csrf
            <button type="submit" class="navbar__link"><i data-feather="settings"></i><span>登出</span></button>
          </form>
        </li>
        @endif
      </ul>
    </nav>
  </div>
