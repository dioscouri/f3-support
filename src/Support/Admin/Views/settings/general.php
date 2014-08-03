<div class="row">
    <div class="col-md-12">

        <div class="form-group">
            <div class="row">
                <div class="col-md-6">        
                    <label>Setting Label</label>
                    <?php /* ?><input type="text" name="shop[store_credit_per_referral]" placeholder="e.g. 5.00" value="<?php echo $flash->old('shop.store_credit_per_referral'); ?>" class="form-control" /> */ ?>
                </div>
            </div>
        </div>
        <!-- /.form-group -->
        
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label>Setting Label 2</label>
                    <?php /* ?><input type="text" name="shop[store_credit_per_conversion]" placeholder="e.g. 5.00 or 10.00" value="<?php echo $flash->old('shop.store_credit_per_conversion'); ?>" class="form-control" />*/ ?>
                </div>
                <div class="col-md-6">
                    <label>Setting Label 3</label>
                    <?php /* ?>
                    <select name="shop[store_credit_per_conversion_type]" class="form-control">
                        <option value="flat-rate" <?php echo ($flash->old('shop.store_credit_per_conversion_type') == 'flat-rate') ? "selected='selected'" : null; ?>>Flat Rate</option>
                        <option value="percentage" <?php echo ($flash->old('shop.store_credit_per_conversion_type') == 'percentage') ? "selected='selected'" : null; ?>>Percentage</option>
                    </select>
                    */ ?>
                </div>
            </div>
        </div>
        <!-- /.form-group -->

    </div>
</div>
