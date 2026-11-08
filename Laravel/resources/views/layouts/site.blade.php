<!doctype html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tanösvények') · Magyar természetjáró atlasz</title>
    <meta name="description" content="Fedezd fel Magyarország tanösvényeit és nemzeti parkjait.">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/flatly/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    @stack('head')
    <script defer src="{{ asset('js/site.js') }}"></script>
</head>
<body>
    <div class="topline"><div class="shell"><span>MAGYARORSZÁG TERMÉSZETI ÖRÖKSÉGE</span><span>10 nemzeti park · 106 település · 144 útvonal</span></div></div>
    <header class="masthead">
        <div class="shell navrow">
            <a class="brand" href="{{ route('home') }}"><span class="brand-mark" aria-hidden="true">⌁</span><span>Tanösvények<small>MAGYAR TERMÉSZETJÁRÓ ATLASZ</small></span></a>
            <button class="menu-toggle" data-menu-toggle aria-expanded="false" aria-label="Menü megnyitása">☰</button>
            <nav class="navlinks" data-navigation aria-label="Fő navigáció">
                <a href="{{ route('home') }}">Főoldal</a>
                <a href="{{ route('trails.index') }}">Adatbázis</a>
                <a href="{{ route('contact.create') }}">Kapcsolat</a>
                <a href="{{ route('chart') }}">Diagram</a>
                @auth
                    <a href="{{ route('messages.index') }}">Üzenetek</a>
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.utak.index') }}">CRUD</a>
                    @endif
                @endauth
                <div class="nav-actions">
                    @guest
                        <a class="button button-small button-light" href="{{ route('login') }}">Bejelentkezés</a>
                        <a class="button button-small" href="{{ route('register') }}">Regisztráció</a>
                    @else
                        <form class="nav-form" method="post" action="{{ route('logout') }}">@csrf<button class="button button-small button-light" type="submit">Kijelentkezés</button></form>
                    @endguest
                </div>
            </nav>
        </div>
    </header>
    @if (session('status'))<div class="shell flash" role="status">{{ session('status') }}</div>@endif
    @yield('content')
    <footer class="footer">
        <div class="shell">
            <div class="footer-grid">
                <div><div class="footer-brand">Tanösvények <span style="color:var(--leaf)">/</span> Atlasz</div><p>Természeti értékek, helyi történetek és bejárható útvonalak egy helyen. Indulj el közelebb a természethez.</p></div>
                <div class="footer-meta">Készítők<br><strong>[Név] · [Neptun-kód]</strong><br><strong>[Társ neve] · [Neptun-kód]</strong></div>
            </div>
            <div class="footer-bottom"><span>WEB-PROGRAMOZÁS II. · LARAVEL BEADANDÓ</span><span>© {{ date('Y') }} Tanösvények atlasz</span></div>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>