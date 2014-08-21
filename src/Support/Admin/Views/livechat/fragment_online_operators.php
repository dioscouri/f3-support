<?php foreach ($operators = \Support\Models\Operators::fetchActive() as $operator) { ?>
<div class="list-group-item">
    <b><?php echo $operator->fullName(); ?></b>
    <p class="help-block"><small><?php echo (int) $operator->openSessions(); ?> open sessions</small></p>
    
    <div class="help-block">
        <div><small>Last active: <?php echo \Dsc\Mongo\Collections\Sessions::ago( $operator->last_activity ); ?></small></div>               
    </div>    
</div>
<?php } ?>

<?php if (empty($operators)) { ?>
<div class="list-group-item">
    <p>No online operators</p>
</div>
<?php } ?>