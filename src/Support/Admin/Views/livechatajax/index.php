<form id="site-chat-form" action="./support/live-chat/ajax/request" data-callback="SupportLiveChatInitiate">
    <div class="panel-body">
        <?php if (!empty($this->auth->getIdentity()->id)) { ?>
        
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo $this->auth->getIdentity()->fullName(); ?>" disabled />
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" name="email" value="<?php echo $this->auth->getIdentity()->email; ?>" disabled />
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
        <button id="site-chat-submit-request" class="btn btn-primary">
            Start 
            <i class="fa fa-chevron-circle-right"></i>
        </button>
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
});
</script>