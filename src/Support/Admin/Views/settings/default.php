<script src="./ckeditor/ckeditor.js"></script>
<script>
jQuery(document).ready(function(){
    CKEDITOR.replaceAll( 'wysiwyg' );    
});
</script>

<div class="well">
<form id="settings-form" role="form" method="post" class="form-horizontal clearfix">

    <div class="clearfix">
        <button type="submit" class="btn btn-primary pull-right">Save Changes</button>
    </div>
    
    <hr/>

    <div class="row">
        <div class="col-md-3 col-sm-4">
            <ul class="nav nav-pills nav-stacked">
                <li class="active">
                    <a href="#tab-commissions" data-toggle="tab"> Commissions Settings </a>
                </li>            
                <li>
                    <a href="#tab-invitations" data-toggle="tab"> Invitations Settings </a>
                </li>
                <li>
                    <a href="#tab-dashboard" data-toggle="tab"> Dashboard Settings </a>
                </li>                
                <li>
                    <a href="#tab-social" data-toggle="tab"> Social Sharing Options </a>
                </li>
                
                <?php if (class_exists('\Shop\Models\Orders')) { ?>
                <li>
                    <a href="#tab-shop" data-toggle="tab"> Shop Settings </a>
                </li>                
                <?php } ?>
                
                <?php if (!empty($this->event)) { foreach ((array) $this->event->getArgument('tabs') as $key => $title ) { ?>
                <li>
                    <a href="#tab-<?php echo $key; ?>" data-toggle="tab"> <?php echo $title; ?> </a>
                </li>
                <?php } } ?>                
            </ul>
        </div>

        <div class="col-md-9 col-sm-8">

            <div class="tab-content stacked-content">
            
                <div class="tab-pane fade in active" id="tab-commissions">
                    
                    <div class="form-group">
                        <label>Automatically issue commissions when they are created?</label>
                        <div class="row">
                            <div class="col-md-4">
                                <select name="commissions[auto_issue]" class="form-control">
                                	<?php echo \Dsc\Html\Select::options( array(
                            			array( 'value' => 0, 'text' => 'No' ),
                                	    array( 'value' => 1, 'text' => 'Yes' ),
                                	), $flash->old('commissions.auto_issue') ); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.form-group -->
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">                    
                                
                                    <label>Commission earned for referral</label>
                                    <select name="commissions[for_referral]" class="form-control">
                                    	<?php echo \Dsc\Html\Select::options( array(
                                			array( 'value' => 0, 'text' => 'No' ),
                                    	    array( 'value' => 1, 'text' => 'Yes' ),
                                    	), $flash->old('commissions.for_referral') ); ?>
                                    </select>
                                
                            </div>
                            <div class="col-md-6">                    
                                
                                    <label>Commission earned for conversion</label>
                                    <select name="commissions[for_conversion]" class="form-control">
                                    	<?php echo \Dsc\Html\Select::options( array(
                                			array( 'value' => 0, 'text' => 'No' ),
                                    	    array( 'value' => 1, 'text' => 'Yes' ),
                                    	), $flash->old('commissions.for_conversion') ); ?>
                                    </select>
                                
                            </div>                        
                        </div>
                    </div>
                    <!-- /.form-group -->
                                        
                </div>
            
                <div class="tab-pane fade in" id="tab-invitations">
                    
                    <div class="form-group">
                        <label>Default message in invitation emails</label>
                        <textarea name="general[default_message]" class="form-control" rows="10"><?php echo $flash->old('general.default_message'); ?></textarea>                        
                    </div>
                    <!-- /.form-group -->
                    
                </div>
                
                <div class="tab-pane fade in" id="tab-dashboard">
                
                    <div class="form-group">
                        <label>Custom HTML Header for the Affiliate Dashboard</label>
                        <textarea name="dashboard_header" class="form-control wysiwyg" rows="10"><?php echo $flash->old('dashboard_header'); ?></textarea>                        
                    </div>
                    <!-- /.form-group -->

                </div>
                
                <div class="tab-pane fade in" id="tab-social">
                
                    <?php echo $this->renderLayout('Affiliates/Admin/Views::settings/social.php'); ?>

                </div>
                
                <?php if (class_exists('\Shop\Models\Orders')) { ?>
                <div class="tab-pane fade in" id="tab-shop">                
                    <?php echo $this->renderLayout('Affiliates/Admin/Views::settings/shop.php'); ?>
                </div>
                <?php } ?>
                
                <?php if (!empty($this->event)) { foreach ((array) $this->event->getArgument('content') as $key => $content ) { ?>
                <div class="tab-pane fade in" id="tab-<?php echo $key; ?>">
                    <?php echo $content; ?>
                </div>
                <?php } } ?>

            </div>

        </div>
    </div>

</form>
</div>