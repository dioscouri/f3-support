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
            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8">
                    <a class="btn btn-primary" href="./support/case">Leave us a message</a>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <span class="pull-right">
                        <a class="btn btn-sm btn-danger ajax-link" href="./support/live-chat/ajax/close">No thanks</a>
                    </span>            
                </div>
            </div>            
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

    jQuery('#site-chat .ajax-link').on('click', function(ev){
        ev.preventDefault();
        var el = jQuery(this);
        var url = el.attr('href');

        var request = $.ajax({
            type: 'get', 
            url: url
        }).done(function(data){
            jQuery('#site-chat').remove();
        }).fail(function(data){

        }).always(function(data){

        });                
    });    
});
</script>