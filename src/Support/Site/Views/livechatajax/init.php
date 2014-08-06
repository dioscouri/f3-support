<div id="site-chat" class="panel panel-primary">
    <div class="panel-heading" onclick="jQuery('#site-chat-body').collapse('toggle');">
        <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-10">
                <h3 class="panel-title">
                    Talk to us
                </h3>    
            </div>
            <div class="col-xs-4 col-sm-4 col-md-2">
                <span class="pull-right">
                    <i id="site-chat-chevron" class="fa fa-chevron-up"></i>
                </span>
                
            </div>
        </div>
    </div>
    <div id="site-chat-body" class="panel-collapse collapse">
        <?php 
        if (!empty($chat_session->id)) { 
            echo $this->renderView('Support/Site/Views::livechatajax/chat_session.php');
        } else {
            echo $this->renderView('Support/Site/Views::livechatajax/index.php');
        } 
        ?>
    </div>
</div>

<script>
jQuery(document).ready(function(){
    jQuery('#site-chat-body').on('hidden.bs.collapse', function () {
        jQuery('#site-chat-chevron').removeClass('fa-chevron-down').addClass('fa-chevron-up');
    });
    jQuery('#site-chat-body').on('show.bs.collapse', function () {
        jQuery('#site-chat-chevron').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    });    
});
</script>