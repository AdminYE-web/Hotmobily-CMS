 $(document).ready(function(){
 	$(".fixed-thead").click(function(){
 		$('.scroll-center', this).hide();
 		$(this).children().each(function() { if($(this).css('opacity') == '0.7'){$(this).css('opacity',1)} });
 	});
 	$( ".fixed-thead").scroll(function() {
 		$('.scroll-center', this).hide();
 		$(this).children().each(function() { if($(this).css('opacity') == '0.7'){$(this).css('opacity',1)} });
 	});
 });