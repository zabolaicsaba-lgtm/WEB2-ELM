<?php

use App\Models\ContactMessage;
use App\Models\Telepules;
use App\Models\User;
use App\Models\Ut;
use Database\Seeders\TanosvenySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(TanosvenySeeder::class);
});

test('public pages render the trail database and chart', function () {
    $this->get('/')->assertOk()->assertSee('Apró lépések.');
    $this->get('/adatbazis')->assertOk()->assertSee('Tanösvény-adatbázis');
    $this->get('/diagram')->assertOk()->assertSee('park-chart');
    $this->get('/kapcsolat')->assertOk()->assertSee('Kapcsolat');
});

test('contact form validates and stores a message', function () {
    $this->post('/kapcsolat', [
        'name' => 'Teszt Elek',
        'email' => 'teszt@example.test',
        'subject' => 'Útvonal kérdés',
        'message' => 'Hol találok további útvonalinformációt?',
    ])->assertRedirect('/kapcsolat');

    expect(ContactMessage::count())->toBe(1);
    $this->assertDatabaseHas('contact_messages', ['email' => 'teszt@example.test']);
});

test('registration grants the registered role and admin access is protected', function () {
    $this->post('/regisztracio', [
        'name' => 'Teszt Felhasználó',
        'email' => 'tag@example.test',
        'password' => 'TesztJelszo123!',
        'password_confirmation' => 'TesztJelszo123!',
        'terms' => '1',
    ])->assertRedirect('/uzenetek');

    $user = User::where('email', 'tag@example.test')->firstOrFail();
    expect($user->role)->toBe('registered');

    $this->get('/uzenetek')->assertOk();
    $this->get('/admin/utak')->assertForbidden();
});

test('a registered user can log in and log out', function () {
    User::factory()->create([
        'email' => 'belepo@example.test',
        'password' => bcrypt('TesztJelszo123!'),
        'role' => 'registered',
    ]);

    $this->post('/bejelentkezes', [
        'email' => 'belepo@example.test',
        'password' => 'TesztJelszo123!',
    ])->assertRedirect('/uzenetek');

    $this->assertAuthenticated();
    $this->post('/kijelentkezes')->assertRedirect('/');
    $this->assertGuest();
});

test('admin can create update and delete a trail', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $town = Telepules::firstOrFail();
    $this->actingAs($admin);

    $this->post('/admin/utak', [
        'nev' => 'Teszt tanösvény',
        'hossz' => '2.5',
        'allomas' => 6,
        'ido' => '1.5',
        'vezetes' => 1,
        'telepulesid' => $town->id,
    ])->assertRedirect('/admin/utak');

    $trail = Ut::where('nev', 'Teszt tanösvény')->firstOrFail();
    $this->put("/admin/utak/{$trail->azon}", [
        'nev' => 'Módosított tanösvény',
        'hossz' => '3.5',
        'allomas' => 8,
        'ido' => '2',
        'vezetes' => 0,
        'telepulesid' => $town->id,
    ])->assertRedirect('/admin/utak');

    $this->assertDatabaseHas('ut', ['azon' => $trail->azon, 'nev' => 'Módosított tanösvény']);
    $this->delete("/admin/utak/{$trail->azon}")->assertRedirect('/admin/utak');
    $this->assertDatabaseMissing('ut', ['azon' => $trail->azon]);
});