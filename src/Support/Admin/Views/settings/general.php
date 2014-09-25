<div class="row">
    <div class="col-md-12">

        <div class="form-group">
            <div class="row">
                <div class="col-md-4">        
                    <label>Enable Live Chat</label>
                    <select name="live_chat_enabled" class="form-control">
                        <option value="0" <?php echo (!$flash->old('live_chat_enabled')) ? "selected='selected'" : null; ?>>No</option>
                        <option value="1" <?php echo ($flash->old('live_chat_enabled')) ? "selected='selected'" : null; ?>>Yes</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- /.form-group -->
        
        <hr/>
        
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">        
                    <label>Minutes before an operator is considered inactive</label>
                    <select name="operator_inactive" class="form-control">
                        <option value="5" <?php echo ($flash->old('operator_inactive') == 5) ? "selected='selected'" : null; ?>>5</option>
                        <option value="10" <?php echo ($flash->old('operator_inactive') == 10) ? "selected='selected'" : null; ?>>10</option>
                        <option value="20" <?php echo ($flash->old('operator_inactive') == 20) ? "selected='selected'" : null; ?>>20</option>
                        <option value="30" <?php echo ($flash->old('operator_inactive') == 30) ? "selected='selected'" : null; ?>>30</option>
                        <option value="45" <?php echo ($flash->old('operator_inactive') == 45) ? "selected='selected'" : null; ?>>45</option>
                        <option value="60" <?php echo ($flash->old('operator_inactive') == 60) ? "selected='selected'" : null; ?>>60</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- /.form-group -->
        
        <hr/>        
                
        <div class="form-group">
            <div class="alert alert-info">Your Live Chat landing page is <a href="./support/live-chat" target="_blank">./support/live-chat</a></div>
            <label>Landing Page Content</label>
            <textarea name="live_chat_index" class="form-control wysiwyg"><?php echo $flash->old('live_chat_index'); ?></textarea>            
        </div>
        <!-- /.form-group -->
                
    </div>
</div>