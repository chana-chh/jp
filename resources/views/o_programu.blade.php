@extends('sabloni.app')

@section('naziv', 'О програму')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row">
    <div class="col-md-10">
        <h1>
            О програму<small><em>(кад јагањци утихну)</em></small>
        </h1>
        <p>... врат, врата, о с, грбача, знаш на шта мислим ...</p>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <button id="ponovo" class="btn btn-success btn-block ono" onClick="window.location.reload()">
            <i class="fa fa-refresh fa-fw"></i> Среди јаге, поново!
        </button>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">

</div>
</div>
<div class="row">
    <div class="col-md-12">
        <div id="container">
  Среди 10 јагањаца, што брже можеш!
  <div id="playground">
    <div id="start"><img alt="судија" src="{{url('/images/sudija.jpg')}}" style="height:50px"></div>
    <div id="startGame"><img alt="судија" src="{{url('/images/sudija.jpg')}}" style="height:50px"></div>
    <div id="win"><img alt="јага" src="{{url('/images/jaga.jpg')}}" style="height:32px"></div>
  </div>
  <div id="endScreen">
    Победа! Број јагањаца у печењари<br />
    <p id="endCount">1</p> за
    <p id="endSeconds">1</p> секунди <br />
  </div>
  <div id="counter">Погоци: <span></span> </div>
  <div id="timer">Време: <span>0</span>s </div>
</div>
    </div>
</div>


@endsection

@section('skripte')
<script>
 $(document).ready(function() {
 	var counter = 0;
var seconds = 0;
$('#counter span').html(counter);
$('#timer span').html(seconds);

$('#start').hide();
$('#win').hide();
$('#endScreen').hide();

$('#startGame').on( "mouseover", function() {
  $(this).hide();
  
  var randWidth = random = Math.ceil(Math.random() * 350);
  var randHeight = random = Math.ceil(Math.random() * 350);
  
  $('#win').show('fast');
  $('#win').css('top', randHeight);
  $('#win').css('left', randWidth);
  
   window.setInterval(function(){
      seconds = seconds + 1;
      $('#timer span').html(seconds);
    }, 1000); 
});

$('#start').on( "mouseover", function() {
  
  var randWidth = random = Math.ceil(Math.random() * 350);
  var randHeight = random = Math.ceil(Math.random() * 350);
  
  $('#win').show('fast');
  $('#win').css('top', randHeight);
  $('#win').css('left', randWidth);
  $(this).hide('fast');
});

$('#win').on( "mouseover", function() {
  counter = counter + 1;
  $('#counter span').html(counter);
  
  if(counter == 10){
  $('#endScreen').show('medium');
    $('#endCount').html(counter);
    $('#endSeconds').html(seconds);
  }
  
  $(this).hide('fast');
  $('#start').show('fast');
  
});

});
</script>
@endsection