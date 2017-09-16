# TODO

## Novo

- Razraditi i uskladiti validaciju na pogledima u bazi i u kontrolerima ???

- Kron job backupovanje (ipak mora da se strtuje neki cron job na serveru koji pokrece laravel-ov scheduler)

- Ovako to izgleda po seljacki:
```php
public function backup() {
    $fajl = 'G:\DB\2017-09-16_14-27-33';
    exec('e:/xampp/mysql/bin/mysqldump --opt -h localhost -u korisnik -plozinka baza > ' . $fajl);
}
```

- SoftDelete pogledati [kad se uradi brisanje videce se da li ovo radi]
