@if(Session::has('uspeh'))
<div class="alert alert-success fade in text-center" role="alert">
 	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  	{{ Session::get('uspeh') }}
</div>
@endif

@if(Session::has('info'))
<div class="alert alert-info fade in text-center" role="alert">
 	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  	{{ Session::get('info') }}
</div>
@endif

@if(Session::has('upozorenje'))
<div class="alert alert-warning fade in text-center" role="alert">
 	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  	{{ Session::get('upozorenje') }}
</div>
@endif

@if(Session::has('greska'))
<div class="alert alert-danger fade in text-center" role="alert">
 	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  	{{ Session::get('greska') }}
</div>
@endif

@if(count($errors) > 0)
<div class="alert alert-danger fade in text-center" role="alert">
 	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
 	<strong>Greške:</strong>
 	<ul>
  	@foreach($errors->all() as $error)
		<li>{{ $error }}</li>
  	@endforeach
  	</ul>
</div>
@endif