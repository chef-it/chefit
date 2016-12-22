@include('partials.head')

@include('partials.nav')

<div id="sideMenu" class="sideMenu">
    @yield('sideMenu')
</div>

<div id="sideMenu2" class="sideMenu">
    @yield('sideMenu2')
</div>

@yield('content')

@include('partials.foot')
