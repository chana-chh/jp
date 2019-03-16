@if(count($podaci) === 0)
<h2 class="text-warning text-center">Нема резултата за задате критеријуме.</h3>
@else

    @foreach($podaci as $row)
    <tr>
        <td>{{ $row->id}}</td>
        @if($row->arhiviran == 0)
        <td><span class="status text-primary" style="text-align:center; font-weight: bold; vertical-align: middle; line-height: normal;" data-container="body" data-toggle="popover" data-placement="right" title="Опис:" data-content="{{ $row->opis }}"></span>{{ $row->st_naziv }}</td>
        @else
        <td><span class="status text-danger" style="text-align:center; font-weight: bold; vertical-align: middle; line-height: normal;" data-container="body" data-toggle="popover" data-placement="right" title="Опис:" data-content="{{ $row->opis }}"></span>{{ $row->st_naziv }}</td>
        @endif
        <td><strong><a href="{{ route('predmeti.pregled', $row->id) }}">{{ $row->ceo_broj_predmeta }}</a></strong></td>
        <td><strong>{{ $row->stranka_1 }}</strong></td>
        <td><strong>{{ $row->stranka_2 }}</strong></td>
        <td>{{ $row->sudbroj }}</td>
        <td>{{ $row->opis_kp }}</td>
        <td>{{ $row->opis_adresa }}</td>
        <td>{{ $row->vp_naziv }}</td>
        <td>{{ date('d.m.Y', strtotime($row->datum_tuzbe)) }}</td>
        <td><a class="btn btn-success btn-xs otvori_predmet" id="dugmePredmet" title="{{ $row->puno_ime }}" href="{{ route('predmeti.pregled', $row->id) }}"><i class="fa fa-eye"></i></a></td>
    </tr>
    @endforeach
@endif