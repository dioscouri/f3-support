<div class="row">
    <div class="col-md-12">

        <div class="form-group">
            <div class="row">
                <div class="col-md-6">        
                    <label>Store credit earned for "Referral" commissions</label>
                    <input type="text" name="shop[store_credit_per_referral]" placeholder="e.g. 5.00" value="<?php echo $flash->old('shop.store_credit_per_referral'); ?>" class="form-control" />
                </div>
            </div>
        </div>
        <!-- /.form-group -->
        
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label>Store credit earned for "Conversion" commissions</label>
                    <input type="text" name="shop[store_credit_per_conversion]" placeholder="e.g. 5.00 or 10.00" value="<?php echo $flash->old('shop.store_credit_per_conversion'); ?>" class="form-control" />
                </div>
                <div class="col-md-6">
                    <label>Type</label>
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

<div class="row">
    <div class="col-md-12">
    
        <div class="form-group">
            <label>How long does an affiliate earn conversion commissions?</label>
            <div class="row">
                <div class="col-md-6">
                    <label>Number</label>
                    <input type="text" name="shop[conversion_number]" placeholder="e.g. 6" value="<?php echo $flash->old('shop.conversion_number'); ?>" class="form-control" />
                </div>
                <div class="col-md-6">
                    <label>Period</label>
                    <select name="shop[conversion_period]" class="form-control">
                        <option value="order" <?php echo ($flash->old('shop.conversion_period') == 'order') ? "selected='selected'" : null; ?>>Order</option>
                        <option value="month" <?php echo ($flash->old('shop.conversion_period') == 'month') ? "selected='selected'" : null; ?>>Month</option>
                        <option value="year" <?php echo ($flash->old('shop.conversion_period') == 'year') ? "selected='selected'" : null; ?>>Year</option>
                        <option value="forever" <?php echo ($flash->old('shop.conversion_period') == 'forever') ? "selected='selected'" : null; ?>>Forever</option>
                    </select>
                </div>
            </div>
            <p class="help-block">If you enter "1" and select "Order", the affiliate will only earn a commission on their referral's first order.  If you enter "6" and select "month", they will earn a commission for every order their referral makes during the referral's first 6 months as a customer. Number is ignored if you select "Forever".</p>    
        </div>
        <!-- /.form-group -->
        
    </div>
</div>
