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
                        <h3 class="m-portlet__head-text text-uppercase">
                            <?= Yii::t('common/pages/create','Create {sectionName}', [
                                'sectionName' => Yii::t('vehicle','Create vehicle')
                            ]) ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <?php if (isset($this->blocks['action_btn_single'])): ?>
                            <?= $this->blocks['action_btn_single'] ?>
                        <?php endif; ?>
                        <?php if (isset($this->blocks['action_btn_multi'])): ?>
                            <?= $this->blocks['action_btn_multi'] ?>
                        <?php endif; ?>

                        <?php if (isset($this->blocks['action_btn_dropdown'])): ?>

                        <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                            <a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon m-dropdown__toggle">
                                <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="m-dropdown__wrapper" style="z-index: 101;">
                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="left: auto; right: 16.5px;"></span>
                                <div class="m-dropdown__inner">
                                    <div class="m-dropdown__body">
                                        <div class="m-dropdown__content">
                                            <ul class="m-nav">
                                                <li class="m-nav__section m-nav__section--first">
                                                    <span class="m-nav__section-text"><?= Yii::t('common/pages/create','Navigation options') ?></span>
                                                </li>
                                                <?= $this->blocks['action_btn_dropdown'] ?>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <!--begin::Form-->
                <?= $content ?>
            <!--end::Form-->
        </div>
        <!--end::Portlet-->
    </div>

</div>