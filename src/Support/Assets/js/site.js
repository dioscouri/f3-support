jQuery(document).ready(function(){
    jQuery('body').append( jQuery('<div id="site-chat-container"></div>') );
    jQuery.get( "./support/live-chat/ajax/init?ping=1", function( data ) {
        if (data.result) {
            jQuery('#site-chat-container').html( data.result );
        }           
    });    
});