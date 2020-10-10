@extends('sabloni.app_predmeti')

@section('naziv', 'Предмети')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row">
    <div class="col-md-6">
        <h1>
            <img class="slicica_animirana" alt="предмети" src="{{url('/images/predmeti.png')}}" style="height:64px;">
            &emsp;Предмети <small><em>(укључујући и архивиране)</em></small>
        </h1>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <button id="pretragaDugme" class="btn btn-success btn-block ono">
            <i class="fa fa-search fa-fw"></i> Напредна претрага
        </button>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a class="btn btn-primary btn-block ono" href="{{ route('predmeti.dodavanje.get') }}">
            <i class="fa fa-plus-circle fa-fw"></i> Нови предмет
        </a>
    </div>
    @if(Auth::user()->id == 1 || Auth::user()->id == 2)
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a class="btn btn-warning btn-block ono" href="{{ route('predmeti.serija.get') }}">
            <i class="fa fa-indent fa-fw"></i> Нови предмети у серији
        </a>
    </div>
    @endif
</div>
<hr>
<div id="pretraga_div" class="well" style="display: none;">
    <form id="pretraga" action="{{ route('predmeti.pretraga') }}" method="POST">
        {{ csrf_field() }}
        <div class="row">
            <div class="form-group col-md-3">
                <label for="arhiviran">Архива</label>
                <select name="arhiviran" id="arhiviran" class="chosen-select form-control" data-placeholder="Архива">
                    <option value=""></option>
                    <option value="0">Активни</option>
                    <option value="1">Архивирани</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="vrsta_upisnika_id">Врста уписника</label>
                <select name="vrsta_upisnika_id" id="vrsta_upisnika_id" class="chosen-select form-control" data-placeholder="Врста уписника">
                    <option value=""></option>
                    @foreach($upisnici as $upisnik)
                    <option value="{{ $upisnik->id }}">
                        <strong>{{ $upisnik->naziv }}</strong>
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="broj_predmeta">Број предмета</label>
                <input type="number" min="1" step="1" name="broj_predmeta" id="broj_predmeta" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label for="broj_predmeta_sud">Број предмета надлежног органа</label>
                <input type="text" maxlen="50" name="broj_predmeta_sud" id="broj_predmeta_sud" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label for="godina_predmeta">Година предмета</label>
                <input type="number" min="1900" step="1" name="godina_predmeta" id="godina_predmeta" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                <label for="sud_id">Надлежни орган</label>
                <select name="sud_id" id="sud_id" class="chosen-select form-control" data-placeholder="Надлежни орган">
                    <option value=""></option>
                    @foreach($sudovi as $sud)
                    <option value="{{ $sud->id }}">
                        {{ $sud->naziv }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="vrsta_predmeta_id">Врста предмета</label>
                <select name="vrsta_predmeta_id" id="vrsta_predmeta_id" class="chosen-select form-control" data-placeholder="Врста предмета">
                    <option value=""></option>
                    @foreach($vrste as $vrsta)
                    <option value="{{ $vrsta->id }}">
                        {{ $vrsta->naziv }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="referent_id">Референт</label>
                <select name="referent_id" id="referent_id" class="chosen-select form-control" data-placeholder="Референт">
                    <option value=""></option>
                    @foreach($referenti as $referent)
                    <option value="{{ $referent->id }}">
                        {{ $referent->imePrezime() }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="vrednost_tuzbe">Вредност</label>
                <input type="number" min="0" step="0.01" name="vrednost_tuzbe" id="vrednost_tuzbe" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="stranka_1">Тужилац</label>
                <input type="text" maxlen="255" name="stranka_1" id="stranka_1" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label for="stranka_2">Тужени</label>
                <input type="text" maxlen="255" name="stranka_2" id="stranka_2" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="sudija">Судија</label>
                <input type="text" maxlen="255" name="sudija" id="sudija" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label for="sudnica">Судница</label>
                <input type="text" maxlen="255" name="sudnica" id="sudnica" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label for="advokat">Адвокат</label>
                <input type="text" maxlen="255" name="advokat" id="advokat" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="opis_kp">Катастарска парцела</label>
                <input type="text" maxlen="255" name="opis_kp" id="opis_kp" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label for="opis_adresa">Адреса</label>
                <input type="text" maxlen="255" name="opis_adresa" id="opis_adresa" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="opis">Опис предмета</label>
                <textarea name="opis" id="opis" class="form-control"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="stari_broj_predmeta">Стари број предмета:</label>
                <input type="text" maxlen="50" name="stari_broj_predmeta" id="stari_broj_predmeta" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label for="opis">Датум 1</label>
                <input type="date" name="datum_1" id="datum_1" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label for="opis">Датум 2</label>
                <input type="date" name="datum_2" id="datum_2" class="form-control" readonly>
            </div>
            <div class="col-md-4">
                <label class="text-warning">Напомена</label>
                <p class="text-warning">
                    Ако се унесе само први датум претрага ће се вршити за предмете са тим датумом. Ако се унесу оба датума претрага ће се вршити за предмете између та два датума.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="napomena">Напомена</label>
                <textarea name="napomena" id="napomena" class="form-control"></textarea>
            </div>
        </div>
    </form>
    <div class="row dugmici">
        <div class="col-md-6 col-md-offset-6">
            <div class="form-group text-right ceo_dva">
                <div class="col-md-6 snimi">
                    <button type="submit" id="dugme_pretrazi" class="btn btn-success btn-block"><i class="fa fa-search"></i>&emsp;Претражи</button>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-info btn-block" href="{{ route('predmeti') }}"><i class="fa fa-ban"></i>&emsp;Откажи</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10">
        <div class="text-left">
            <span>Прикажи </span>
            <select name="postrani" id="postrani">
                <option value=""> *</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="300">300</option>
            </select>
            <span> редова по страни </span>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group text-right">
            <input type="text" name="serach" id="serach" class="form-control" />
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-condensed">
              <thead>
    <tr>
        <th style="width: 3%; cursor: pointer" class="sorting" data-sorting_type="desc" data-column_name="id">
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
<tbody name="tabelaPredmeti" id="tabelaPredmeti">
  @include('sabloni.inc.supertabela')
</tbody>
            </table>
            <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
            <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
            <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
            <input type="hidden" name="hidden_po_stranici" id="hidden_po_stranici" value="10" />
        </div>
    </div>
</div>

@endsection
@section('skripte')
<script type="text/javascript">
    $(document).ready(function() {

        var page = 1;

        function odlozi(callback, ms) {
          var timer = 0;
          return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
              callback.apply(context, args);
            }, ms || 0);
          };
        }

        $('.chosen-select').chosen({
            allow_single_deselect: true,
            search_contains: true
        });

        function resizeChosen() {
            $(".chosen-container").each(function() {
                $(this).attr('style', 'width: 100%');
            });
        }

        $('#datum_1').on('change', function() {
            if (this.value !== '') {
                $('#datum_2').prop('readonly', false);
            } else {
                $('#datum_2').prop('readonly', true).val('');
            }
        });

        $('#pretragaDugme').click(function() {
            $('#pretraga_div').toggle();
            resizeChosen();
        });

        $('#dugme_pretrazi').click(function() {
            $('#pretraga').submit();
        });

        function clear_icon() {
            $('#id_icon').html('');
            $('#st_naziv_icon').html('');
            $('#ceo_broj_predmeta_icon').html('');
            $('#stranka_1_icon').html('');
            $('#stranka_2_icon').html('');
            $('#sudbroj_icon').html('');
            $('#opis_kp_icon').html('');
            $('#opis_adresa_icon').html('');
            $('#vp_naziv_icon').html('');
            $('#datum_tuzbe_icon').html('');
        }

        $('#postrani').on('change', function() {
            if (this.value !== '') {
                var param = $('#serach').val();
                var column_name = $('#hidden_column_name').val();
                var sort_type = $('#hidden_sort_type').val();

                $('#hidden_po_stranici').val(this.value);
                fetch_data(page, param, column_name, sort_type, this.value);
            }
        });

        function fetch_data(page, param, sortiraj_kolona, sortiraj_tip, redova_postranici) {

            if (typeof(page) == "undefined") {
                page = 1;
            }

            if (typeof redova_postranici === "undefined" || redova_postranici === null) { 
                redova_postranici = 10; 
            }

            $.ajax({
                type: "GET",
                data: {
                    "page": page,
                    "param": param,
                    "sortiraj_kolona": sortiraj_kolona,
                    "sortiraj_tip": sortiraj_tip,
                    "redova_postranici": redova_postranici
                },
                url: "{{ route('predmeti.superajax') }}",
                success: function(redovi) {
                    $('#tabelaPredmeti').html('');
                    $('#tabelaPredmeti').html(redovi);
                }
            })
        }

        $('#serach').keyup(odlozi(function (e) {
          var param = $('#serach').val();
          var column_name = $('#hidden_column_name').val();
          var sort_type = $('#hidden_sort_type').val();
          fetch_data(page, param, column_name, sort_type);
        }, 1200));

        $(document).on('click', '.sorting', function() {
            clear_icon();
            var column_name = $(this).data('column_name');
            var order_type = $(this).data('sorting_type');
            var reverse_order = '';
            if (order_type == 'asc') {
                $(this).data('sorting_type', 'desc');
                reverse_order = 'desc';
                clear_icon();
                $('#' + column_name + '_icon').html('<span><i class="fa fa-sort-amount-desc" aria-hidden="true"></i></span>');
            }
            if (order_type == 'desc') {
                $(this).data('sorting_type', 'asc');
                reverse_order = 'asc';
                clear_icon();
                $('#' + column_name + '_icon').html('<span><i class="fa fa-sort-amount-asc" aria-hidden="true"></i></span>');
            }
            $('#hidden_column_name').val(column_name);
            $('#hidden_sort_type').val(reverse_order);
            var param = $('#serach').val();
            var postrani = $('#hidden_po_stranici').val();
            fetch_data(page, param, column_name, reverse_order, postrani);
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var param = $('#serach').val();
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var postrani = $('#hidden_po_stranici').val();
            $('#hidden_page').val(page);
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var param = $('#serach').val();
            $('li').removeClass('active');
            $(this).parent().addClass('active');
            fetch_data(page, param, column_name, sort_type, postrani);
        });

        $(document).on('change', '#pgn-goto', function() {
            var page = $(this).find("option:selected").text();
            var param = $('#serach').val();
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var postrani = $('#hidden_po_stranici').val();
            fetch_data(page, param, column_name, sort_type, postrani);
        });
    });
</script>
@endsection
