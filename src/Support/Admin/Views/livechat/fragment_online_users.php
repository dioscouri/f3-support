<?php foreach ($visitors = \Dsc\Mongo\Collections\Sessions::fetchActiveVisitors() as $visitor) { ?>
<?php 

$chat_session = \Support\Models\ChatSessions::fetchForSession( $visitor->session_id );

$class = null;
if (!empty($chat_session->id)) {
    if ($chat_session->status == 'claimed') {
        $class = "list-group-item-success";
    } elseif ($chat_session->status == 'open-request') {
        $class = "list-group-item-danger";
    }
}

?>
            
<div class="list-group-item <?php echo $class; ?>">
    <div class="row">
        <div class="col-xs-10">
            <?php if (!empty($chat_session->user_name)) { ?>
                <div><?php echo $chat_session->user_name; ?>, <small><?php echo $chat_session->user_email; ?></small></div>
            <?php } elseif($visitor->user_id) { ?>
                <div><?php echo $visitor->user()->email; ?></div>
            <?php } else { ?>
                <div>Unidentified</div>                
            <?php } ?>
            
            <div class="help-block">
                <div><small>Last active: <?php echo \Dsc\Mongo\Collections\Sessions::ago( $visitor->timestamp ); ?></small></div>
                <div><small>Logged in: <?php echo $visitor->user_id ? 'Yes' : 'No'; ?></small></div>
            </div>
            <?php if (!empty($chat_session->admin_name)) { ?>
                <div class="help-block">
                    <div><small>In session with: <?php echo $chat_session->admin_name; ?></small></div>
                </div>
            <?php } elseif(!empty($chat_session->id)) { ?>
                <div class="help-block">
                    <div><b>Unclaimed, Open Request</b></div>
                    <div><small>Requested: <?php echo \Dsc\Mongo\Collections\Sessions::ago( $chat_session->{'metadata.created.time'} ); ?></small></div>
                </div>                            
            <?php } else { ?>

            <?php } ?>
        </div>
        <div class="col-xs-2">
            <?php if (!empty($chat_session->id)) { ?>
                <?php if ($chat_session->status != 'claimed') { ?>
                <a href="./admin/support/live-chat/claim/<?php echo $chat_session->id; ?>" title="Claim session">
                    <i class="fa fa-chevron-right"></i>
                </a>
                <?php } ?>            
                
            <?php } else { ?>
                <a href="./admin/support/live-chat/create/<?php echo $visitor->session_id; ?>" title="Start session">
                    <i class="fa fa-chevron-right"></i>
                </a>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>

<?php if (empty($visitors)) { ?>
<div class="list-group-item">
    <p>No online users</p>
</div>
<?php } ?>