<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'Polje :attribute mora biti prihvaćeno.',
    'active_url'           => 'Polje :attribute nije ispravan URL.',
    'after'                => 'Polje :attribute mora biti datum posle :date.',
    'alpha'                => 'Polje :attribute mora sadržati samo slova.',
    'alpha_dash'           => 'Polje :attribute mora sadržati samo slova, brojeve i crtice.',
    'alpha_num'            => 'Polje :attribute mora sadržati samo slova i brojeve.',
    'alpha_spaces'         => 'Polje :attribute mora sadržati samo slova i razmake.',
    'array'                => 'Polje :attribute mora biti niz.',
    'array_int'            => 'Polje :attribute mora biti niz celih brojeva.',
    'before'               => 'Polje :attribute mora biti datum pre :date.',
    'between'              => [
        'numeric' => 'Polje :attribute mora biti između :min i :max.',
        'file'    => 'Polje :attribute mora biti između :min i :max kilobajta.',
        'string'  => 'Polje :attribute mora biti između :min i :max karaktera.',
        'array'   => 'Polje :attribute mora biti između :min i :max stavki.',
    ],
    'boolean'              => 'Polje :attribute mora biti istinito ili neistinito.',
    'confirmed'            => 'Polje :attribute potvrda ne odgovara.',
    'date'                 => 'Polje :attribute nije ispravan datum.',
    'date_format'          => 'Polje :attribute ne odgovara formatu :format.',
    'different'            => 'Polje :attribute i :other moraju biti različiti.',
    'digits'               => 'Polje :attribute mora biti :digits cifara.',
    'digits_between'       => 'Polje :attribute mora biti između :min i :max cifara.',
    'dimensions'           => 'Polje :attribute ima neodgovarajuće dimenzije slike.',
    'distinct'             => 'Polje :attribute ima vrednost koja već postoji.',
    'email'                => 'Polje :attribute mora da bude ispravna email adresa.',
    'exists'               => 'Odabrano polje :attribute već postoji.',
    'file'                 => 'Polje :attribute mora da bude fajl.',
    'filled'               => 'Polje :attribute mora da bude popunjeno.',
    'image'                => 'Polje :attribute mora da bude slika.',
    'in'                   => 'Odabrano polje :attribute nije ispravno.',
    'in_array'             => 'Polje :attribute ne postoji u :other.',
    'integer'              => 'Polje :attribute mora da bude ceo broj.',
    'ip'                   => 'Polje :attribute mora da bude ispravna IP adresa.',
    'json'                 => 'Polje :attribute mora da sude ispravan JSON format.',
    'max'                  => [
        'numeric' => 'Polje :attribute ne sme da bude veće od :max.',
        'file'    => 'Polje :attribute ne sme da bude veće od :max kilobajta.',
        'string'  => 'Polje :attribute ne sme da bude više od :max karaktera.',
        'array'   => 'Polje :attribute ne sme da ima više od :max stavki.',
    ],
    'mimes'                => 'Polje :attribute mora da bude fajl tipa: :values.',
    'mimetypes'            => 'Polje :attribute mora da bude fajl tipa: :values.',
    'min'                  => [
        'numeric' => 'Polje :attribute mora da bude najmanje :min.',
        'file'    => 'Polje :attribute mora da bude najmanje :min kilobajta.',
        'string'  => 'Polje :attribute mora da ima najmanje :min karaktera.',
        'array'   => 'Polje :attribute mora da ima najmanje :min stavki.',
    ],
    'not_in'               => 'Odabrano polje :attribute nije ispravno.',
    'numeric'              => 'Polje :attribute mora da bude broj.',
    'present'              => 'Polje :attribute mora da bude prisutno.',
    'regex'                => 'Format polja :attribute nije ispravan.',
    'required'             => 'Polje :attribute je obavezno.',
    'required_if'          => 'Polje :attribute je obavezno kada je :other jednako :value.',
    'required_unless'      => 'Polje :attribute je obavezno osim kada je :other jednako :values.',
    'required_with'        => 'Polje :attribute je obavezno kada postoji :values.',
    'required_with_all'    => 'Polje :attribute je obavezno kada postoje :values.',
    'required_without'     => 'Polje :attribute je obavezno kada ne postoji :values is not present.',
    'required_without_all' => 'Polje :attribute je obavezno kada ne postoji ni jedno :values.',
    'same'                 => 'Polja :attribute i :other moraju da budu ista.',
    'size'                 => [
        'numeric' => 'Polje :attribute mora da bude :size.',
        'file'    => 'Polje :attribute mora da bude :size kilobajta.',
        'string'  => 'Polje :attribute mora da bude :size karaktera.',
        'array'   => 'Polje :attribute mora da sadrži :size stavki.',
    ],
    'string'               => 'Polje :attribute mora da bude niz znakova.',
    'timezone'             => 'Polje :attribute mora da bude ispravna vremenska zona.',
    'unique'               => 'Polje :attribute je već zauzeto.',
    'uploaded'             => 'Polje :attribute nije uspešno otpremljeno.',
    'url'                  => 'Polje :attribute nema ispravan format.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
