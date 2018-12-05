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

                <div class="m-portlet__body">
                    <?= $content ?>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <button type="reset" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>

            <!--end::Form-->
        </div>

        <!--end::Portlet-->


    </div>

</div>