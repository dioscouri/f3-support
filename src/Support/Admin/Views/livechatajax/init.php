<div class="pull-left">
    <div class="clearfix">
        <a class="btn btn-default" href="./admin/support/live-chat"> Live Chat </a>
        &nbsp;
        <span id="unclaimed-sessions" class="poller" data-action="SupportGetUnclaimedSessions">
            <?php echo $this->renderView('Support/Admin/Views::livechat/fragment_unclaimed_sessions.php'); ?>
        </div>
    </div>
</div>

<?php /* ?>foreach active admin session, display a tab, right-justified */ ?>
<?php foreach ($chat_sessions = \Support\Models\ChatSessions::fetchForAdmin( $this->auth->getIdentity()->id ) as $chat_session) { ?>
    <?php 
    $this->app->set('chat_session', $chat_session);
    $this->app->set('messages', $chat_session->messages);
    echo $this->renderView('Support/Admin/Views::livechatajax/tab.php')
    ?>
<?php } ?>

<script>
jQuery(document).ready(function(){
    jQuery('.poller').poller();
});
    
SupportGetUnclaimedSessions = function(){
    jQuery.get( "./admin/support/live-chat/unclaimed-sessions", function( data ) {
        if (data.result) {
            jQuery( "#unclaimed-sessions" ).html( data.result );
        }           
    });
}
</script>