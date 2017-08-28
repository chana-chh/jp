<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PocetnaKontroler@pocetna')->name('pocetna');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home'); // ???
Auth::routes();

//Vrste predmeta
Route::get('sifarnici/vrste_predmeta', 'VrstePredmetaKontroler@getLista')->name('vrste_predmeta');
Route::post('sifarnici/vrste_predmeta/dodavanje', 'VrstePredmetaKontroler@postDodavanje')->name('vrste_predmeta.dodavanje');
Route::post('sifarnici/vrste_predmeta/brisanje', 'VrstePredmetaKontroler@postBrisanje')->name('vrste_predmeta.brisanje');
Route::post('sifarnici/vrste_predmeta/izmena/{id}', 'VrstePredmetaKontroler@postIzmena')->name('vrste_predmeta.izmena');
Route::get('sifarnici/vrste_predmeta/pregled/{id}', 'VrstePredmetaKontroler@getPregled')->name('vrste_predmeta.pregled');

//Vrste upisnika
Route::get('sifarnici/vrste_upisnika', 'VrsteUpisnikaKontroler@getLista')->name('vrste_upisnika');
Route::post('sifarnici/vrste_upisnika/dodavanje', 'VrsteUpisnikaKontroler@postDodavanje')->name('vrste_upisnika.dodavanje');
Route::post('sifarnici/vrste_upisnika/brisanje', 'VrsteUpisnikaKontroler@postBrisanje')->name('vrste_upisnika.brisanje');
Route::post('sifarnici/vrste_upisnika/izmena/{id}', 'VrsteUpisnikaKontroler@postIzmena')->name('vrste_upisnika.izmena');
Route::get('sifarnici/vrste_upisnika/pregled/{id}', 'VrsteUpisnikaKontroler@getPregled')->name('vrste_upisnika.pregled');

//Uprave
Route::get('sifarnici/uprave', 'UpraveKontroler@getLista')->name('uprave');
Route::post('sifarnici/uprave/dodavanje', 'UpraveKontroler@postDodavanje')->name('uprave.dodavanje');
Route::post('sifarnici/uprave/brisanje', 'UpraveKontroler@postBrisanje')->name('uprave.brisanje');
Route::post('sifarnici/uprave/izmena/{id}', 'UpraveKontroler@postIzmena')->name('uprave.izmena');
Route::get('sifarnici/uprave/pregled/{id}', 'UpraveKontroler@getPregled')->name('uprave.pregled');

//Sudovi
Route::get('sifarnici/tipovi_rocista', 'TipoviRocistaKontroler@getLista')->name('tipovi_rocista');
Route::post('sifarnici/tipovi_rocista/dodavanje', 'TipoviRocistaKontroler@postDodavanje')->name('tipovi_rocista.dodavanje');
Route::post('sifarnici/tipovi_rocista/brisanje', 'TipoviRocistaKontroler@postBrisanje')->name('tipovi_rocista.brisanje');
Route::post('sifarnici/tipovi_rocista/izmena/{id}', 'TipoviRocistaKontroler@postIzmena')->name('tipovi_rocista.izmena');
Route::get('sifarnici/tipovi_rocista/pregled/{id}', 'TipoviRocistaKontroler@getPregled')->name('tipovi_rocista.pregled');

//Sudovi
Route::get('sifarnici/sudovi', 'SudoviKontroler@getLista')->name('sudovi');
Route::post('sifarnici/sudovi/dodavanje', 'SudoviKontroler@postDodavanje')->name('sudovi.dodavanje');
Route::post('sifarnici/sudovi/brisanje', 'SudoviKontroler@postBrisanje')->name('sudovi.brisanje');
Route::post('sifarnici/sudovi/izmena/{id}', 'SudoviKontroler@postIzmena')->name('sudovi.izmena');
Route::get('sifarnici/sudovi/pregled/{id}', 'SudoviKontroler@getPregled')->name('sudovi.pregled');

//Statusi
Route::get('sifarnici/statusi', 'StatusiKontroler@getLista')->name('statusi');
Route::post('sifarnici/statusi/dodavanje', 'StatusiKontroler@postDodavanje')->name('statusi.dodavanje');
Route::post('sifarnici/statusi/brisanje', 'StatusiKontroler@postBrisanje')->name('statusi.brisanje');
Route::post('sifarnici/statusi/izmena/{id}', 'StatusiKontroler@postIzmena')->name('statusi.izmena');
Route::get('sifarnici/statusi/pregled/{id}', 'StatusiKontroler@getPregled')->name('statusi.pregled');

//Referenti
Route::get('sifarnici/referenti', 'ReferentiKontroler@getLista')->name('referenti');
Route::post('sifarnici/referenti/dodavanje', 'ReferentiKontroler@postDodavanje')->name('referenti.dodavanje');
Route::post('sifarnici/referenti/brisanje', 'ReferentiKontroler@postBrisanje')->name('referenti.brisanje');
Route::post('sifarnici/referenti/izmena/{id}', 'ReferentiKontroler@postIzmena')->name('referenti.izmena');
Route::get('sifarnici/referenti/pregled/{id}', 'ReferentiKontroler@getPregled')->name('referenti.pregled');

//Korisnici
Route::get('sifarnici/korisnici', 'KorisniciKontroler@getLista')->name('korisnici');
Route::post('sifarnici/korisnici/dodavanje', 'KorisniciKontroler@postDodavanje')->name('korisnici.dodavanje');
Route::post('sifarnici/korisnici/brisanje', 'KorisniciKontroler@postBrisanje')->name('korisnici.brisanje');
Route::post('sifarnici/korisnici/izmena/{id}', 'KorisniciKontroler@postIzmena')->name('korisnici.izmena');
Route::get('sifarnici/korisnici/pregled/{id}', 'KorisniciKontroler@getPregled')->name('korisnici.pregled');

//Predmeti
Route::get('predmeti', 'PredmetiKontroler@getLista')->name('predmeti');
Route::post('predmeti', 'PredmetiKontroler@getLista')->name('predmeti.pretraga');
Route::get('predmeti/dodavanje/forma', 'PredmetiKontroler@getDodavanje')->name('predmeti.dodavanje.get');
Route::post('predmeti/dodavanje', 'PredmetiKontroler@postDodavanje')->name('predmeti.dodavanje.post');
Route::post('predmeti/brisanje', 'PredmetiKontroler@postBrisanje')->name('predmeti.brisanje');
Route::get('predmeti/izmena/{id}', 'PredmetiKontroler@getIzmena')->name('predmeti.izmena.get');
Route::post('predmeti/izmena/{id}', 'PredmetiKontroler@postIzmena')->name('predmeti.izmena.post');
Route::get('predmeti/pregled/{id}', 'PredmetiKontroler@getPregled')->name('predmeti.pregled');
// Route::post('predmeti/pretraga', 'PredmetiKontroler@postPretraga')->name('predmeti.pretraga');


//Rocista
Route::get('rocista', 'RocistaKontroler@getLista')->name('rocista');
Route::get('rocista/dodavanje', 'RocistaKontroler@getDodavanje')->name('rocista.dodavanje.get');
Route::post('rocista/dodavanje', 'RocistaKontroler@postDodavanje')->name('rocista.dodavanje.post');
Route::post('rocista/brisanje', 'RocistaKontroler@postBrisanje')->name('rocista.brisanje');
Route::post('rocista/izmena', 'RocistaKontroler@postIzmena')->name('rocista.izmena');
Route::get('rocista/pregled/{id}', 'RocistaKontroler@getPregled')->name('rocista.pregled');
Route::get('rocista/detalj', 'RocistaKontroler@getDetalj')->name('rocista.detalj');
Route::get('rocista/kalendar', 'RocistaKontroler@getKalendar')->name('rocista.kalendar');
