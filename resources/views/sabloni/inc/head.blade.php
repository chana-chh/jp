<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="csrf-token" content="{!! csrf_token() !!}">

<title>Јавно правобранилаштво | @yield('naziv')</title>


<link href="{{ url('/favicon.ico') }}" rel="icon">
@include('sabloni.inc.styles')
@yield('stilovi')

<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>