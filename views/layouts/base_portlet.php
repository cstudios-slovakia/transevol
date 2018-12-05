<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                <h3 class="m-portlet__head-text">
                    Default Form Layout
                </h3>
            </div>
        </div>
    </div>

    <!--begin::Form-->
<!--    <form class="m-form">-->
<!--    --><?php
//    dd($this )
//    ?>
    <?php $form  ?>
        <?= $content ?>
    <?php  \yii\bootstrap\ActiveForm::end(); ?>

    <!--end::Form-->
</div>