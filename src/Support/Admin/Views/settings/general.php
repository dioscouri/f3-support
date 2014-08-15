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
            <div class="alert alert-info">Your Live Chat landing page is <a href="./support/live-chat" target="_blank">./support/live-chat</a></div>
            <label>Landing Page Content</label>
            <textarea name="live_chat_index" class="form-control wysiwyg"><?php echo $flash->old('live_chat_index'); ?></textarea>            
        </div>
        <!-- /.form-group -->
                
    </div>
</div>