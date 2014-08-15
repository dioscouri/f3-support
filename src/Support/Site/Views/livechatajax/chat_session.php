    <div id="chat-messages" class="list-group poller" data-action="SupportGetNewMessages">
        <?php echo $this->renderView('Support/Site/Views::livechatajax/chat_messages.php'); ?>
    </div>
    <div class="panel-footer">
        <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-8">
                <form id="site-chat-form" action="./support/live-chat/ajax/comment" data-callback="SupportLiveChatUpdate">
                    <div class="input-group form-group">
                        <input type="text" class="form-control" id="new-comment" name="comment" placeholder="Comment...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Send</button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4">
                <span class="pull-right">
                    <a class="btn btn-sm btn-danger ajax-link" href="./support/live-chat/ajax/close">Close</a>
                </span>            
            </div>
        </div>
    </div>


<script>
SupportLiveChatUpdate = function(r) {
    /* r == a data response object */
    jQuery('#new-comment').val('');
    if (r.result) {
        jQuery('#chat-messages').append(r.result);
        jQuery('#chat-messages').animate({ scrollTop: jQuery('#chat-messages')[0].scrollHeight}, 1000);
        
        // TODO fade in new messages nicely ratehr than append
    }
    if (r.last_checked) {
        window.last_checked = r.last_checked;
    }    
}

SupportGetNewMessages = function(){
    jQuery.get( "./support/live-chat/ajax/new-messages/" + window.last_checked + '?ping=1', function( data ) {
        if (data.result) {
            jQuery('#chat-messages').append(data.result);
            jQuery('#chat-messages').animate({ scrollTop: jQuery('#chat-messages')[0].scrollHeight}, 1000);
            // TODO fade in new messages nicely ratehr than append            
        }

        if (data.last_checked) {
            window.last_checked = data.last_checked;
        }
    });
}

jQuery(document).ready(function(){
    window.last_checked = <?php echo time(); ?>; 
        
    jQuery('.poller').poller();

    jQuery('#chat-messages').animate({ scrollTop: jQuery('#chat-messages')[0].scrollHeight}, 1000);

    jQuery('#site-chat-form').on('submit', function(ev){
        ev.preventDefault();
        
        var form = jQuery(this);
        var url = form.attr('action') + '/' + window.last_checked;

        var request = $.ajax({
            type: 'post', 
            url: url,
            data: form.serialize()
        }).done(function(data){
            var r = $.parseJSON( JSON.stringify(data), false);
            if (r.redirect) {
                window.location = r.redirect; 
            }
            if (r.error == false) {
                form.find(':input').val("");
                if (form.attr('data-callback')) {
                    callback = form.attr('data-callback');
                    Dsc.executeFunctionByName(callback, window, r);
                }
            }
        }).fail(function(data){

        }).always(function(data){

        });        
        
        return false;        
    });

    jQuery('#site-chat .ajax-link').on('click', function(ev){
        ev.preventDefault();
        var el = jQuery(this);
        var url = el.attr('href');

        var request = $.ajax({
            type: 'get', 
            url: url
        }).done(function(data){
            jQuery('#site-chat').remove();
        }).fail(function(data){

        }).always(function(data){

        });                
    });    

    jQuery('#site-chat-body').collapse('show');
});
</script>