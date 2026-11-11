# Magyar Természetjáró Atlasz
## Laravel webalkalmazás dokumentációja

**Tantárgy:** Web-programozás II.  
**Projekt:** Tanösvények és nemzeti parkok adatbázisára épülő webalkalmazás  
**Készítők:** [Név, Neptun-kód] és [Név, Neptun-kód]  
**Weboldal:** [ÉLES WEBOLDAL URL-JE – kitöltendő]  
**GitHub:** [NYILVÁNOS REPOSITORY URL-JE – kitöltendő]  
**Dokumentáció dátuma:** 2026. november 11.

> **Beadás előtt:** a szögletes zárójelben szereplő személyes és tárhelyadatokat ki kell tölteni. A képernyőkép-helyőrzőket a saját alkalmazásról készített képekre kell cserélni. A tárhelyhez tartozó jelszót ne tárolják a GitHub-repozitóriumban; azt csak a végleges, megfelelően kezelt beadási példányban adják meg.

<div style="page-break-after: always;"></div>

## 1. A projekt bemutatása

A Magyar Természetjáró Atlasz egy szerveroldali Laravel-alkalmazás, amely magyarországi tanösvények és a hozzájuk tartozó települések, illetve nemzeti parkok adatait teszi böngészhetővé. A látogató áttekintést kap az útvonalakról, kereshet és szűrhet az adatbázisban, diagramon hasonlíthatja össze a parkok adatait, valamint kapcsolatfelvételi űrlapon küldhet üzenetet.

Az oldal célja, hogy a kirándulást tervezők egy helyen találják meg a tanösvények fontosabb adatait: az útvonal nevét és hosszát, az állomások számát, a várható bejárási időt, a vezetés elérhetőségét és a kapcsolódó települést. Az alkalmazás emellett bemutatja a Laravelben megvalósított autentikációt, szerepköröket, adatbázis-migrációkat, seedelést, ORM-kapcsolatokat és adminisztrációs CRUD-felületet.

A feladatkiírás szerint az alkalmazás szerveroldali Laravel-projektként készült, felhasználói szerepkörökkel. A jelenlegi kódban a látogató nyilvános oldalakat érhet el, a regisztrált felhasználó beléphet az üzenetekhez, az adminisztrátor pedig a tanösvények kezelésére jogosult. A bemutatott megvalósítás a projekt forráskódja alapján készült; az éles tárhelyre feltöltést és a nyilvános GitHub-hivatkozást a dokumentáció végén kell rögzíteni.

**A projekt céljai:**

- tanösvények adatainak áttekinthető megjelenítése;
- keresés, szűrés és rendezés támogatása;
- három, egymással kapcsolatban álló adatbázistábla kezelése Eloquent ORM-mel;
- kapcsolatfelvételi űrlap és adatbázisban tárolt üzenetek;
- regisztráció, bejelentkezés, kijelentkezés és szerepköralapú hozzáférés;
- adminisztrátori Create, Read, Update, Delete műveletek;
- adatvezérelt diagram és reszponzív felület.

**[KÉPERNYŐKÉP HELYE: A kezdőoldal teljes nézete, a böngésző címsorával és a fő navigációval.]**

<div style="page-break-after: always;"></div>

## 2. Célközönség és jogosultsági szintek

Az alkalmazás háromféle felhasználói állapotot különít el.

| Szerepkör | Elérhető funkciók |
| --- | --- |
| Látogató | Kezdőlap, tanösvény-adatbázis, kapcsolat oldal, diagram, regisztráció és bejelentkezés |
| Regisztrált felhasználó | A látogatói funkciók mellett bejelentkezés után megtekintheti az üzenetek oldalát |
| Adminisztrátor | A regisztrált felhasználói funkciók mellett létrehozhatja, listázhatja, módosíthatja és törölheti a tanösvényeket |

A navigáció szerepkör szerint jeleníti meg a menüpontokat. Az „Üzenetek” bejelentkezett felhasználóknak látható, a „CRUD” menüpontot csak admin szerepkörű felhasználó kapja meg. A hozzáférést nem kizárólag a menü elrejtése biztosítja: az üzenetek útvonala autentikációt, az adminisztrációs útvonalcsoport pedig autentikációt és admin szerepkört is megkövetel. Ennek eredményeként az URL közvetlen megnyitása sem ad hozzáférést nem jogosult felhasználónak.

Regisztrációkor a rendszer a felhasználót `registered` szerepkörrel hozza létre. A `role` mező migrációban alapértelmezett értéke szintén `registered`. Admin-fiók létrehozásához egy meglévő fiók szerepkörét adminisztrátori eljárással kell beállítani. A beadandó admin belépési adatait csak a végleges, hozzáférésében korlátozott dokumentációs példányban kell megadni.

**[KÉPERNYŐKÉP HELYE: A látogatói navigáció és a bejelentkezett felhasználó navigációja; a CRUD menüpont admin fiókkal látszódjon.]**

<div style="page-break-after: always;"></div>

## 3. Technológiai felépítés

A szerveroldali alkalmazás Laravel 12 keretrendszert és PHP 8.2 vagy újabb verziót használ. A nézetek Blade sablonok. Az adatbázis-kezelést az Eloquent ORM végzi, a táblák szerkezetét migrációk írják le, az alapadatok betöltését seeder végzi. Az útvonalak a `routes/web.php` fájlban vannak regisztrálva, az üzleti logika külön vezérlőkben található.

A böngészőoldali megjelenítést saját CSS biztosítja a `public/css/site.css` fájlból, a kisebb navigációs és diagraminterakciókat pedig a `public/js/site.js`. A layout egy külső Bootswatch Flatly stíluslapot is betölt, a megjelenés fő arculatát azonban a projekt saját stílusai alakítják. A grafikon a Chart.js 4.4.8 CDN-ről betöltött könyvtárával készül. A webes betűkészletek DM Sans és Manrope családok; a kezdőoldal háttérfotója Unsplash-kép.

**Főbb alkalmazásrétegek:**

- `routes/web.php`: nyilvános, autentikációval védett és adminisztrátori útvonalak;
- `app/Http/Controllers`: oldalak adatainak előkészítése, űrlapok kezelése és validáció;
- `app/Models`: Eloquent modellek és adatbázis-kapcsolatok;
- `resources/views`: Blade nézetek és közös oldalelrendezés;
- `database/migrations`: adatbázis-séma létrehozása és visszabontása;
- `database/seeders`: a tanösvény-adatok beolvasása és betöltése;
- `public/css` és `public/js`: felhasználói felület stílusai és kliensoldali kódja.

A szerver a kérést az útvonalhoz rendeli, a vezérlő az Eloquent modelleken keresztül lekéri vagy módosítja az adatokat, végül a Blade nézet HTML-ként jeleníti meg az eredményt. A POST űrlapok CSRF-védelmet használnak. A forgalmas műveletekhez (bejelentkezés, regisztráció és kapcsolatfelvétel) útvonalankénti kéréskorlátozás is be van állítva.

**[KÉPERNYŐKÉP HELYE: Projektstruktúra az editorban, a routes, controllers, models és views mappákkal.]**

<div style="page-break-after: always;"></div>

## 4. Adatmodell és kapcsolatok

A tanösvények alapadatai három táblában helyezkednek el. A `np` tábla tárolja a nemzeti park igazgatóságok nevét. A `telepules` táblában a település neve és a hozzá tartozó nemzeti park azonosítója szerepel. Az `ut` tábla a tanösvény nevét, hosszát, állomásszámát, bejárási idejét, vezetésének elérhetőségét és a település idegen kulcsát tartalmazza.

A relációk sorrendje: egy nemzeti parkhoz több település tartozhat; egy településhez több tanösvény tartozhat; egy tanösvény egy településhez kapcsolódik. Az idegen kulcsok megakadályozzák, hogy a település nem létező parkra vagy a tanösvény nem létező településre hivatkozzon. A kapcsolódó rekordok törlése korlátozott, ezért az adatkapcsolatok véletlenül nem szakadnak meg.

Az Eloquent modellek a kapcsolatokat a `hasMany` és `belongsTo` relációkkal írják le. Az `Ut` modell az eltérő táblanévhez (`ut`) és elsődleges kulcshoz (`azon`) igazodik; a `Telepules` és az `Np` modell ugyancsak explicit táblanevet használ. A listázás és a diagram előállítása kapcsolatok előzetes betöltésével történik, hogy a kapcsolódó nevek megjelenítése ne okozzon minden rekordnál külön lekérdezést.

Az alkalmazás kiegészítő táblái a Laravel-felhasználókat tároló `users`, valamint a kapcsolatfelvételi üzeneteket rögzítő `contact_messages`. Az üzenet opcionálisan a beküldő felhasználóhoz kötődik; vendégként küldött üzenetnél ez a kapcsolat üres maradhat. A felhasználói szerepkört a `users.role` mező rögzíti.

| Tábla | Szerepe | Fontos mezők |
| --- | --- | --- |
| `np` | Nemzeti parkok | `id`, `nev` |
| `telepules` | Parkhoz rendelt települések | `id`, `nev`, `npid` |
| `ut` | Tanösvények | `azon`, `nev`, `hossz`, `allomas`, `ido`, `vezetes`, `telepulesid` |
| `users` | Felhasználói fiókok | `name`, `email`, `password`, `role` |
| `contact_messages` | Kapcsolati űrlap beküldései | `user_id`, `name`, `email`, `subject`, `message`, időbélyegek |

**[KÉPERNYŐKÉP HELYE: Adatbázis-diagram vagy adatbázis-kezelő képernyő a három tanösvényes tábla idegen kulcsaival.]**

<div style="page-break-after: always;"></div>

## 5. Migrációk és adatfeltöltés

Az adatbázis létrehozása migrációkon keresztül történik, így a séma kódban követhető és új környezetben megismételhető. A tanösvényes migráció létrehozza az `np`, `telepules` és `ut` táblákat, valamint a szükséges idegen kulcsokat. Egy későbbi migráció hozzáadja a felhasználók szerepkörét, majd létrehozza a `contact_messages` táblát. A `down` metódusok a migrációk visszavonását szolgálják.

A forrásadatok a `database/data/tanosvenyek` könyvtár tabulátorral tagolt szövegfájljaiban találhatók: `np.txt`, `telepules.txt` és `ut.txt`. A `TanosvenySeeder` beolvassa a fejlécet, ellenőrzi a mezők számát, a számértékeket normalizálja, majd tranzakcióban tölti be az adatokat. Először a parkok, utána a települések, végül a tanösvények kerülnek az adatbázisba, ezzel az idegen kulcsok sorrendje is betartható.

Fejlesztői környezetben a projektgyökérből az alábbi parancsokkal lehet telepíteni és inicializálni az alkalmazást. A `.env` adatbázis-beállításait a helyi környezethez kell igazítani; a titkos kulcsot minden saját környezethez külön kell létrehozni.

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate --seed
```

Az adatbázis újraépítésére csak fejlesztői környezetben, a meglévő adatok törlésének tudatában használható a `php artisan migrate:fresh --seed`. Éles környezetben migráció előtt biztonsági mentést kell készíteni, majd az éles adatbázishoz illeszkedő migrációs folyamatot kell alkalmazni.

**[KÉPERNYŐKÉP HELYE: Sikeres migráció és seeder futásának terminálkimenete, személyes vagy titkos adatok nélkül.]**

<div style="page-break-after: always;"></div>

## 6. Kezdőlap és tanösvény-adatbázis

A kezdőlap a projekt témáját egy természetjárásra hangolt nyitóképpel, rövid bemutató szöveggel és két fő navigációs lehetőséggel vezeti be. A látogató az útvonal-kereséshez vagy az adatokat összegző diagramhoz léphet tovább. Az adatbázisból származó összesítők megmutatják a tanösvények, települések és parkok számát, az oldal pedig néhány kiemelt útvonalat is felsorol.

Az adatbázis oldal szerveroldalon dolgozza fel a keresési feltételeket. A felhasználó útvonal vagy település nevére kereshet, nemzeti parkot választhat, megadhatja, hogy elérhető-e vezetés, valamint név, hossz vagy időtartam szerint rendezhet. Az eredmény 12-es oldalankénti lapozással jelenik meg; a keresési feltételek lapozáskor is megmaradnak. Ha nincs találat, az oldal üres találati állapotot és új keresésre vonatkozó visszajelzést mutat.

A szűrőmezőket a vezérlő validálja. A keresőkifejezés szöveg és legfeljebb 100 karakter lehet, a parkazonosító csak létező parkra hivatkozhat, a vezetés értéke `0` vagy `1`, a rendezési oszlop és irány pedig engedélyezett értékek közül választható. A megengedett rendezési mezők korlátozása megelőzi, hogy a kliens tetszőleges oszlopnevet adjon át az adatbázis-lekérdezésnek.

**[KÉPERNYŐKÉP HELYE: Tanösvény-adatbázis a keresőmezővel, nemzeti park és vezetés szűrőkkel, valamint néhány találattal.]**

<div style="page-break-after: always;"></div>

## 7. Kapcsolatfelvétel és üzenetek

A Kapcsolat oldalon a látogató nevet, e-mail-címet, tárgyat és legalább 10 karakteres üzenetet ad meg. A beküldés szerveroldali validációja minden mezőre vonatkozik: a név legfeljebb 120, az e-mail-cím 190, a tárgy 160, az üzenet 5000 karakter hosszú lehet. Hibás adat esetén a rendszer visszatér az űrlaphoz, megjeleníti a mezőhibákat, és megtartja a korábban beírt értékeket.

Sikeres beküldés után az adatok a `contact_messages` táblába kerülnek. Ha a beküldő be van jelentkezve, az üzenet a felhasználói fiókjához is kapcsolódik; vendég esetén a `user_id` mező üres. Az űrlap kérése CSRF-védett, és időkorlát védi a túl gyakori beküldésektől. A felület sikeres mentésről szóló visszajelzést ad.

Az Üzenetek oldal kizárólag bejelentkezés után érhető el. Az üzenetek fordított időrendben, a legújabbtól a régebbi felé jelennek meg, az oldalon a küldés dátuma és ideje is látható. A lista 15 üzenetenként lapozható. A megjelenített üzenettartalmat a Blade alapértelmezett escapingje HTML-ként történő értelmezés nélkül írja ki.

**[KÉPERNYŐKÉP HELYE: Kapcsolati űrlap kitöltetlen és validációs hibát mutató állapota.]**

**[KÉPERNYŐKÉP HELYE: Bejelentkezett felhasználó Üzenetek oldala, legalább egy tesztüzenettel és dátummal.]**

<div style="page-break-after: always;"></div>

## 8. Diagram

A Diagram oldal a nemzeti parkokhoz tartozó települések és tanösvények számát hasonlítja össze. A vezérlő Eloquent-kapcsolatokon keresztül lekéri a parkokat, a településeket és azok útvonalait, majd előkészíti a diagram címkéit és adatsorait. A megjelenítés a Chart.js könyvtárával történik, így az adatok vizuális összevetése közvetlenül a böngészőben lehetséges.

A felületen két választható adatsor van: a tanösvények és a települések száma. A grafikon adatai a szerverről érkeznek, így a diagram az adatbázis aktuális tartalmát mutatja. A kategóriák címkéi a nemzeti parkok nevei.

**[KÉPERNYŐKÉP HELYE: Diagram oldal a tanösvények adatsorral.]**

**[KÉPERNYŐKÉP HELYE: Ugyanaz a diagram a települések adatsorra váltva.]**

<div style="page-break-after: always;"></div>

## 9. Regisztráció, bejelentkezés és kijelentkezés

A regisztráció név, egyedi e-mail-cím és legalább 8 karakteres jelszó megadását kéri. A jelszót meg kell erősíteni, és az adatkezelési feltételek elfogadása is kötelező. A szerveroldali validáció ellenőrzi a kötelező mezőket, az e-mail-cím formátumát és egyediségét, a jelszó hosszát és a megerősítés egyezését. A jelszó hash-elve tárolódik, nem olvasható formában kerül az adatbázisba.

Sikeres regisztráció után a rendszer automatikusan bejelentkezteti a felhasználót, `registered` szerepkört ad neki, majd az Üzenetek oldalra irányítja. Bejelentkezéskor az e-mail-cím és jelszó párosát ellenőrzi az alkalmazás; hibás adatok esetén hibaüzenetet jelenít meg. Sikeres azonosítás után a munkamenet azonosítója megújul. Az űrlapon az „Emlékezz rám” opció is elérhető.

Kijelentkezés POST kéréssel történik. A rendszer lezárja a hitelesített munkamenetet, érvényteleníti a korábbi sessiont, új CSRF-tokent állít elő, és visszairányít a kezdőlapra. A bejelentkezési és regisztrációs végpontok kéréskorlátozása csökkenti a túl sok ismételt próbálkozás kockázatát.

**[KÉPERNYŐKÉP HELYE: Regisztrációs űrlap és sikeres regisztráció utáni állapot.]**

**[KÉPERNYŐKÉP HELYE: Bejelentkezési oldal, majd a fejléc bejelentkezés utáni állapota.]**

<div style="page-break-after: always;"></div>

## 10. Adminisztráció és CRUD

Az adminisztráció a tanösvények karbantartását teszi lehetővé. Az útvonalak táblázatban listázhatók, a felület megjeleníti többek között a tanösvény nevét, települését, hosszát, állomásszámát és a vezetés elérhetőségét. A lista 15 rekordos oldalakon lapozható.

Az adminisztrátor új tanösvényt hozhat létre, meglévő adatot módosíthat, illetve megerősítés után törölhet. A tanösvény minden esetben létező településhez tartozik, a nemzeti park a település kapcsolatából következik. A szerver ellenőrzi a mezők típusát és megengedett tartományát: a hossz és az idő nem lehet negatív, az állomások száma nemnegatív egész, a vezetés logikai érték, a településazonosítónak pedig léteznie kell.

A CRUD útvonalak az `admin` URL-előtag alatt vannak csoportosítva, és az `auth` valamint `role:admin` middleware védi őket. A jogosultsági ellenőrzés a szerveren történik, ezért egy regisztrált felhasználó közvetlen URL-kéréssel sem végezhet admin műveletet. Sikeres mentés, módosítás vagy törlés után a felhasználó visszakerül a listához, és állapotüzenetet kap.

**[KÉPERNYŐKÉP HELYE: Admin tanösvénylista műveleti linkekkel.]**

**[KÉPERNYŐKÉP HELYE: Tanösvény létrehozása vagy szerkesztése űrlap.]**

<div style="page-break-after: always;"></div>

## 11. Felhasználói felület és reszponzivitás

A felület saját, természetjárás témájú vizuális rendszert használ. A színpalettában sötét erdőzöld, világos háttér, levélzöld kiemelés és visszafogott korall szín jelenik meg. A címsorokhoz Manrope, a törzsszöveghez DM Sans betűcsaládot tölt be a stíluslap. A nyitóoldal fotóháttérrel és erős kontrasztú címmel emeli ki a projekt témáját; a további oldalak tömör, adatközpontú elrendezést használnak.

A közös `layouts.site` Blade layout egységes fejlécet, navigációt, státuszüzenetet és láblécet biztosít. A mobil nézetben a navigáció összecsukható menüvé alakul, a többoszlopos tartalmi blokkok egymás alá rendeződnek, a szűrőmezők és admin táblázatok pedig kisebb képernyőhöz igazodnak. A CSS külön töréspontokat alkalmaz 900, 700 és 390 pixel környékén.

A külső szolgáltatásokból betöltött elemek internetkapcsolatot igényelnek: ilyen a Bootswatch stíluslap, a Chart.js, a Google Fonts és a kezdőoldali Unsplash-fotó. Hálózati hozzáférés hiányában ezek nem feltétlenül jelennek meg. A felhasznált külső kép és könyvtár licencét, illetve hivatkozását a végleges beadandóban szükség esetén fel kell tüntetni.

**[KÉPERNYŐKÉP HELYE: Kezdőlap asztali nézetben.]**

**[KÉPERNYŐKÉP HELYE: Adatbázis vagy navigáció mobilnézetben, a böngésző fejlesztői eszközének mobil emulációjával.]**

<div style="page-break-after: always;"></div>

## 12. Tesztelés, telepítés és beadási adatok

A projekt Pest alapú Laravel funkcionális teszteket tartalmaz. A jelenlegi tesztek lefedik a nyilvános oldalak betöltését, kapcsolatfelvételi üzenet mentését, a regisztrált szerepkört, az admin útvonal elutasítását nem admin felhasználónál, a bejelentkezést és kijelentkezést, valamint az admin tanösvény-létrehozás, -módosítás és -törlés folyamatát.

A tesztek futtatása a projekt gyökeréből:

```powershell
php artisan test
```

Az éles telepítéshez a projektet Laravel futtatására alkalmas tárhelyre kell feltölteni, be kell állítani az adatbázis-kapcsolatot és a környezeti változókat, telepíteni kell a Composer-függőségeket, majd futtatni kell a migrációkat és seedert a tárhelyhez megfelelő eljárással. Éles környezetben `APP_DEBUG=false` beállítás, HTTPS és biztonságos kulcskezelés szükséges. A feladatkiírás az éles weboldal, a nyilvános GitHub-repozitórium és a csoporttagok közreműködését igazoló verziótörténet megadását is kéri.

### Beadás előtt kitöltendő adatok

- **Hallgató 1:** [teljes név] – [Neptun-kód] – [elkészített feladatrész]
- **Hallgató 2:** [teljes név] – [Neptun-kód] – [elkészített feladatrész]
- **Éles weboldal címe:** [URL]
- **Nyilvános GitHub-projekt:** [URL]
- **Admin belépés:** [felhasználónév/e-mail] – [jelszó a beadási példányban]
- **Tárhely FTP adatok:** [hoszt és felhasználónév; a jelszót ne tegyék nyilvános repozitóriumba]
- **Adatbázis-hozzáférés:** [hoszt, adatbázisnév és felhasználónév; a jelszót biztonságosan adják meg]
- **Képernyőképek:** a fenti helyőrzők cseréje saját, működő alkalmazásról készült képekre

A tárhelyre és az adminisztrációra vonatkozó jelszavak érzékeny adatok. A GitHubra csak a forráskód és a titkok nélküli dokumentáció kerülhet. A beadás előtt ellenőrizni kell, hogy a megadott URL-ek nyilvánosan megnyithatók-e, az admin-fiók működik-e, a dokumentáció legalább 10 oldalra tördelhető-e, és a képernyőképek minden helyőrzőnél szerepelnek-e.

**[KÉPERNYŐKÉP HELYE: Nyilvános éles oldal böngészőben.]**

**[KÉPERNYŐKÉP HELYE: GitHub-repozitórium commitlistája úgy, hogy mindkét csoporttag munkája azonosítható legyen.]**

## Források és projektfájlok

- A projekt működésének és követelményeinek alapja a munkaterületen található Laravel beadandó-feladatkiírás.
- Tanösvény-adatok: `database/data/tanosvenyek/np.txt`, `telepules.txt`, `ut.txt`.
- Laravel dokumentáció: https://laravel.com/docs
- Chart.js dokumentáció: https://www.chartjs.org/docs/
- Bootswatch: https://bootswatch.com/flatly/
- A kezdőoldali fotó az alkalmazás stíluslapjában hivatkozott Unsplash-kép; a végleges beadandóban a képhasználati feltételeknek megfelelő forráshivatkozást kell megadni.