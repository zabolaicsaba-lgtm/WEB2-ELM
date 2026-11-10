@extends('layouts.site')
@section('title', 'Kapcsolat')
@section('content')
<main><header class="page-head"><div class="shell"><div class="eyebrow">Írj nekünk</div><h1>Kapcsolat</h1><p>Észrevétel, kérdés vagy útvonaljavaslat? Küldj üzenetet az oldal készítőinek.</p></div></header><section class="shell content"><div class="form-layout"><div class="form-panel">
    @if($errors->any())<div class="error-summary" role="alert">Kérjük, ellenőrizd a megjelölt mezőket.</div>@endif
    <form method="post" action="{{ route('contact.store') }}" class="form-stack">@csrf
        <div class="field"><label for="name">Név</label><input id="name" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required maxlength="120" autocomplete="name">@error('name')<span class="field-error">{{ $message }}</span>@enderror</div>
        <div class="field"><label for="email">E-mail-cím</label><input id="email" type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required maxlength="190" autocomplete="email">@error('email')<span class="field-error">{{ $message }}</span>@enderror</div>
        <div class="field"><label for="subject">Tárgy</label><input id="subject" name="subject" value="{{ old('subject') }}" required maxlength="160">@error('subject')<span class="field-error">{{ $message }}</span>@enderror</div>
        <div class="field"><label for="message">Üzenet</label><textarea id="message" name="message" required minlength="10" maxlength="5000">{{ old('message') }}</textarea>@error('message')<span class="field-error">{{ $message }}</span>@enderror</div>
        <div><button class="button" type="submit">Üzenet küldése <span aria-hidden="true">↗</span></button></div>
    </form>
</div><aside class="form-aside"><div class="section-kicker">A természet összeköt</div><h3>Oszd meg velünk, amit útközben találtál.</h3><p>Az űrlap szerveroldali ellenőrzés után elmenti az üzenetet. Bejelentkezve a saját neveddel küldheted el.</p><a class="text-link" href="{{ route('trails.index') }}">Közben nézz körül az adatbázisban →</a></aside></div></section></main>
@endsection