<form id="site-chat-form" action="./support/live-chat/ajax/request" data-callback="SupportLiveChatInitiate">
    <div class="panel-body">
        <?php if (!empty($this->auth->getIdentity()->id)) { ?>
        
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo $this->auth->getIdentity()->fullName(); ?>" required />
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" name="email" value="<?php echo $this->auth->getIdentity()->email; ?>" required />
            </div>
            
        <?php } else { ?>
        
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="" required />
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="" required />
            </div>
            
        <?php } ?>
    </div>
    <div class="panel-footer">
        <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-8">
                <button id="site-chat-submit-request" class="btn btn-primary">
                    Start 
                    <i class="fa fa-chevron-circle-right"></i>
                </button>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4">
                <span class="pull-right">
                    <a class="btn btn-sm btn-danger ajax-link" href="./support/live-chat/ajax/close">Close</a>
                </span>            
            </div>
        </div>    
    </div>
</form>

<script>
SupportLiveChatInitiate = function(r) {
    /* r == a data response object */
    if (r.result) {
        jQuery('#site-chat-body').html(r.result);
    }
}

jQuery(document).ready(function(){
    jQuery('#site-chat-submit-request').on('click', function(ev){
        console.log('submitting button');
        jQuery('#site-chat-form').submit();
    });
    
    jQuery('#site-chat-form').on('submit', function(ev){
        console.log('submitting form');
        ev.preventDefault();
        
        var form = jQuery(this);
        var url = form.attr('action');

        console.log('making request');
        var request = jQuery.ajax({
            type: 'post', 
            url: url,
            data: form.serialize()
        }).done(function(data){
            var r = $.parseJSON( JSON.stringify(data), false);
            if (r.redirect) {
                window.location = r.redirect; 
            }
            if (r.error == false) {
                form.find(':input').val("");
                if (form.attr('data-callback')) {
                    callback = form.attr('data-callback');
                    Dsc.executeFunctionByName(callback, window, r);
                }
            }
        }).fail(function(data){

        }).always(function(data){

        });        
        
        return false;        
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