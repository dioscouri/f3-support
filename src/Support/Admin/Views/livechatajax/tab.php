<div id="admin-chat-wrapper-<?php echo $chat_session->id; ?>" class="admin-chat-wrapper">
    <div id="admin-chat-button-<?php echo $chat_session->id; ?>" class="btn btn-default admin-chat-button" onclick="jQuery('#admin-chat-<?php echo $chat_session->id; ?>').collapse('toggle'); SupportSnapBottom(jQuery('#chat-messages-<?php echo $chat_session->id; ?>'));">
        <i class="fa fa-comments-o"></i>
        <?php echo $chat_session->user_name ? $chat_session->user_name : $chat_session->user()->first_name; ?>
    </div>
    
    <div id="admin-chat-<?php echo $chat_session->id; ?>" class="panel-collapse collapse admin-chat-body">
        <div id="admin-chat-body-<?php echo $chat_session->id; ?>">
            <?php 
            echo $this->renderView('Support/Admin/Views::livechatajax/chat_session.php');
            ?>
        </div>
    </div>
</div>