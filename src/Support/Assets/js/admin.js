jQuery(document).ready(function(){
    jQuery('body').append( jQuery('<div id="admin-chat-container"></div>') );
    jQuery.get( "./admin/support/live-chat/ajax/init", function( data ) {
        if (data.result) {
            jQuery('#admin-chat-container').html( data.result );
        }           
    });    
});