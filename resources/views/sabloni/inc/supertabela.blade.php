@if(count($podaci) === 0)
<tr>
    <td colspan="11">
        <h3 class="text-warning text-center">Нема резултата за задате критеријуме.</h3>
    </td>
</tr>
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
        <td>{{ $row->opis_predmeta }}</td>
        <td>{{ $row->sudbroj }}</td>
        <td>{{ $row->opis_kp }}</td>
        <td>{{ $row->opis_adresa }}</td>
        <td>{{ $row->vp_naziv }}</td>
        <td>{{ date('d.m.Y', strtotime($row->datum_tuzbe)) }}</td>
        <td><a class="btn btn-success btn-xs otvori_predmet" id="dugmePredmet" title="{{ $row->puno_ime }}" href="{{ route('predmeti.pregled', $row->id) }}"><i class="fa fa-eye"></i></a></td>
    </tr>
    @endforeach
    <tr height="30px"></tr>
    <tr id="linkovi" name="linkovi" style="background-color: #ffff !important; color: #2C3E50">
        <td colspan="5">
            {!! $linkovi['buttons'] !!}
        </td>
        <td colspan="2">
            <div class="col-md-6" style="margin-top: 20px">
                Иди на страну:
            </div>
            <div class="col-md-6" style="margin-top: 10px">
                {!! $linkovi['select'] !!}
            </div>
        </td>
        <td colspan="4" class="text-right" style="padding: 20px">
            <p>
                Приказани редови од
                <em>{{ $linkovi['row_from'] }}</em> до
                <em>{{ $linkovi['row_to'] }}</em> од укупно
                <em>{{ $linkovi['total_rows'] }}</em>
            </p>
        </td>
    </tr>
@endif