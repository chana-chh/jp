@if(count($podaci) === 0)
<h2 class="text-warning text-center">Нема резултата за задате критеријуме.</h3>
@else
<thead>
    <tr>
        <th style="width: 3%; cursor: pointer" class="sorting" data-sorting_type="asc" data-column_name="id">
            # <span id="id_icon"></span></th>
        <th style="width: 7%; cursor: pointer" class="sorting" data-sorting_type="asc" data-column_name="st_naziv">
            Статус <span id="st_naziv_icon"></span></th>
        <th style="width: 8%; cursor: pointer" class="sorting" data-sorting_type="asc" data-column_name="ceo_broj_predmeta">
            Број <span id="ceo_broj_predmeta_icon"></span></th>
        <th style="width: 18%; cursor: pointer" class="sorting" data-sorting_type="asc" data-column_name="stranka_1">
            Тужилац <span id="stranka_1_icon"></span></th>
        <th style="width: 18%; cursor: pointer" class="sorting" data-sorting_type="asc" data-column_name="stranka_2">
            Тужени <span id="stranka_2_icon"></span></th>
        <th style="width: 9%; cursor: pointer" class="sorting" data-sorting_type="asc" data-column_name="sudbroj">
            Надлежни орган бр. <span id="sudbroj_icon"></span></th>
        <th style="width: 7%; cursor: pointer" class="sorting" data-sorting_type="asc" data-column_name="opis_kp">
            КП <span id="opis_kp_icon"></span></th>
        <th style="width: 8%; cursor: pointer" class="sorting" data-sorting_type="asc" data-column_name="opis_adresa">
            Адреса <span id="opis_adresa_icon"></span></th>
        <th style="width: 14%; cursor: pointer" class="sorting" data-sorting_type="asc" data-column_name="vp_naziv">
            Врста предмета <span id="vp_naziv_icon"></span></th>
        <th style="width: 5%; cursor: pointer" class="sorting" data-sorting_type="asc" data-column_name="datum_tuzbe">
            Датум <span id="datum_tuzbe_icon"></span></th>
        <th style="width: 3%"><i class="fa fa-cogs"></i></th>
    </tr>
</thead>
<tbody>
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
</tbody>
<tfoot id="linkovi">
    <tr height="30px"></tr>
    <tr>
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
</tfoot>
@endif