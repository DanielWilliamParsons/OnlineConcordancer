/*$(document).ready(function() {
	$('thingToTouch').event(function() {
		$('thingToAffect').effect();
	});
});*/
/*This will highlight a form
$(document).ready(function(){
    $('input').focus(function(){
        $(this).css('outline-color', '#FFFFF0');
    });
});*/

/* This will make a div animate to become longer!
$( 'span' ).animate({ 
    'width': 300
},
{
    duration: 1000,
    step: function(now, fx) {
        // Change color to red when the animation is halfways done
        if( fx.pos > 0.5 ){
            $( this ).addClass( 'red' );
        }
        
        // Show how much of the animation has been completed
        $( fx.elem ).text(Math.floor(fx.pos * 100) + '%');
    }
});
*/

/*fading for mouse enter and mouse leave events
$('.moveable').mouseenter(function() {
		$('.moveable').fadeTo('fast', 1);
	});
	$('.moveable').mouseleave(function() {
		$('.moveable').fadeTo('slow', 0.25);
	});
*/

/*Mouse enters and object rotates 90 degrees
//However, when the mouse leaves there is no return rotation
//Maybe useful for animation on page load
$('.icon').mouseenter(function() {
		$('.icon').animate({ borderSpacing: -90}, {
		step: function(now,fx) {
			$(this).css('-webkit-transform', 'rotate('+now+'deg)');
			$(this).css('-moz-transform', 'rotate('+now+'deg)');
			$(this).css('-ms-transform', 'rotate('+now+'deg)');
			$(this).css('-o-transform', 'rotate('+now+'deg)');
			$(this).css('transform', 'rotate('+now+'deg)');
		},
		duration: 'slow'
		}, 'linear');
	});
*/

$(document).ready(function() {
		$('#example').tooltip();
		
		$('#assignments').popover( {
			title: "My Assignments<a class='close' href='#'>&times;</a>",
			html: true,
			content: function(ele) {
				return $('#assignments-content').html();
			},
			delay: 300,
			placement: 'right',
			container: 'body'
		});
		
		$('#more_assignments').popover( {
			title: "Some more assignments",
			html: true,
			content:  $('#assignments-content_2').html(),
			delay: 300,
			placement: 'top',
			container: 'body'
		});
		
		$('.popoverThis').click(function (e) {
			e.stopPropagation();
		});

		$(document).click(function (e) {
			if (($('.popover').has(e.target).length == 0) || $(e.target).is('.close')) {
				$('.popoverThis').popover('hide');
			}
		});

		$('.icon').animate({ borderSpacing: -360}, {
		step: function(now,fx) {
			$(this).css('-webkit-transform', 'rotate('+now+'deg)');
			$(this).css('-moz-transform', 'rotate('+now+'deg)');
			$(this).css('-ms-transform', 'rotate('+now+'deg)');
			$(this).css('-o-transform', 'rotate('+now+'deg)');
			$(this).css('transform', 'rotate('+now+'deg)');
		},
		duration: 1500
		}, 'linear');
		
});