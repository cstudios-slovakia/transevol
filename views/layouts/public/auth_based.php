<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>


<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-grid--hor-tablet-and-mobile m-login m-login--6" id="m_login">
        <div class="m-grid__item   m-grid__item--order-tablet-and-mobile-2  m-grid m-grid--hor m-login__aside " style="background-image: url(<?= \yii\helpers\Url::to('@web/images/aerial-shot-aerial-view-architecture-1427107.jpg') ?>);background-position: center;background-size: cover">
            <div class="m-grid__item">
                <div class="m-login__logo">
                    <a href="#">
                        TRANSEVOL
                    </a>
                </div>
            </div>
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver">
                <div class="m-grid__item m-grid__item--middle">
                    <span class="m-login__title"> Lorem ipsum dolor sit  </span>
                    <span class="m-login__subtitle">Lorem ipsum amet estudiat</span>
                </div>
            </div>
            <div class="m-grid__item">
                <div class="m-login__info">
                    <div class="m-login__section">
                        <a href="#" class="m-link">&copy 2018 cstudios - transevol</a>
                    </div>

                </div>
            </div>
        </div>
        <?= $content ?>
    </div>
</div>