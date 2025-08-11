@php
if (!function_exists('isActive')) {
function isActive($patterns) {
foreach ((array)$patterns as $p) {
if (request()->is($p)) {
return 'active bg-gradient-dark text-white';
}
}
return 'text-dark';
}
}
@endphp

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
          <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
            <img src="{{ asset('material/img/logo-ct-dark.png') }}" class="navbar-brand-img" width="26" height="26" alt="main_logo">

            <span class="ms-1 text-sm text-dark">NOA</span>
        </a>
    </div>

    <hr class="horizontal dark mt-0 mb-2">

    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ isActive(['dashboard', '']) }}" href="{{ route('dashboard') }}">
                    <i class="material-symbols-rounded opacity-5">dashboard</i>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ isActive('chat*') }}" href="{{ route('chat.index') }}">
                    <i class="material-symbols-rounded opacity-5">chat</i>
                    <span class="nav-link-text ms-1">Chat</span>
                </a>
            </li>

            {{-- Adicione outras entradas conforme precisar --}}
        </ul>
    </div>

   
</aside>