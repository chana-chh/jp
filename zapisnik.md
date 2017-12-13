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

MySQLDump (backup)
- https://github.com/ifsnop/mysqldump-php
- https://davidwalsh.name/backup-mysql-database-php

dodavanje rokova i rocista u dane vikenda

phpWord izmene za php7

U fajlu:
PHPOffice\PHPWord\Writer\Word2007\Part\Settings.php
u private function getSettings() izmeniti liniju:
'w:compat' => '',
u:
'w:compat' => array('@attributes' => array('w:val' => '')),


NEMA POVRATKA NA PREDMET IZ POGLEDA PREGLEDA SLIKA ZA PREDMET
