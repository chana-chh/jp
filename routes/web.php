<?php

Route::get('/', 'PocetnaKontroler@pocetna')->name('pocetna');
Route::get('izbor', 'PocetnaKontroler@getIzbor')->name('izbor');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

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
Route::get('sifarnici/vrste_upisnika/pregled/{id}/{godina}', 'VrsteUpisnikaKontroler@getPregled')->name('vrste_upisnika.pregled');
Route::get('tabelaUpisnici', 'VrsteUpisnikaKontroler@tabelaUpisnici')->name('vrste_upisnika.tabelaUpisnici');

//Uprave
Route::get('sifarnici/uprave', 'UpraveKontroler@getLista')->name('uprave');
Route::post('sifarnici/uprave/dodavanje', 'UpraveKontroler@postDodavanje')->name('uprave.dodavanje');
Route::post('sifarnici/uprave/brisanje', 'UpraveKontroler@postBrisanje')->name('uprave.brisanje');
Route::post('sifarnici/uprave/izmena/{id}', 'UpraveKontroler@postIzmena')->name('uprave.izmena');
Route::get('sifarnici/uprave/pregled/{id}', 'UpraveKontroler@getPregled')->name('uprave.pregled');

//Kretanje
Route::post('kretanje/dodavanje', 'KretanjaKontroler@postDodavanje')->name('kretanje_predmeti.dodavanje.post');
Route::post('kretanje/brisanje', 'KretanjaKontroler@postBrisanje')->name('kretanje_predmeti.brisanje');
Route::post('kretanje/izmena', 'KretanjaKontroler@postIzmena')->name('kretanje_predmeti.izmena');
Route::get('kretanje/detalj', 'KretanjaKontroler@getDetalj')->name('kretanje_predmeti.detalj');

//Tipovi rocista
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
Route::get('sifarnici/referenti/promena', 'ReferentiKontroler@getPromenaReferenta')->name('referenti.promena');
Route::post('sifarnici/referenti/refpromena', 'ReferentiKontroler@postPromenaReferenta')->name('referenti.refpromena');
Route::get('sifarnici/referenti/vracanje', 'ReferentiKontroler@getVracanje')->name('referenti.vracanje');
Route::post('sifarnici/referenti/post_vracanje', 'ReferentiKontroler@postVracanje')->name('referenti.post_vracanje');

//Zamene referenata
Route::get('sifarnici/referenti/zamena/{id}', 'ZameneKontroler@getZamena')->name('referenti.zamena');
Route::post('sifarnici/referenti/zamena_add/{id}', 'ZameneKontroler@postZamena_add')->name('referenti.zamena_add');
Route::get('sifarnici/referenti/zamena_del/{id}', 'ZameneKontroler@getZamena_del')->name('referenti.zamena_del');
Route::get('sifarnici/referenti/ciscenje', 'ZameneKontroler@getCiscenje')->name('referenti.ciscenje');

//Korisnici
Route::get('sifarnici/korisnici', 'KorisniciKontroler@getLista')->name('korisnici');
Route::post('sifarnici/korisnici/dodavanje', 'KorisniciKontroler@postDodavanje')->name('korisnici.dodavanje');
Route::post('sifarnici/korisnici/brisanje', 'KorisniciKontroler@postBrisanje')->name('korisnici.brisanje');
Route::post('sifarnici/korisnici/izmena/{id}', 'KorisniciKontroler@postIzmena')->name('korisnici.izmena');
Route::get('sifarnici/korisnici/pregled/{id}', 'KorisniciKontroler@getPregled')->name('korisnici.pregled');

//Predmeti
Route::get('predmeti', 'PredmetiKontroler@getLista')->name('predmeti');
Route::get('predmeti/stampa/{id}', 'PredmetiKontroler@getStampa')->name('stampa');
Route::get('proveraTuzilac', 'PredmetiKontroler@proveraTuzilac')->name('predmeti.proveraTuzilac');
Route::get('proveraKp', 'PredmetiKontroler@proveraKp')->name('predmeti.proveraKp');
Route::get('predmeti/filter', 'PredmetiKontroler@getListaFilter')->name('predmeti.filter');
Route::post('predmeti/filter', 'PredmetiKontroler@postListaFilter')->name('predmeti.pretraga');
Route::get('predmeti/dodavanje/forma', 'PredmetiKontroler@getDodavanje')->name('predmeti.dodavanje.get');
Route::post('predmeti/dodavanje', 'PredmetiKontroler@postDodavanje')->name('predmeti.dodavanje.post');
Route::post('predmeti/brisanje', 'PredmetiKontroler@postBrisanje')->name('predmeti.brisanje');
Route::get('predmeti/izmena/{id}', 'PredmetiKontroler@getIzmena')->name('predmeti.izmena.get');
Route::post('predmeti/izmena/{id}', 'PredmetiKontroler@postIzmena')->name('predmeti.izmena.post');
Route::get('predmeti/pregled/{id}', 'PredmetiKontroler@getPregled')->name('predmeti.pregled');
Route::post('predmeti/arhiviranje', 'PredmetiKontroler@postArhiviranje')->name('predmeti.arhiviranje');



Route::get('predmeti/obrisani', 'PredmetiKontroler@getPredmetiObrisani')->name('predmeti.obrisani');
Route::get('predmeti/slike/{id}', 'PredmetiKontroler@getPredmetiSlike')->name('predmeti.slike');
Route::post('predmeti/slike/{id}', 'PredmetiKontroler@postPredmetiSlike')->name('predmeti.slike.post');
Route::post('predmeti/skenirane/brisanje', 'PredmetiKontroler@postSlikeBrisanje')->name('slike.brisanje');
Route::post('predmeti/obrisani/vracanje', 'PredmetiKontroler@postVracanjeObrisanogPredmeta')->name('predmeti.obrisani.vracanje');
Route::post('predmeti/ajax', 'PredmetiKontroler@postAjax')->name('predmeti.ajax');
Route::get('predmeti/broj', 'PredmetiKontroler@getAjaxBrojPoVrsti')->name('predmeti.broj');

//Predmeti podnesci
Route::get('predmeti/podnesci/{id}', 'PredmetiPodnesci@getPredmetiPodnesci')->name('predmeti.podnesci');
Route::post('predmeti/podnesci/dodavanje', 'PredmetiPodnesci@postPredmetiPodnesci')->name('predmeti.podnesci.dodavanje');

//Predmeti veze
Route::get('predmeti/veze/{id}', 'PredmetiVezeKontroler@getLista')->name('predmeti.veze');
Route::post('predmeti/veze/dodavanje/{id}', 'PredmetiVezeKontroler@postDodavanje')->name('predmeti.veze.dodavanje');
Route::post('predmeti/veze/brisanje/{id}', 'PredmetiVezeKontroler@postBrisanje')->name('predmeti.veze.brisanje');

//Komintenti
Route::get('sifarnici/komintenti', 'KomintentiKontroler@getLista')->name('komintenti');
Route::post('sifarnici/komintenti/dodavanje', 'KomintentiKontroler@postDodavanje')->name('komintenti.dodavanje');
Route::post('sifarnici/komintenti/dodavanje1', 'KomintentiKontroler@postDodavanje1')->name('komintenti.dodavanje1');
Route::post('sifarnici/komintenti/brisanje', 'KomintentiKontroler@postBrisanje')->name('komintenti.brisanje');
Route::post('sifarnici/komintenti/izmena/{id}', 'KomintentiKontroler@postIzmena')->name('komintenti.izmena');
Route::get('sifarnici/komintenti/pregled/{id}', 'KomintentiKontroler@getPregled')->name('komintenti.pregled');
Route::get('predmeti/komintenti/{id}', 'KomintentiKontroler@getPredmetListaKomintenata')->name('predmet.komintenti');
Route::post('predmeti/komintenti/dodavanje/{id}', 'KomintentiKontroler@postPredmetKomintentDodavanje')->name('predmet.komintenti.dodavanje');
Route::post('predmeti/komintenti/brisanje/{id}', 'KomintentiKontroler@postPredmetKomintentBrisanje')->name('predmet.komintenti.brisanje');
Route::post('sifarnici/komintenti/ajax', 'KomintentiKontroler@postAjax')->name('komintenti.ajax');

//Predmeti stari brojevi
Route::get('predmeti/stari_broj/{id}', 'PredmetiStariBrojKontroler@getLista')->name('predmeti.stari_broj');
Route::post('predmeti/stari_broj/dodavanje/{id}', 'PredmetiStariBrojKontroler@postDodavanje')->name('predmeti.stari_broj.dodavanje');
Route::post('predmeti/stari_broj/brisanje', 'PredmetiStariBrojKontroler@postBrisanje')->name('predmeti.stari_broj.brisanje');
Route::post('predmeti/stari_broj/detalj', 'PredmetiStariBrojKontroler@postDetalj')->name('predmeti.stari_broj.detalj');
Route::post('predmeti/stari_broj/izmena', 'PredmetiStariBrojKontroler@postIzmena')->name('predmeti.stari_broj.izmena');

//Predmeti sud broj
Route::get('predmeti/sud_broj/{id}', 'PredmetiSudBrojKontroler@getLista')->name('predmeti.sud_broj');
Route::post('predmeti/sud_broj/dodavanje/{id}', 'PredmetiSudBrojKontroler@postDodavanje')->name('predmeti.sud_broj.dodavanje');
Route::post('predmeti/sud_broj/brisanje', 'PredmetiSudBrojKontroler@postBrisanje')->name('predmeti.sud_broj.brisanje');
Route::post('predmeti/sud_broj/detalj', 'PredmetiSudBrojKontroler@postDetalj')->name('predmeti.sud_broj.detalj');
Route::post('predmeti/sud_broj/izmena', 'PredmetiSudBrojKontroler@postIzmena')->name('predmeti.sud_broj.izmena');

//Rocista
Route::get('rocista', 'RocistaKontroler@getLista')->name('rocista');
Route::get('rocista/dodavanje', 'RocistaKontroler@getDodavanje')->name('rocista.dodavanje.get');
Route::post('rocista/dodavanje', 'RocistaKontroler@postDodavanje')->name('rocista.dodavanje.post');
Route::post('rocista/brisanje', 'RocistaKontroler@postBrisanje')->name('rocista.brisanje');
Route::post('rocista/izmena', 'RocistaKontroler@postIzmena')->name('rocista.izmena');
Route::get('rocista/pregled/{id}', 'RocistaKontroler@getPregled')->name('rocista.pregled');
Route::get('rocista/detalj', 'RocistaKontroler@getDetalj')->name('rocista.detalj');
Route::post('rocista/pretraga', 'RocistaKontroler@postPretraga')->name('rocista.pretraga');
Route::get('rocista/kalendar', 'RocistaKontroler@getKalendar')->name('rocista.kalendar');
Route::get('rocista/kalendar/filter', 'RocistaKontroler@getKalendarFilter')->name('rocista.kalendar.filter');
Route::post('rocista/kalendar/filter', 'RocistaKontroler@postKalendarFilter')->name('rocista.kalendar.filter.post');
Route::get('rocista/ajax', 'RocistaKontroler@getAjax')->name('rocista.ajax');

//Rokovi
Route::get('rokovi', 'RokoviKontroler@getLista')->name('rokovi');
Route::get('rokovi/dodavanje', 'RokoviKontroler@getDodavanje')->name('rokovi.dodavanje.get');
Route::post('rokovi/dodavanje', 'RokoviKontroler@postDodavanje')->name('rokovi.dodavanje.post');
Route::get('rokovi/pregled/{id}', 'RokoviKontroler@getPregled')->name('rokovi.pregled');
Route::post('rokovi/pretraga', 'RokoviKontroler@postPretraga')->name('rokovi.pretraga');
Route::get('rokovi/kalendar', 'RokoviKontroler@getKalendar')->name('rokovi.kalendar');
Route::get('rokovi/kalendar/filter', 'RokoviKontroler@getKalendarFilter')->name('rokovi.kalendar.filter');
Route::post('rokovi/kalendar/filter', 'RokoviKontroler@postKalendarFilter')->name('rokovi.kalendar.filter.post');
Route::get('rokovi/ajax', 'RokoviKontroler@getAjax')->name('rokovi.ajax');

//Knjizenja
Route::post('uprave/dodavanje', 'PredmetiUpraveKontroler@postDodavanje')->name('uprave_predmeti.dodavanje.post');
Route::post('uprave/brisanje', 'PredmetiUpraveKontroler@postBrisanje')->name('uprave_predmeti.brisanje');
Route::post('uprave/izmena', 'PredmetiUpraveKontroler@postIzmena')->name('uprave_predmeti.izmena');
Route::get('uprave/detalj', 'PredmetiUpraveKontroler@getDetalj')->name('uprave_predmeti.detalj');

//Tok predmeta
Route::post('status/dodavanje', 'PredmetiStatusKontroler@postDodavanje')->name('status.dodavanje.post');
Route::post('status/brisanje', 'PredmetiStatusKontroler@postBrisanje')->name('status.brisanje');
Route::post('status/izmena', 'PredmetiStatusKontroler@postIzmena')->name('status.izmena');
Route::get('status/detalj', 'PredmetiStatusKontroler@getDetalj')->name('status.detalj');

//Tokovi novca
Route::get('tok', 'TokoviNovcaKontroler@getPocetna')->name('tok');
Route::post('tok/pretraga', 'TokoviNovcaKontroler@getPretraga')->name('tok.pretraga');
Route::get('tok/grupa/predmet', 'TokoviNovcaKontroler@getGrupaPredmet')->name('tok.grupa_predmet');
Route::get('tok/grupa/vrste_predmeta', 'TokoviNovcaKontroler@getGrupaVrstaPredmeta')->name('tok.grupa_vrste_predmeta');
Route::get('tok/tekuci_mesec', 'TokoviNovcaKontroler@getTekuciMesec')->name('tok.tekuci_mesec');
Route::get('tok/tekuca_godina', 'TokoviNovcaKontroler@getTekucaGodina')->name('tok.tekuca_godina');
Route::post('tok/ajax', 'TokoviNovcaKontroler@postAjaxGrupaPredmet')->name('tok.ajax');

//O programu
Route::get('o_programu', function () {
    return view('o_programu');
})->name('o_programu');

//Izvestaji
Route::get('izvestaji', 'IzvestajiKontroler@getIzvestaji')->name('izvestaji');
Route::post('izvestaji', 'IzvestajiKontroler@postIzvestaji')->name('izvestaji.post');

//Logovi
Route::get('logovi', 'NasLogKontroler@getLogove')->name('logovi');