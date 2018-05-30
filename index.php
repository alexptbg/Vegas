<!DOCTYPE html>
<html lang="en">
<?php
$wlan = shell_exec("scripts/wlan.sh");
if (empty($wlan)) { $wlan = "::1"; }
$eth = shell_exec("scripts/eth.sh");
if (empty($eth)) { $eth = "::1"; }
//options
$dir = "./slider/";
$shuffle = "true";
$duration = "6000";
$vegas_overlay = "false";
$first_image = "img/splash.png";
$first_image_status = "true";//true uses slider first image for background || false uses splash image for background
//init
$dirs = array_diff(scandir($dir),array('..', '.'));
$file_display = array('jpg','jpeg','JPG','JPEG','mp4','MP4');
$dir_contents = scandir($dir);
if(!empty($dir_contents)) {
  $z=0;
  $i=0;
  $v=0;
  foreach ($dir_contents as $file) {
    $ext = explode('.',$file);
    $extension = $ext[1];
    $file_type = strtolower($extension);
    if ($file_type == 'mp4' || $file_type == 'MP4') {
      $v++;
      if ($file !== '.' && $file !== '..' && in_array($file_type,$file_display) == true) {      	
      	$without_ext = explode('.',$file);
      	//get video data from text file (format = [duration offset]) 
        $f = fopen($dir.$without_ext[0].'.txt','r');
        $line = fgets($f);
        fclose($f);
        $tempo = explode(' ',$line);
        $string = "{ src: '".$dir.$without_ext[0].".png', delay: ".($tempo[0]-$tempo[1])."000, cover: true, video: [ '".$dir.$file."'";
        if (file_exists($dir.$without_ext[0].".ogv")) {
        	$string .= ", '".$dir.$without_ext[0].".ogv'";
        }
        if (file_exists($dir.$without_ext[0].".webm")) {
        	$string .= ", '".$dir.$without_ext[0].".webm'";
        }
        $string .= " ], loop: false, mute: false }";
        $paths[] = $string;
      }
    } else {
      if ($file !== '.' && $file !== '..' && in_array($file_type,$file_display) == true) {
      	$z++;
      	$i++;
        $paths[] = "{ src: '".$dir.$file."', delay: ".$duration.", cover: true }";
        if ($first_image_status == "true") {
		  if ($z==1) { $first_image = $dir.$file; }	
		}
      }
    }
  }
  if((!empty($paths)) && ($shuffle == "true")) {
    shuffle($paths);	
  }
  //$slides = "".implode(", ", $paths)."";
}
?>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no" />
  <title>VEGAS SLIDESHOW</title>
  <!-- Favicon -->
  <link rel="icon" href="ico/f32x32.png" sizes="32x32" type="image/png" />
  <link rel="icon" href="ico/f48x48.png" sizes="48x48" type="image/png" />
  <link rel="icon" href="ico/f64x64.png" sizes="64x64" type="image/png" />
  <link rel="icon" href="ico/f72x72.png" sizes="72x72" type="image/png" />
  <link rel="icon" href="ico/f96x96.png" sizes="96x96" type="image/png" />
  <link rel="icon" href="ico/f114x114.png" sizes="114x114" type="image/png" />
  <link rel="icon" href="ico/f128x128.png" sizes="128x128" type="image/png" />
  <link rel="icon" href="ico/f144x144.png" sizes="144x144" type="image/png" />
  <link rel="icon" href="ico/f192x192.png" sizes="192x192" type="image/png" />
  <link rel="icon" href="ico/f256x256.png" sizes="256x256" type="image/png" />
  <!-- css files -->
  <link type="text/css" rel="stylesheet" href="css/font-awesome.min.css" />
  <link type="text/css" rel="stylesheet" href="css/vegas.min.css" />
  <link type="text/css" rel="stylesheet" href="css/alex.css" />
</head>
<body<?php if ($first_image_status == "true") { echo " style=\"background-image:url('".$first_image."') !important;\""; } ?>>
    <div id="wrapper">
      <div class="controls">
        <button id="start" type="button"><i class="fa fa-eject" aria-hidden="true"></i></button>
        <button id="play" type="button"><i class="fa fa-play" aria-hidden="true"></i></button> 
        <button id="prev" type="button"><i class="fa fa-step-backward" aria-hidden="true"></i></button> 
        <button id="next" type="button"><i class="fa fa-step-forward" aria-hidden="true"></i></button>
        <button id="pause" type="button"><i class="fa fa-pause" aria-hidden="true"></i></button>
        <button id="stop" type="button"><i class="fa fa-power-off" aria-hidden="true"></i></button>
        <button id="shuffle" type="button"><i class="fa fa-random" aria-hidden="true"></i></button>
        <button id="refresh" type="button"><i class="fa fa-refresh" aria-hidden="true"></i></button>
        <button id="reboot" type="button"><i class="fa fa-retweet" aria-hidden="true"></i></button>
      </div>
      <div class="info">
        <button id="close" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
        <p>WLAN address:&nbsp;<?php echo $wlan; ?></p>
        <p>ETH address:&nbsp;<?php echo $eth; ?></p>
        <p>Videos:&nbsp;<?php echo $v; ?></p>
        <p>Images:&nbsp;<?php echo $i; ?></p>
      </div>
    </div>
    <script type="text/javascript" src="js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="js/vegas.min.js"></script>
    <script type="text/javascript" src="js/sketch.min.js"></script>
    <script type="text/javascript" src="js/sketch.app.js"></script>
    <script type="text/javascript">
	$('html').addClass('animated');
	var $body = $('body');
    function slider() {
      var $body = $('body');
      var backgrounds = [<?=implode(", ", $paths)?>];
      $body.vegas({
        preload: true,
        <?php
        if($vegas_overlay == "true") {
		  echo "overlay: 'overlays/08.png',";	
		}
		?>
        transitionDuration: 1500,
        firstTransitionDuration: 5000,
        cover: true,
        //transition: [ 'fade', 'zoomOut', 'swirlLeft' ],
        transition: [ 'slideLeft2','slideUp2','slideRight2','slideDown2' ],
        //animation: [ 'kenburnsLeft','kenburnsUp','kenburnsRight','kenburnsDown' ],
        //animation: ['kenburns'],
        //delay: 5000,
        slides: backgrounds,
        shuffle: <?php echo $shuffle; ?>/*,
        walk: function (nb, settings) {
          if (settings.video) {
            $('.logo').addClass('collapsed');
          } else {
            $('.logo').removeClass('collapsed');
          }
        }
        */
      });
    }
    slider();
    $(function() {
      $('body').mouseover(function(){
        $(this).css({cursor: 'none'});
      });
      $('.controls button').mouseover(function(){
        $(this).css({cursor: 'none'});
      });
      /*
      $('body').click(function(e){
	    e.preventDefault();
        return false;
      });
      */
      //116 = F5
      $('body').keypress(function(e){
        if (e.keyCode == 116) {
	      //console.log("F5");
	    } else {
	      e.preventDefault();
	      return false;
	    }
      });
      $('body').bind("mousewheel",function() {
        return false;
      });
      /*
      $('body').on("contextmenu",function(){
        return false;
      });
      */  
      $('body').attr('unselectable','on')
        .css({'-moz-user-select':'-moz-none',
          '-moz-user-select':'none',
          '-o-user-select':'none',
          '-khtml-user-select':'none',
          '-webkit-user-select':'none',
          '-ms-user-select':'none',
          'user-select':'none'
        }).bind('selectstart', function(){ 
          return false; 
      });
      //next
      $("button#start").attr("disabled",true);
      //buttons
      $('#start').click(function(x) {
        x.preventDefault();
        $body.removeClass();
        <?php if ($first_image_status == "true") { 
            echo "\$body.css(\"backgroundImage\",\"url('".$first_image."')\");\r\n";
          } else {
		  	echo "\$body.css(\"backgroundImage\",\"url('img/splash.png')\");\r\n";
		  }
        ?>
        console.log('start');
        slider();
        $("button#start").attr("disabled",true);
      });
      $('#play').click(function(x) {
        x.preventDefault();
        console.log('play');
        $body.vegas('play');
      });
      $('#next').click(function(x) {
        x.preventDefault();
        console.log('next');
        $body.vegas('next');
      });
      $('#prev').click(function(x) {
        x.preventDefault();
        console.log('previous');
        $body.vegas('previous');
      });
      $('#pause').click(function(x) {
        x.preventDefault();
        console.log('pause');
        $body.vegas('pause');
      });
      $('#stop').click(function(x) {
        x.preventDefault();
        console.log('destroy');
        $body.css('backgroundImage','none');
        $body.vegas('destroy');
        $body.addClass("standby");
        $("button#start").removeAttr("disabled");
      });
      $('#shuffle').click(function(x) {
        x.preventDefault();
        console.log('shuffle');
        $body.vegas('shuffle');
      });
      $('#refresh').click(function(x) {
        x.preventDefault();
        console.log('refresh');
        window.location.reload(true);
      });
      var funcs = [
        function one() { $('button#reboot').attr('class', 'orange'); },
        function two() { $('button#reboot').attr('class', 'red'); },
        function three() { 
          $.ajax({
            url: 'scripts/reboot.php',
            dataType: 'json',
            type: 'get',
            contentType: 'application/json',
            success: function(data,textStatus,jQxhr){
              console.log(data);
            },
            error: function(jqXhr,textStatus,errorThrown){
              console.log(errorThrown);
            }
          });
        }
      ];
      $('#reboot').data('counter',0).click(function(x) {
  	    x.preventDefault();
  	    console.log('reboot');
        var counter = $(this).data('counter');
        funcs[counter]();
        $(this).data('counter', counter < funcs.length-1 ? ++counter : 0);
      });
      $('body').contextmenu(function(x) {
      	x.preventDefault();
      	$(".info").show();
      });
      $('#close').click(function(x) {
        x.preventDefault();
        $(".info").hide();
      });
      var touchs = [
        function one() { },
        function two() { },
        function three() { 
          console.log("do something here later");
        }
      ];
      $('canvas').data('counter',0).click(function(x) {
        //console.log(x.target);
        var counter = $(this).data('counter');
        touchs[counter]();
        $(this).data('counter', counter < touchs.length-1 ? ++counter : 0);
        /*
        if ($(x.target).hasClass('vegas-container')) {
          x.preventDefault();
    	  console.log("yes");
        }
        */
      });
    });
    </script>
</body>
</html>
