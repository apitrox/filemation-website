<style>
#one,#three,#five {
	vertical-align:top;
	display: inline-table;
	background: #faa;
}
#two,#four {
	display: block;
	bottom:0;
	background: #ddd;
	width: 22px;
	position: absolute;
	top:0;
	cursor:pointer;
}
#one {
	width: 300px;
	margin-right:22px;
}
#two {
	left:300px;
}
#three {
	width: 290px;
	margin-right:22px;
}
#four {
	left:612px;
}
#five {
	width: 300px;
}
</style>
<script type="text/javascript">
$(function() {

// webkit browsers don't calculate a value when margins are set to auto. this creates a problem when trying to use offset() which works relative to the document
// as this returns nothing for webkit browsers. to circumvent this, we manually center the outer div by calculating the document width, subtracting the container 
// width, dividing by two, and set the left-margin on the container div. now since we place hard coded values on the container div, webkit will work properly with 
// offset. note that this creates a minor issue if the browser is resized after the page is initially rendered.

	//$('#content_container').css('margin-left',($(document).width()-960)/2);

	var stopTwoLeft = parseInt( $('#one').offset().left ) +150;
	var stopTwoRight = parseInt( $('#three').offset().left ) + $('#three').width() - 150;
	var stopFourLeft = parseInt( $('#three').offset().left ) +150;
	var stopFourRight = parseInt( $('#five').offset().left ) + $('#five').width() - 150;

	$("#two").draggable({ axis: 'x', 
			start: function(event, ui) {
				leftOneStart = $('#one').width();
				leftThreeStart = $('#three').width();
			},
			drag: function(event, ui) {
				$('#one').width( leftOneStart + (ui.position.left-ui.originalPosition.left) );
				$('#three').width( leftThreeStart - (ui.position.left-ui.originalPosition.left) );
			},
			stop: function(event, ui) {
				stopFourLeft = parseInt( $('#three').offset().left ) +150;
				$("#four").draggable( {containment: [stopFourLeft,0,stopFourRight,0]} );
			},
			containment: [stopTwoLeft,0,stopTwoRight,0]
	});

	$("#four").draggable({ axis: 'x',
			start: function(event, ui) {
				rightThreeStart = $('#three').width();
				rightFiveStart = $('#five').width();
			},
			drag: function(event, ui) {
				$('#three').width( rightThreeStart + (ui.position.left-ui.originalPosition.left) );
				$('#five').width( rightFiveStart - (ui.position.left-ui.originalPosition.left) );
			},
			stop: function(event, ui) {
				stopTwoRight = parseInt( $('#three').offset().left ) + $('#three').width() - 150;
//				$("#two").draggable( {containment: [stopTwoLeft,0,stopTwoRight,0]} );
			},
			containment: [stopFourLeft,0,stopFourRight,0]
	});
});
</script>

</head>

<body>
<div id="content_container">
	<div id="content">
	<p id="notification"></p>

<div style="position:relative;width:944px">
<div id="one">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras volutpat fermentum bibendum. Aenean non felis at est gravida tincidunt. Donec non diam a mauris vestibulum condimentum eu vitae mi! Aenean sed elit libero, id mollis felis! Pellentesque eget nunc ac arcu tristique facilisis! Aliquam odio nunc; auctor sit amet euismod sed, fringilla nec nibh. Integer a urna arcu. Etiam tempor dignissim gravida. Fusce commodo, tortor vel pellentesque tincidunt, sem libero volutpat orci, a elementum massa odio et dui. Ut quis auctor elit. Duis mattis erat non lorem vestibulum lobortis. Integer ut mi neque, at lobortis turpis. Nunc eu purus dolor. Curabitur luctus felis ut purus placerat sit amet semper libero vehicula. Vivamus in lectus arcu; non consectetur augue. Praesent diam felis, consectetur non consequat ut, rutrum sit amet odio. Curabitur ipsum ante, sodales non pulvinar a, sagittis vitae metus!
</div><div id="two">2</div><div id="three">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras volutpat fermentum bibendum. Aenean non felis at est gravida tincidunt. Donec non diam a mauris vestibulum condimentum eu vitae mi! Aenean sed elit libero, id mollis felis! Pellentesque eget nunc ac arcu tristique facilisis! Aliquam odio nunc; auctor sit amet euismod sed, fringilla nec nibh. Integer a urna arcu. Etiam tempor dignissim gravida. Fusce commodo, tortor vel pellentesque tincidunt, sem libero volutpat orci, a elementum massa odio et dui. Ut quis auctor elit. Duis mattis erat non lorem vestibulum lobortis. Integer ut mi neque, at lobortis turpis. Nunc eu purus dolor. Curabitur luctus felis ut purus placerat sit amet semper libero vehicula. Vivamus in lectus arcu; non consectetur augue. Praesent diam felis, consectetur non consequat ut, rutrum sit amet odio. Curabitur ipsum ante, sodales non pulvinar a, sagittis vitae metus!
</div><div id="four">4</div><div id="five">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras volutpat fermentum bibendum. Aenean non felis at est gravida tincidunt. Donec non diam a mauris vestibulum condimentum eu vitae mi! Aenean sed elit libero, id mollis felis! Pellentesque eget nunc ac arcu tristique facilisis! Aliquam odio nunc; auctor sit amet euismod sed, fringilla nec nibh. Integer a urna arcu. Etiam tempor dignissim gravida. Fusce commodo, tortor vel pellentesque tincidunt, sem libero volutpat orci, a elementum massa odio et dui. Ut quis auctor elit. Duis mattis erat non lorem vestibulum lobortis. Integer ut mi neque, at lobortis turpis. Nunc eu purus dolor. Curabitur luctus felis ut purus placerat sit amet semper libero vehicula. Vivamus in lectus arcu; non consectetur augue. Praesent diam felis, consectetur non consequat ut, rutrum sit amet odio. Curabitur ipsum ante, sodales non pulvinar a, sagittis vitae metus!
</div>
</div>



	</div><!-- #content -->
</div><!-- #content_container -->
