<?php echo trim( 'Hi ' . $chat_session->user_name ); ?>, 

Here is the transcript from your recent live chat session: 

<?php foreach ($chat_session->messages as $message) { ?>
--- 

<?php echo $message['text']; ?> 
- <?php echo $message['sender_name']; ?> 

<?php } ?>
--- 

<?php // footer ?>