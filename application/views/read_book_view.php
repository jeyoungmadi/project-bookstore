<!doctype html>
<html lang="en">
<head>
<title>Read BOOk</title>
<meta name="viewport" content="width = 1050, user-scalable = no" />
<link rel="icon" type="image/png" href="<?php echo base_url('turnjs4/pics/favicon.png')?>" />
<script type="text/javascript" src="<?php echo base_url('turnjs4/extras/jquery.min.1.7.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('turnjs4/extras/jquery-ui-1.8.20.custom.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('turnjs4/extras/modernizr.2.5.3.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('turnjs4/lib/hash.js')?>"></script>

  <!-- Bootstrap CSS File -->
  <link href="<?php echo base_url('assets/lib/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
</head>
<body>
	<div id="canvas" class="canvas">	
		<p id="pageSize" data-book="<?php echo $pages[0]['book_ID'];?>" data-size="<?php echo sizeof($pages);?>"></p>
		<a type="button" href="<?php echo base_url('index.php/BookDetailController/index?book_id='.$pages[0]['book_ID']);?>" class="btn btn-danger button-back">Exit</a>
		<div class="zoom-icon zoom-icon-in" style="border-style: solid;color:#ffffff"></div>   
		<div class="magazine-viewport" >
			<div class="container">
				<div class="magazine">
					<!-- Next button -->
					<div ignore="1" class="next-button"></div>
					<!-- Previous button -->
					<div ignore="1" class="previous-button"></div>
				</div>
			</div>
			<span class="page-number"></span>					
			<div class="bottom">
				<div id="slider-bar" class="turnjs-slider">
					<div id="slider"></div>
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">
var pathBook = $('#pageSize').data('book');
var pageNumber;
function loadApp() {

	$('#canvas').fadeIn(1000);

	var flipbook = $('.magazine');

	// Check if the CSS was already loaded
   
   if (flipbook.width()==0 || flipbook.height()==0) {
	   setTimeout(loadApp, 10);
	   return;
   }
   
   // Create the flipbook

   flipbook.turn({
		   
		   // Magazine width

		   width: 922,

		   // Magazine height

		   height: 600,

		   // Duration in millisecond

		   duration: 1000,

		   // Enables gradients

		   gradients: true,
		   
		   // Auto center this flipbook

		   autoCenter: true,

		   // Elevation from the edge of the flipbook when turning a page

		   elevation: 50,

		   // The number of pages

		   pages: $('#pageSize').data('size'),

		   // Events

		   when: {
			   turning: function(event, page, view) {
				   
				   var book = $(this),
				   currentPage = book.turn('page'),
				   pages = book.turn('pages');
		   
				   // Update the current URI

				   Hash.go('page/' + page).update();

				   // Show and hide navigation buttons
				   pageNumber = page;
				   disableControls(page);

			   },

			   turned: function(event, page, view) {
				   pageNumber = page;
				   disableControls(page);

				   $(this).turn('center');

				   $('#slider').slider('value', getViewNumber($(this), page));

				   if (page==1) { 
					   $(this).turn('peel', 'br');
				   }

			   },

			   missing: function (event, pages) {

				   // Add pages that aren't in the magazine

				   for (var i = 0; i < pages.length; i++)
					   addPage(pages[i], $(this), pathBook);

			   }
		   }

   });

   // Zoom.js

   $('.magazine-viewport').zoom({
	   flipbook: $('.magazine'),

	   max: function() { 
		   
		   return largeMagazineWidth()/$('.magazine').width();

	   }, 

	   when: {
		   swipeLeft: function() {

			   $(this).zoom('flipbook').turn('next');

		   },

		   swipeRight: function() {
			   
			   $(this).zoom('flipbook').turn('previous');

		   },

		   resize: function(event, scale, page, pageElement) {

			   if (scale==1)
				   loadSmallPage(page, pageElement, pathBook);
			   else
				   loadLargePage(page, pageElement, pathBook);

		   },
		   
		   zoomIn: function () {

			   $('#slider-bar').hide();
			   $('.made').hide();
			   $('.magazine').removeClass('animated').addClass('zoom-in');
			   $('.zoom-icon').removeClass('zoom-icon-in').addClass('zoom-icon-out');
			   
			   if (!window.escTip && !$.isTouch) {
				   escTip = true;

				   $('<div />', {'class': 'exit-message'}).
					   html('<div>Press ESC to exit</div>').
						   appendTo($('body')).
						   delay(2000).
						   animate({opacity:0}, 500, function() {
							   $(this).remove();
						   });
			   }
		   },

		   zoomOut: function () {

			   $('#slider-bar').fadeIn();
			   $('.exit-message').hide();
			   $('.made').fadeIn();
			   $('.zoom-icon').removeClass('zoom-icon-out').addClass('zoom-icon-in');

			   setTimeout(function(){
				   $('.magazine').addClass('animated').removeClass('zoom-in');
				   resizeViewport();
			   }, 0);

		   }
	   }
   });

   // Zoom event

   if ($.isTouch)
	   $('.magazine-viewport').bind('zoom.doubleTap', zoomTo);
   else
	   $('.magazine-viewport').bind('zoom.tap', zoomTo);


   // Using arrow keys to turn the page

   $(document).keydown(function(e){

	   var previous = 37, next = 39, esc = 27;

	   switch (e.keyCode) {
		   case previous:

			   // left arrow
			   $('.magazine').turn('previous');
			   e.preventDefault();

		   break;
		   case next:

			   //right arrow
			   $('.magazine').turn('next');
			   e.preventDefault();

		   break;
		   case esc:
			   
			   $('.magazine-viewport').zoom('zoomOut');	
			   e.preventDefault();

		   break;
	   }
   });

   // URIs - Format #/page/1 

   Hash.on('^page\/([0-9]*)$', {
	   yep: function(path, parts) {
		   var page = parts[1];

		   if (page!==undefined) {
			   if ($('.magazine').turn('is'))
				   $('.magazine').turn('page', page);
		   }

	   },
	   nop: function(path) {

		   if ($('.magazine').turn('is'))
			   $('.magazine').turn('page', 1);
	   }
   });


   $(window).resize(function() {
	   resizeViewport();
   }).bind('orientationchange', function() {
	   resizeViewport();
   });

   // Regions

   if ($.isTouch) {
	   $('.magazine').bind('touchstart', regionClick);
   } else {
	   $('.magazine').click(regionClick);
   }

   // Events for the next button

   $('.next-button').bind($.mouseEvents.over, function() {
	   
	   $(this).addClass('next-button-hover');

   }).bind($.mouseEvents.out, function() {
	   
	   $(this).removeClass('next-button-hover');

   }).bind($.mouseEvents.down, function() {
	   
	   $(this).addClass('next-button-down');

   }).bind($.mouseEvents.up, function() {
	   
	   $(this).removeClass('next-button-down');

   }).click(function() {
	   
	   $('.magazine').turn('next');

   });

   // Events for the next button
   
   $('.previous-button').bind($.mouseEvents.over, function() {
	   
	   $(this).addClass('previous-button-hover');

   }).bind($.mouseEvents.out, function() {
	   
	   $(this).removeClass('previous-button-hover');

   }).bind($.mouseEvents.down, function() {
	   
	   $(this).addClass('previous-button-down');

   }).bind($.mouseEvents.up, function() {
	   
	   $(this).removeClass('previous-button-down');

   }).click(function() {
	   
	   $('.magazine').turn('previous');

   });


   // Slider

   $( "#slider" ).slider({
	   min: 1,
	   max: numberOfViews(flipbook),

	   start: function(event, ui) {

		   if (!window._thumbPreview) {
			   _thumbPreview = $('<div />', {'class': 'thumbnail'}).html('<div></div>');
			   setPreview(pathBook, page);
			   _thumbPreview.appendTo($(ui.handle));
		   } else
			   setPreview(pathBook, pageNumber);

		   moveBar(false);

	   },

	   slide: function(event, ui) {

		   setPreview(pathBook, pageNumber);

	   },

	   stop: function() {

		   if (window._thumbPreview)
			   _thumbPreview.removeClass('show');
		   
		   $('.magazine').turn('page', Math.max(1, $(this).slider('value')*2 - 2));

	   }
   });

   resizeViewport();

   $('.magazine').addClass('animated');

}

// Zoom icon

$('.zoom-icon').bind('mouseover', function() { 
	
	if ($(this).hasClass('zoom-icon-in'))
		$(this).addClass('zoom-icon-in-hover');

	if ($(this).hasClass('zoom-icon-out'))
		$(this).addClass('zoom-icon-out-hover');

}).bind('mouseout', function() { 
	
	 if ($(this).hasClass('zoom-icon-in'))
		$(this).removeClass('zoom-icon-in-hover');
	
	if ($(this).hasClass('zoom-icon-out'))
		$(this).removeClass('zoom-icon-out-hover');

}).bind('click', function() {

	if ($(this).hasClass('zoom-icon-in'))
		$('.magazine-viewport').zoom('zoomIn');
	else if ($(this).hasClass('zoom-icon-out'))	
	   $('.magazine-viewport').zoom('zoomOut');

});

$('#canvas').hide();


// Load the HTML4 version if there's not CSS transform
yepnope({
	test : Modernizr.csstransforms,
	yep: ['<?php echo base_url();?>'+'turnjs4/lib/turn.min.js'],
	nope: ['<?php echo base_url();?>'+'turnjs4/lib/turn.html4.min.js', '<?php echo base_url();?>'+'turnjs4/samples/magazine/css/jquery.ui.html4.css'],
	both: ['<?php echo base_url();?>'+'turnjs4/lib/zoom.min.js', '<?php echo base_url();?>'+'turnjs4/samples/magazine/css/jquery.ui.css', '<?php echo base_url();?>'+'turnjs4/samples/magazine/js/magazine.js', '<?php echo base_url();?>'+'turnjs4/samples/magazine/css/magazine.css'],
	complete: loadApp
});

</script>

</body>
</html>