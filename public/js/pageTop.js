function jumpToPageTop( elm ) {
	var y = Position.realOffset(elm)[1];
	var s = 10;
	jtpt( s, y );
}

function jtpt( s, y ) {
	var y2 = parseInt( y - ( y / s ) );
	if ( y2 <= 0 ) { return false; }
	window.scrollTo( 0, y2 );
	window.setTimeout( function(){ jtpt( s, y2 ); }, 15 );
	return false;
}

