@extends('sabloni.app')

@section('naziv', 'Предмети')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">
        <span><img alt="предмети" src="{{url('/images/predmeti.png')}}" style="height:64px"></span>
        Додавање новог предмета
    </h1>

    <form action="{{ route('predmeti.dodavanje.post') }}" method="POST">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-4">
                1
            </div>
            <div class="col-md-4">
                2
            </div>
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('tip_id') ? ' has-error' : '' }}">
                    <label for="tip_id">Типови рочишта:</label>
                    <select name="tip_id" id="tip_id" class="chosen-select form-control" data-placeholder="Тип рочишта">
                        <option value=""></option>
                        @foreach($tipovi_rocista as $tip)
                        <option value="{{ $tip->id }}"{{ old('tip_id') == $tip->id ? ' selected' : '' }}>
                            <strong>{{ $tip->naziv }}</strong>
                        </option>
                        @endforeach
                    </select>
                    @if ($errors->has('tip_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('tip_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <input type="submit" value="IDI">
    </form>

@endsection

@section('skripte')
{{--  <script>
$( document ).ready(function() {
    $('#tabelaPredmeti').DataTable({
        language: {
            search: "Пронађи у табели",
            paginate: {
                first:      "Прва",
                previous:   "Претходна",
                next:       "Следећа",
                last:       "Последња"
            },
            processing:   "Процесирање у току...",
            lengthMenu:   "Прикажи _MENU_ елемената",
            zeroRecords:  "Није пронађен ниједан запис",
            info:         "Приказ _START_ до _END_ од укупно _TOTAL_ елемената",
            infoFiltered: "(filtrirano од укупно _MAX_ елемената)",
            responsive: true
        }
    });
});
</script>  --}}
@endsection