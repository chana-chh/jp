# Potrebni programi

- server, db, php (xampp)
- tekst editori (VS Code, Sublime Text 3, Notepad ++)
- IDE (NetBeans)
- rad sa MySQL bazama (HeidiSQL)
- pretraživači (Chrome, Opera, Firefox, IE)
- paketi za PHP (Composer)
- paketi za JS (Node.js)
- verzije (Git)

# Priprema Laravela 5.4

Instalacija Laravel installer-a:
```
C:\> composer global require "laravel/installer"
```

# Kreiranje novog projekta u Laravelu

Kreiranje novog Laravel projekta kada je instaliran Laravel installer:
```
C:\xampp\htdocs> laravel new <naziv_projekta>
```

## Git

Pdešavanje emaila i korisničkog imena:
```
C:\> git config --global user.email "chanasrb@gmail.com"
C:\> git config --global user.name "chana-chh"
```
Postavljanje Laravel projekta (jp) na GitHub:
```
C:\xampp\htdocs\jp> git init
C:\xampp\htdocs\jp> git add .
C:\xampp\htdocs\jp> git commit -m "pocetni"
C:\xampp\htdocs\jp> git remote add origin https://github.com/chana-chh/jp
C:\xampp\htdocs\jp> git push -u -f origin master
```
Kloniranje projekta sa GitHub-a na lokalni računar:
```
C:\xampp\htdocs> git clone https://github.com/chana-chh/jp
C:\xampp\htdocs> cd jp
C:\xampp\htdocs\jp>
```

## Baza podataka

Napraviti bazu podataka 'jp' (collation utf8mb4_unicode_ci) i podesiti parametre u .env fajlu:
```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jp
DB_USERNAME=root
DB_PASSWORD=
```

## Autentikacija i autorizacija

### Migracije

Korisnici - reimenovati migraciju create_users_table u create_korisnici_table:
```php
Schema::create('korisnici', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name');
    $table->string('username', 190)->unique();
    $table->string('password');
    $table->integer('level')->unsigned();
    $table->rememberToken();
    $table->timestamps();
});
```
Password reset:
```php
Schema::create('password_resets', function (Blueprint $table) {
    $table->string('username', 190)->index();
    $table->string('token');
    $table->timestamp('created_at')->nullable();
});
```

### Seeder

```
C:\xampp\htdocs\jp> php artisan make:seeder TabelaKorisniciSeeder
```
```php
DB::table('korisnici')->insert([
    'name' => 'Ненад Чанић',
    'username' => 'админ',
    'password' => bcrypt('чаша'),
    'level' => 0]);
DB::table('korisnici')->insert([
    'name' => 'Станислав Јаковљевић',
    'username' => 'корисник',
    'password' => bcrypt('усер'),
    'level' => 10]);
```
DatabaseSeeder:
```php
$this->call(TabelaKorisniciSeeder::class);
```

### Model

Napraviti dir Models u app i premestiti u njega User.php, a zatim ga preimenovati u Korisnik.php
```php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Korisnik extends Authenticatable
{
    use Notifiable;
    protected $table = 'korisnici';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password', 'level'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
```

### Kontroler

U LoginController dodati:
```php
protected $redirectTo = '/';

public function username()
{
    return 'username';
}
```

### Konfiguracija

U config/auth.php izmeniti
```php
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\Korisnik::class,
    ],

    // 'users' => [
    //     'driver' => 'database',
    //     'table' => 'users',
    // ],
],
```

### Instalacija

```
C:\xampp\htdocs\jp> php artisan migrate
C:\xampp\htdocs\jp> php artisan db:seed
C:\xampp\htdocs\jp> php artisan make:auth
```

### Podešavanja posle instalacije

Dodati Kontroler:
```php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Kontroler extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }
}

```

Dodati PocetnaKontroler
```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PocetnaKontroler extends Kontroler
{

    public function pocetna()
    {
        echo Gate::allows('admin') ? 'admin' : 'non admin';
        return view('pocetna');
    }
}
```
U api.php izbrisati rutu:
```php
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
```

Rute u web.php treba da izgledaju ovako:
```php
Route::get('/', 'PocetnaKontroler@pocetna')->name('pocetna');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');
```
Preimenovati welcome.blade.php u pocetna.blade.php:
```html
<body>
  <h1>Pocetna strana</h1>
  <a href="{{ route('logout') }}"
      onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      Logout
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      {{ csrf_field() }}
  </form>
  <p>Ovo vidi svako</p>
  @if (Gate::allows('admin'))
    <p>Ovo vidi samo admin</p>
  @endif
</body>
```
`Napomena:` Mozda treba napraviti neku ekstenziju za blade.

Promeniti login.blade.php:
```html
<body>
<h1>Пријава</h1>
<form class="form-horizontal" method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

            <input id="username" type="text" name="username" value="{{ old('username') }}" placeholder="Корисничко име" required autofocus>
            <input id="password" type="password" placeholder="Лозинка" name="password" required>

            <button type="submit" class="btn btn-primary">Пријави се</button>
</form>
</body>
```

U AuthServiceProvider dodati:
```php
Gate::define('admin', function ($user)
        {
            return $user->level === 0;
        });
```
`Napomena:` Ne radi u konstruktoru Kontrolera. Da bi se koristilo u konstruktoru Kontrolera verovatno treba da se napravi middleware.

Sledeći fajlovi mogu da se brišu:

- app\Http\Controllers\Auth\ForgotPasswordController.php
- app\Http\Controllers\Auth\RegisterController.php
- app\Http\Controllers\Auth\ResetPasswordController.php
- app\Http\Controllers\HomeController.php
- resources\views\auth\passwords (dir)
- resources\views\auth\register.blade.php
- resources\views\layouts (dir)
- resources\views\home.blade.php



