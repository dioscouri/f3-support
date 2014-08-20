<?php $chat_id = $chat_session->id; ?>

<div class="panel-heading">
    <div class="row">
        <div class="col-xs-7">
            <h3 class="panel-title">
                <?php echo $chat_session->user_name ? $chat_session->user_name : $chat_session->user()->first_name; ?>
                <div><small><?php echo $chat_session->user_email ? $chat_session->user_email : $chat_session->user()->email; ?></small></div>
            </h3>
        </div>
        <div class="col-xs-5">
            <a class="btn btn-sm btn-info ajax-link" href="./admin/support/live-chat/ajax/unclaim/<?php echo $chat_id; ?>">Leave</a>
            <a class="btn btn-sm btn-danger ajax-link" href="./admin/support/live-chat/ajax/close/<?php echo $chat_id; ?>">End</a>
        </div>        
    </div>
    <div style="margin-top: 5px;">
        <small><label>On:</label> <a class="current-url" href="<?php echo $chat_session->userSessionData()->path; ?>"><?php echo $chat_session->userSessionData()->path; ?></a></small>
    </div>    
</div>
<div id="chat-messages-<?php echo $chat_id; ?>" class="list-group chat-messages" data-action="SupportGetNewMessages<?php echo $chat_id; ?>">
    <?php echo $this->renderView('Support/Admin/Views::livechatajax/chat_messages.php'); ?>
</div>
<div class="panel-footer">
    <form id="site-chat-form-<?php echo $chat_id; ?>" action="./admin/support/live-chat/ajax/comment/<?php echo $chat_id; ?>" data-callback="SupportLiveChatUpdate<?php echo $chat_id; ?>">
        <div class="input-group form-group">
            <input type="text" class="form-control comment" id="new-comment-<?php echo $chat_id; ?>" name="comment" placeholder="Add your comment here">
            <span class="input-group-btn">
                <input type="submit" class="btn btn-default" value="Send" />
            </span>
        </div>
    </form>
</div>

<script>
SupportLiveChatUpdate<?php echo $chat_id; ?> = function(r) {
    /* r == a data response object */
    jQuery('#new-comment-<?php echo $chat_id; ?>').val('');
    if (r.result) {
        SupportAppendUniqueMessages(jQuery('#chat-messages-<?php echo $chat_id; ?>'), r.result);
        SupportScrollBottom(jQuery('#chat-messages-<?php echo $chat_id; ?>'));
    }
    
    if (r.last_checked) {
        window.last_checked_<?php echo $chat_id; ?> = r.last_checked;
    }

    if (r.current_url) {
        jQuery('#admin-chat-wrapper-<?php echo $chat_session->id; ?> .current-url').attr('href', r.current_url).text(r.current_url);
    }        
}

SupportGetNewMessages<?php echo $chat_id; ?> = function(){
    jQuery.get( "./admin/support/live-chat/ajax/new-messages/<?php echo $chat_id; ?>/" + window.last_checked_<?php echo $chat_id; ?> + '?ping=1', function( data ) {
        if (data.result) {
            SupportAppendUniqueMessages(jQuery('#chat-messages-<?php echo $chat_id; ?>'), data.result);
            SupportScrollBottom(jQuery('#chat-messages-<?php echo $chat_id; ?>'));           
        }

        if (data.last_checked) {
            window.last_checked_<?php echo $chat_id; ?> = data.last_checked;
        }

        if (data.current_url) {
            jQuery('#admin-chat-wrapper-<?php echo $chat_session->id; ?> .current-url').attr('href', data.current_url).text(data.current_url);
        }        

        if (data.stop_polling) {
            jQuery('#chat-messages-<?php echo $chat_id; ?>').data('poller').stop();
        }
    });
}

jQuery(document).ready(function(){
    window.last_checked_<?php echo $chat_id; ?> = <?php echo time(); ?>; 
        
    jQuery('#chat-messages-<?php echo $chat_id; ?>').poller();

    jQuery('#chat-messages-<?php echo $chat_id; ?>').animate({ scrollTop: jQuery('#chat-messages-<?php echo $chat_id; ?>')[0].scrollHeight}, 1000);

    jQuery('#site-chat-form-<?php echo $chat_id; ?>').on('submit', function(ev){
        ev.preventDefault();
        
        var form = jQuery(this);
        var url = form.attr('action') + '/' + window.last_checked_<?php echo $chat_id; ?>;

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
                form.find(':input.comment').val("");
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

    jQuery('#admin-chat-wrapper-<?php echo $chat_session->id; ?> .ajax-link').on('click', function(ev){
        ev.preventDefault();
        var el = jQuery(this);
        var url = el.attr('href');

        var request = $.ajax({
            type: 'get', 
            url: url
        }).done(function(data){
            jQuery('#admin-chat-wrapper-<?php echo $chat_session->id; ?>').remove();
        }).fail(function(data){

        }).always(function(data){

        });                
    });
});
</script>