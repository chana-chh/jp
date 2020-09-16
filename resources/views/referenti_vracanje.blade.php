@extends('sabloni.app')

@section('naziv', 'Враћање претходном референту')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">Враћање претходном референту</h1>
@endsection

@section('sadrzaj')
  @if($predmeti->isEmpty())
            <h3 class="text-danger">Тренутно нема ставки</h3>
        @else
            <table class="table table-striped tabelaPredRef" name="tabelaPredRef" id="tabelaPredRef">
                <thead>
                      <th style="width: 10%;">#</th>
                      <th style="width: 30%;">Број предмета</th>
                      <th style="width: 25%;">Стари референт</th>
                      <th style="width: 25%;">Нови референт</th>
                      <th style="width: 10%; text-align:center"><i class="fa fa-cogs"></i></th>
                </thead>
                <tbody id="statusi_lista" name="statusi_lista">
                @foreach ($predmeti as $predmet)
                        <tr>
                                <td>{{$predmet->id}}</td>
                                <td><strong>{{$predmet->broj()}}</strong></td>
                                @foreach ($referenti as $r)
                                    @if($r->id == $predmet->servisno)
                                    <td>{{$r->ime}} {{$r->prezime}}</td>
                                    @endif
                                @endforeach
                                <td>{{$predmet->referent->imePrezime()}}</td>
                                <td style="text-align:center">
                                 <a class="btn btn-success btn-sm" id="dugmePregled"  href="{{ route('predmeti.pregled', $predmet->id) }}"><i class="fa fa-eye"></i></a>
                                </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        
@endsection

@section('traka')
<h3 >Враћање претходном референту</h3>
<hr>
<div class="well">
    <form action="{{route('referenti.post_vracanje')}}" method="POST" data-parsley-validate>
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('referent_vracanje') ? ' has-error' : '' }}">
            <label for="referent_vracanje">Референт коме враћамо предмете (у табели стари референт):</label>
            <select name="referent_vracanje" id="referent_vracanje" class="chosen-select form-control" data-placeholder="Референт" required>
                <option value=""></option>
                @foreach($referenti as $referent)
                <option value="{{ $referent->id }}"{{ old('referent_vracanje') == $referent->id ? ' selected' : '' }}>
                        {{ $referent->ime }} {{ $referent->prezime }}
            </option>
            @endforeach
        </select>
        @if ($errors->has('referent_vracanje'))
        <span class="help-block">
            <strong>{{ $errors->first('referent_vracanje') }}</strong>
        </span>
        @endif
    </div>
            <div class="row dugmici">
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="form-group">
                    <div class="col-md-6 snimi">
                        <button type="submit" class="btn btn-success btn-block ono">
                            <i class="fa fa-retweet"></i>&emsp;Врати
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-danger btn-block ono" href="{{route('referenti.vracanje')}}">
                            <i class="fa fa-ban"></i>&emsp;Откажи
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('skripte')
<script>
$( document ).ready(function() {

        $('#tabelaPredRef').DataTable({

        columnDefs: [{ orderable: false, searchable: false, "targets": -1 }],
        language: {
        search: "Пронађи у табели",
            paginate: {
            first:      "Прва",
            previous:   "Претходна",
            next:       "Следећа",
            last:       "Последња"
        },
        processing:   "Процесирање у току ...",
        lengthMenu:   "Прикажи _MENU_ елемената",
        zeroRecords:  "Није пронађен ниједан запис за задати критеријум",
        info:         "Приказ _START_ до _END_ од укупно _TOTAL_ елемената",
        infoFiltered: "(филтрирано од _MAX_ елемената)",
    },
    });

});
</script>
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection