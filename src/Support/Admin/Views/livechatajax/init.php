<?php /* ?>foreach active admin session, display a tab, right-justified */ ?>
<?php foreach ($chat_sessions = \Support\Models\ChatSessions::fetchForAdmin( $this->auth->getIdentity()->id ) as $chat_session) { ?>
    <?php 
    $this->app->set('chat_session', $chat_session);
    $this->app->set('messages', $chat_session->messages);
    echo $this->renderView('Support/Admin/Views::livechatajax/tab.php')
    ?>
<?php } ?>