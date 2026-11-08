@extends('layouts.site')
@section('title', 'Tanösvény adatbázis')
@section('content')
<main>
    <header class="page-head"><div class="shell"><div class="eyebrow">A következő kirándulásod</div><h1>Tanösvény-adatbázis</h1><p>Szűrj útvonal, település, nemzeti park és vezetés szerint. Találd meg a hozzád illő ösvényt.</p></div></header>
    <section class="shell content">
        <form class="filterbar" method="get" action="{{ route('trails.index') }}">
            <div class="field"><label for="q">Keresés</label><input id="q" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Tanösvény vagy település neve"></div>
            <div class="field"><label for="park">Nemzeti park</label><select id="park" name="park"><option value="">Mindegyik</option>@foreach($parks as $park)<option value="{{ $park->id }}" @selected(($filters['park'] ?? '') == $park->id)>{{ $park->nev }}</option>@endforeach</select></div>
            <div class="field"><label for="guided">Vezetés</label><select id="guided" name="guided"><option value="">Mindegyik</option><option value="1" @selected(($filters['guided'] ?? '') === '1')>Elérhető</option><option value="0" @selected(($filters['guided'] ?? '') === '0')>Nincs</option></select></div>
            <div class="field"><label for="sort">Rendezés</label><select id="sort" name="sort"><option value="nev" @selected(($filters['sort'] ?? 'nev') === 'nev')>Név</option><option value="hossz" @selected(($filters['sort'] ?? '') === 'hossz')>Hossz</option><option value="ido" @selected(($filters['sort'] ?? '') === 'ido')>Időtartam</option></select></div>
            <div class="filter-submit"><button class="button button-small" type="submit">Szűrés <span aria-hidden="true">⌕</span></button></div>
        </form>
        <p class="results-line">{{ $trails->total() }} útvonal a szűrésnek megfelelően</p>
        @if($trails->count())<div class="trail-list">@foreach($trails as $trail)<article class="trail-row"><div class="trail-row-art" aria-hidden="true"></div><div class="trail-row-content"><h3>{{ $trail->nev }}</h3><p>{{ $trail->telepules->nev }} · {{ $trail->telepules->np->nev }}</p><div class="trail-row-stats"><span>{{ number_format((float) $trail->hossz, 1, ',', ' ') }} km</span><span>{{ $trail->allomas }} állomás</span><span>{{ number_format((float) $trail->ido, 1, ',', ' ') }} óra</span><span>{{ $trail->vezetes ? 'Vezetett' : 'Önálló bejárás' }}</span></div></div></article>@endforeach</div><div class="pagination">{{ $trails->links('pagination::simple-tailwind') }}</div>@else<div class="empty-state">Nincs a keresésnek megfelelő tanösvény. Próbálj más szűrőt.</div>@endif
    </section>
</main>
@endsection