# Munkamegosztás és commitfájlok

A fájloknak egy tulajdonosa van, a két tag commitlistája nem fedi egymást. A fájlútvonalak a `Laravel/` projektmappához képest értendők. Az alábbi commitüzenetek minták: csak akkor használjátok őket, ha az adott változtatás ténylegesen elkészült, és a commit valóban a felsorolt fájlokat tartalmazza.

## 1. tag – Tanösvény-adatok és publikus oldalak

1. `feat(database): tanösvény-adatbázis migrációinak és seederének elkészítése`
	- `database/migrations/2026_11_01_000000_create_tanosvenyek_tables.php`
	- `database/migrations/2026_11_01_000001_remove_unused_tables.php`
	- `database/seeders/TanosvenySeeder.php`
	- `app/Models/Np.php`
	- `app/Models/Telepules.php`
	- `app/Models/Ut.php`
2. `feat(trails): tanösvények megjelenítése az adatbázis oldalon`
	- `app/Http/Controllers/TrailController.php`
	- `resources/views/trails/index.blade.php`
3. `feat(home): kezdőoldal és közös navigáció kialakítása`
	- `routes/web.php`
	- `resources/views/home.blade.php`
	- `resources/views/layouts/site.blade.php`
4. `feat(chart): tanösvény-adatok vizualizálása diagramon`
	- `resources/views/chart.blade.php`
5. `style(ui): reszponzív arculat finomítása`
	- `resources/css/app.css`
	- `public/css/site.css`
6. `test(public): alkalmazásoldalak tesztjeinek hozzáadása és frissítése`
	- `tests/Feature/TrailApplicationTest.php`
7. `docs: munkamegosztás és commitfájlok dokumentálása`
	- `docs/MUNKAMEGOSZTAS.md`

Az 1. tag felel a `routes/web.php`, a közös navigáció és a `TrailApplicationTest.php` teljes fájljának integrálásáért. A 2. tag az általa készített funkciók útvonal- vagy tesztmódosításait átadja az 1. tagnak; ezeket a fájlokat közvetlenül nem commitolja.

## 2. tag – Autentikáció, kapcsolat, üzenetek és admin CRUD

1. `feat(auth): szerepkörök és üzenetek adatbázis-támogatása`
	- `database/migrations/2026_11_01_000002_add_roles_and_contact_messages.php`
	- `app/Models/User.php`
	- `app/Models/ContactMessage.php`
2. `feat(auth): szerepkör-ellenőrzés és hozzáférésvédelem megvalósítása`
	- `app/Http/Middleware/RequireRole.php`
3. `feat(auth): regisztráció és bejelentkezés megvalósítása`
	- `app/Http/Controllers/AuthController.php`
	- `resources/views/auth/login.blade.php`
	- `resources/views/auth/register.blade.php`
4. `feat(contact): kapcsolatűrlap validálása és üzenet mentése`
	- `app/Http/Controllers/ContactController.php`
	- `resources/views/contact.blade.php`
5. `feat(messages): beérkezett üzenetek listázása`
	- `app/Http/Controllers/MessageController.php`
	- `resources/views/messages/index.blade.php`
6. `feat(admin): tanösvények CRUD felületének megvalósítása`
	- `app/Http/Controllers/Admin/TrailController.php`
	- `resources/views/admin/trails/index.blade.php`
	- `resources/views/admin/trails/form.blade.php`

## Szabályok

- Készítsetek fokozatos, értelmes commitokat; a feladatkiírás legalább öt részállapotot kér személyenként.
- Mindenki a saját GitHub-fiókjával commitoljon, és csak a saját munkáját rögzítse.
- A `vendor/` és a helyi `.env` ne kerüljön a forráskód-commitokba. Titkos jelszót vagy hozzáférési adatot ne commitoljatok.