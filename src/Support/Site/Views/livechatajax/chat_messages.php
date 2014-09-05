<?php if (!empty($messages)) { ?>
    <?php foreach ($messages as $message) { ?>
    <div class="list-group-item chat-message" id="<?php echo $chat_session->id . '-' . $message['sender_type'] . '-' . $message['timestamp']; ?>">
        <div class="row">
            <?php if ($message['sender_type'] == 'user') { ?>
            <div class="col-xs-9 col-sm-10 col-md-10">
                <div class="list-group-item-heading"><?php echo $message['text']; ?></div>
                <p class="text-info"><?php echo $message['sender_name']; ?> 
                    <?php /*?><small class="text-muted"><?php echo \Dsc\Mongo\Collections\Sessions::ago( $message['timestamp'] ); ?></small>*/ ?>
                </p>
            </div>            
            <div class="col-xs-3 col-sm-2 col-md-2">
                <i class="fa fa-comment"></i>
            </div>
            <?php } else { ?>
            <div class="col-xs-3 col-sm-2 col-md-2">
                <?php if ($message['sender_type'] == 'system') { ?>
                    <i class="fa fa-cogs"></i>
                <?php } else { ?>
                    <i class="fa fa-life-ring"></i>
                <?php } ?>
            </div>
            <div class="col-xs-9 col-sm-10 col-md-10">
                <div class="list-group-item-heading">
                <?php 
                echo preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $message['text']);
                ?>
                </div>
                <?php if ($message['sender_type'] != 'system') { ?>
                <p class="text-info"><?php echo $message['sender_name']; ?> 
                    <?php /*?><small class="text-muted"><?php echo \Dsc\Mongo\Collections\Sessions::ago( $message['timestamp'] ); ?></small>*/ ?>
                </p>
                <?php } ?>
            </div>            
            <?php } ?>
        </div>
    </div>
    <?php } ?>
<?php } ?>