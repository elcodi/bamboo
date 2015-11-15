// JavaScript Document
$(document).ready( function(){
	$(".bgpattern").each( function(){
		var wrap = this;
		if( $("input",wrap).val() ){	
			$("#" + $("input",wrap).val()).addClass("active"); 
		}
		$("a",this).click( function(){
		 	  $("input",wrap).val( $(this).attr("id").replace(/\.\w+$/,"") );
			  $("a",wrap).removeClass( "active" );
			  $(this).addClass("active");
		} );
	} );
} );