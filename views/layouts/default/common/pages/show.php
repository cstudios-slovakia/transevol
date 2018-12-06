<?php
$sectionName = $this->context->id;


?>



<div class="m-portlet m-portlet--full-height ">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    <?= $this->params['page']['show']['portlet_title'] ?>
                </h3>
            </div>
        </div>

    </div>
    <div class="m-portlet__body">
        <div class="m-widget13">
            <?= $content ?>

            <div class="m-widget13__action m--align-right">
                <button type="button" class="m-widget__detalis  btn m-btn--pill  btn-accent">Detalis</button>
                <button type="button" class="btn m-btn--pill    btn-secondary">Update</button>
            </div>
        </div>
    </div>
</div>
