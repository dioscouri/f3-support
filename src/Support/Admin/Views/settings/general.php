<div class="row">
    <div class="col-md-12">

        <div class="form-group">
            <div class="row">
                <div class="col-md-6">        
                    <label>Enable Live Chat</label>
                    <select name="live_chat_enabled" class="form-control">
                        <option value="0" <?php echo (!$flash->old('live_chat_enabled')) ? "selected='selected'" : null; ?>>No</option>
                        <option value="1" <?php echo ($flash->old('live_chat_enabled')) ? "selected='selected'" : null; ?>>Yes</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- /.form-group -->
        
    </div>
</div>

<?php /* ?>
<div class="row">
    <div class="col-md-12">

        <div class="form-group">
            <div class="row">
                <div class="col-md-6">        
                    <label>Setting Label</label>
                    <input type="text" name="shop[store_credit_per_referral]" placeholder="e.g. 5.00" value="<?php echo $flash->old('shop.store_credit_per_referral'); ?>" class="form-control" />
                </div>
            </div>
        </div>
        <!-- /.form-group -->
        
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label>Setting Label 2</label>
                    <input type="text" name="shop[store_credit_per_conversion]" placeholder="e.g. 5.00 or 10.00" value="<?php echo $flash->old('shop.store_credit_per_conversion'); ?>" class="form-control" />
                </div>
                <div class="col-md-6">
                    <label>Label 3</label>
                    <select name="shop[store_credit_per_conversion_type]" class="form-control">
                        <option value="flat-rate" <?php echo ($flash->old('shop.store_credit_per_conversion_type') == 'flat-rate') ? "selected='selected'" : null; ?>>Flat Rate</option>
                        <option value="percentage" <?php echo ($flash->old('shop.store_credit_per_conversion_type') == 'percentage') ? "selected='selected'" : null; ?>>Percentage</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- /.form-group -->

    </div>
</div>
*/