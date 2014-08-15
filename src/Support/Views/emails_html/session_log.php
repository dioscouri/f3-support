<p><?php echo trim( 'Hi ' . $chat_session->user_name ); ?>,</p> 

<h3>Here is the transcript from your recent live chat session:</h3> 
--- <br/>
<?php foreach ($chat_session->messages as $message) { ?>
<p> <?php echo $message['text']; ?><br/> 
- <?php echo $message['sender_name']; ?><br/> 
</p>
<?php } ?>
--- <br/>

<?php // footer ?>