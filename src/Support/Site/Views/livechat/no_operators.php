<div id="site-chat" class="panel panel-primary">
    <div class="panel-heading" onclick="jQuery('#site-chat-body').collapse('toggle');">
        <div class="row">
            <div class="col-sm-8">
                <h3 class="panel-title">
                    Leave us a message
                </h3>    
            </div>
            <div class="col-sm-4">
                <div class="pull-right">
                    <i id="site-chat-chevron" class="fa fa-chevron-up"></i>
                </div>
            </div>
        </div>
    </div>
    <div id="site-chat-body" class="panel-collapse collapse">
        <div class="panel-body">
            None of our operators are online at the moment but we'd still love to hear from you.
        </div>
        <div class="panel-footer">
            <a class="btn btn-primary" href="./support/case">Leave us a message</a>
        </div>
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