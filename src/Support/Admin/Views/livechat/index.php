<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-table fa-fw "></i> Live Chat
            <span>
                > <small>You are:
                <?php if (\Support\Models\Operators::isActive( $this->auth->getIdentity() )) { ?> 
                    <a class="btn btn-success" href="./admin/support/live-chat/offline" title="Go offline">Online</a>
                <?php } else { ?>
                    <a class="btn btn-danger" href="./admin/support/live-chat/online" title="Go online" >Offline</a>
                <?php } ?>
            </span>
        </h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
        <ul id="sparks" class="list-actions list-unstyled list-inline">
            <li>
                
            </li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-sm-3 col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                Online users
            </div>
            <div id="online-users" class="list-group poller" data-action="SupportGetOnlineUsers">
                <?php echo $this->renderView('Support/Admin/Views::livechat/fragment_online_users.php'); ?>                                 
            </div>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-heading">
                Online operators
            </div>
            <div id="online-operators" class="list-group poller" data-action="SupportGetOnlineOperators">
                <?php echo $this->renderView('Support/Admin/Views::livechat/fragment_online_operators.php'); ?>                                 
            </div>            
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function(){
    jQuery('.poller').poller();
});

SupportGetOnlineUsers = function(){
    jQuery.get( "./admin/support/live-chat/online-users", function( data ) {
        if (data.result) {
            jQuery( "#online-users" ).html( data.result );
        }           
    });
}

SupportGetOnlineOperators = function(){
    jQuery.get( "./admin/support/live-chat/online-operators", function( data ) {
        if (data.result) {
            jQuery( "#online-operators" ).html( data.result );
        }           
    });
}
</script>
