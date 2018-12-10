<?php
use yii\helpers\Url;

/** @var \yii\web\User $user */
$user = Yii::$app->user;



?>
<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
        <li class="m-menu__item " aria-haspopup="true">
            <a href="../../../index.html" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-line-graph"></i>
                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text"><?= Yii::t('navigation','Dashboard') ?></span>

										</span>
									</span>
            </a>
        </li>
        <li class="m-menu__section ">
            <h4 class="m-menu__section-text"><?= Yii::t('navigation','Expenses') ?></h4>
            <i class="m-menu__section-icon flaticon-more-v2"></i>
        </li>
        <li class="m-menu__item">
            <a href="{{ Url.toRoute('drivers/index') }}" class="m-menu__link">
                <i class="m-menu__link-icon flaticon-layers"></i>
                <span class="m-menu__link-text"><?= Yii::t('navigation','Expenses settings') ?></span>
            </a>
        </li>
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">


            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-layers"></i>
                <span class="m-menu__link-text"><?= Yii::t('navigation','Driver') ?> </span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">

                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?= Url::toRoute('drivers/index') ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text"><?= Yii::t('navigation','Drivers list') ?></span>
                        </a>
                    </li>

                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?= Url::toRoute('drivers/create') ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text"><?= Yii::t('navigation','Create diver') ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-layers"></i>
                <span class="m-menu__link-text"><?= Yii::t('navigation','Vehicle') ?> </span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">

                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?= Url::toRoute('vehicles/index') ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text"><?= Yii::t('navigation','Vehicles list') ?></span>
                        </a>
                    </li>
                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?= Url::toRoute('vehicles/create') ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text"><?= Yii::t('navigation','Create vehicle') ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="m-menu__item">
            <a href="<?= Url::toRoute('companies/show') ?>" class="m-menu__link">
                <i class="m-menu__link-icon flaticon-layers"></i>
                <span class="m-menu__link-text"><?= Yii::t('navigation','Company expenses') ?></span>
            </a>
        </li>
        <li class="m-menu__section ">
            <h4 class="m-menu__section-text"><?= Yii::t('navigation','Listings') ?></h4>
            <i class="m-menu__section-icon flaticon-more-v2"></i>
        </li>
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">


            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-layers"></i>
                <span class="m-menu__link-text"><?= Yii::t('navigation','Listings') ?> </span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?= Url::toRoute('listings/index?type=services') ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text"><?= Yii::t('navigation','Services list') ?></span>
                        </a>
                    </li>

                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?= Url::toRoute('listings/index?type=clients') ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text"><?= Yii::t('navigation','Clients list') ?></span>
                        </a>
                    </li>

                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?= Url::toRoute('listings/create') ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text"><?= Yii::t('navigation','Create listings record') ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">


            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-layers"></i>
                <span class="m-menu__link-text"><?= Yii::t('navigation','Loads and unloads') ?> </span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">

                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?= Url::toRoute('places/index?type=loading') ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text"><?= Yii::t('navigation','Loads and unloads list') ?></span>
                        </a>
                    </li>

                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?= Url::toRoute('places/create') ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text"><?= Yii::t('navigation','Create un/load place') ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>


        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">


            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-layers"></i>
                <span class="m-menu__link-text"><?= Yii::t('navigation','Tolls') ?> </span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">

                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?= Url::toRoute('places/index?type=toll') ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text"><?= Yii::t('navigation','Tolls list') ?></span>
                        </a>
                    </li>

                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?= Url::toRoute('places/create') ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text"><?= Yii::t('navigation','Create toll') ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <?php if($user->can('companyAdmin')) : ?>
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">


            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-layers"></i>
                <span class="m-menu__link-text"><?= Yii::t('navigation','Users') ?> </span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">

                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="#" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text"><?= Yii::t('navigation','Users list') ?></span>
                        </a>
                    </li>

                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="#" class="m-menu__link ">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text"><?= Yii::t('navigation','Create user') ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <?php endif; ?>
    </ul>
</div>