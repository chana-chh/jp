<div class="chh-footer ne_stampaj">
	<div class="container-fluid">
		<p class="pull-left">Copyright &copy; Чана и Сташа {{ date('Y', time()) }}</p>
		<p class="pull-right text-info">Корисник: <strong>{{ Auth::user() ? Auth::user()->name : 'Гост' }}</strong></p>
	</div>
</div>
