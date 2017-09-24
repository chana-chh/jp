# TODO

## Novo

- Razraditi i uskladiti validaciju na pogledima u bazi i u kontrolerima ???

- Kron job backupovanje (ipak mora da se strtuje neki cron job na serveru koji pokrece laravel-ov scheduler) ++
- https://laravel.com/docs/5.4/scheduling

- https://code.tutsplus.com/tutorials/managing-cron-jobs-with-php--net-19428 (procitati komentare)


- Ovako to izgleda po seljacki:
```php
public function backup() {
    $fajl = 'G:\DB\2017-09-16_14-27-33';
    exec('e:/xampp/mysql/bin/mysqldump --opt -h localhost -u korisnik -plozinka baza > ' . $fajl);
}
```

- MySQLDump (backup)
- https://github.com/ifsnop/mysqldump-php
- https://davidwalsh.name/backup-mysql-database-php

- i pogled za restore u administrativnom delu sa malim brojem detalja u tabeli i bez posebne pretrage
    - dodati pregled obrisanih predmeta u admin meni
    - dodati pogled predmeti_obrisani (samo tabela obrisanih predmeta sa dugmetom za vaskrsnuce) modal
    - dodati metodu u PredmetiKontroler getPredmetiObrisani (lista brisanih predmeta za pogled predmeti_brisani)
    - dodati metodu u PredmetiKontroler postVracanjeObrisanogPredmeta (postavljanje deleted_at na NULL) - ajax
    - obe metode u kontroleru zastititi sa admin middleware-om