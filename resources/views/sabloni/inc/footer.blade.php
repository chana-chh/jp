<div class="chh-footer ne_stampaj">
	<div class="container-fluid">
		<p class="pull-left">Copyright &copy; МИГ {{ date('Y', time()) }}</p>
		<p class="pull-right text-info">Корисник: <strong>{{ Auth::user() ? Auth::user()->name : 'Гост' }}</strong></p>
		@if(Auth::user())
		@if(Auth::user()->id == 2)
		<a href="https://www.youtube.com/watch?v=mFOJXCRXpZE" class="heart" title="Attraversiamo!"><i class="fa fa-heart-o fa-fw"></i></a>
		@endif
		@endif
	</div>
</div>
