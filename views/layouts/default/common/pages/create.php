<?php
$sectionName = $this->context->id;
?>

<div class="row">
    <div class="col-lg-12">
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                        <h3 class="m-portlet__head-text">
                            <?= Yii::t($sectionName,'Create {sectionName}') ?>
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
                <?= $content ?>
            <!--end::Form-->
        </div>
        <!--end::Portlet-->
    </div>

</div>