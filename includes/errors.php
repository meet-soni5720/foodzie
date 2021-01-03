<?php if(count($errors) > 0): ?>
    <div class="alert alert-dismissible alert-danger">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php foreach($errors as $e): ?>
            <p> <?php echo $e ?> </p>
        <?php endforeach ?>
</div>
<?php endif ?>