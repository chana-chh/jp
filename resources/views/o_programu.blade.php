@extends('sabloni.app')

@section('naziv', 'О програму')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row">
    <div class="col-md-10">
        <h1>
            O програму
        </h1>
        <h3>Овај програм је настао како би се помогло у свакодневном раду Градског правобранилаштва и то нарочито у вези  олакшаног, доступнијег, савременијег и ефикаснијег обављања редовних активности прописаних законом, а у вези вођења евиденције предмета, праћења новца и распореда рокова и рочишта</h3>
    </div>

</div>
<hr>



@endsection

@section('skripte')
{{-- <script src="{{asset('/js/jquery.snowfall.js')}}"></script>
<script>
	$(document).ready(function () {
		$.snowfall.start({
				size: {
					min: 10,
					max: 20
				},
				color: '#95A5A6',
				content: '<i class="fa fa-snowflake-o"></i>',
			
		});
	});
</script> --}}
@endsection