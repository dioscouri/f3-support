<form id="site-chat-form" action="./support/live-chat/request">
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
        <a href="#" class="btn btn-primary">
            Start 
            <i class="fa fa-chevron-circle-right"></i>
        </a>
    </div>
</form>

<script>
jQuery(document).ready(function(){
    jQuery('#site-chat-form').on('submit', function(ev){
        var el = jQuery(this);

    	ev.preventDefault();
        return false;        
    });
});
</script>