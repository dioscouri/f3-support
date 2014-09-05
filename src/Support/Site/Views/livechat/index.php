<?php $settings = \Support\Models\Settings::fetch(); ?>
<div><?php echo $settings->live_chat_index; ?></div>

<script>
jQuery(window).load(function(){
    jQuery('#site-chat-body').collapse('show');
});
</script>