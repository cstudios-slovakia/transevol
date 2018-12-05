<?php $this->beginContent('@app/views/layouts/base_portlet.php'); ?>

<div class="m-portlet__body">
    <?= $content ?>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <?php if (isset($this->blocks['block2'])): ?>
            <?= $this->blocks['block2'] ?>
        <?php else: ?>
            <button type="reset" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        <?php endif; ?>

    </div>
</div>

<?php $this->endContent(); ?>