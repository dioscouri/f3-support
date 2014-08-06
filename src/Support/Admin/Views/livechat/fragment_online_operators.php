<?php foreach ($operators = \Support\Models\Operators::fetchActive() as $operator) { ?>
<div class="list-group-item">
    <b><?php echo $operator->fullName(); ?></b>
    <p class="help-block"><small><?php echo (int) $operator->open_sessions; ?> open sessions</small></p>
</div>
<?php } ?>

<?php if (empty($operators)) { ?>
<div class="list-group-item">
    <p>No online operators</p>
</div>
<?php } ?>