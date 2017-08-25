<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#kolaps">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('pocetna') }}">
        <span><img alt="Правобранилаштво" src="{{url('/images/cekic.png')}}" style="height:32px;  width:32px"></span> Правобранилаштво Крагујевац</a>
        </div>

        <div class="collapse navbar-collapse" id="kolaps">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('predmeti') }}"> <i class="fa fa-archive fa-fw" style="color: #18BC9C"></i> Предмети</a></li>
                <li><a href="{{ route('rocista.kalendar') }}"> <i class="fa fa-calendar fa-fw" style="color: #18BC9C"></i> Календар</a></li>
                <li><a href="{{ route('rocista') }}"> <i class="fa fa-hourglass-end fa-fw" style="color: #18BC9C"></i> Рочишта</a></li>
                <li><a href="#"> <i class="fa fa-money fa-fw" style="color: #18BC9C"></i> Ток новца</a></li>
                <li><a href="#"> <i class="fa fa-print fa-fw" style="color: #18BC9C"></i> Извештаји</a></li>
                @if (Gate::allows('admin'))
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="fa fa-user-secret fa-fw" style="color: #18BC9C"></i>  Администрирање<span class="caret">
                    </a>
                    <ul class="dropdown-menu" role="menu">
                            <li role="separator" class="divider"></li>
                            <li class="list-group-item-info"><a href="#"><i class="fa fa-user"></i> Корисници</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('korisnici') }}">Корисници</a></li>
                            <li><a href="{{ route('referenti') }}">Референти</a></li>
                            <li role="separator" class="divider"></li>
                            <li class="list-group-item-info"><a href="#"><i class="fa fa-cog"></i> Шифарници</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('sudovi') }}">Судови</a></li>
                            <li><a href="{{ route('vrste_predmeta') }}">Врсте предмета</a></li>
                            <li><a href="{{route('vrste_upisnika')}}">Врсте уписника</a></li>
                            <li><a href="{{ route('uprave') }}">Грдаске управе</a></li>
                            <li><a href="#">Статуси</a></li>
                            <li><a href="#">Типови рочишта</a></li>
                    </ul>
                </li>
                @endif
                <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out" style="color: #18BC9C"></i> Одјављивање
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                </li>

            </ul>
        </div>
    </div>
</nav>