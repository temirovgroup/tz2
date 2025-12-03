<?php

/**
 * Created by PhpStorm.
 */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $model \frontend\models\Order */
/* @var $delivery \common\models\Delivery|null */

$promocode = Yii::$app->cart->getPromocode();

$this->title = 'Сладкоевский - корзина';
?>

<div class="content content_mod-offset">
    <div class="container">
        <div class="content-row">
            <div class="content-col">
                <div class="cart-section cart-data">
                    <?= \frontend\components\CartItemWidget::widget(['cartView' => 'large']) ?>
                </div>
                <?php $form = \yii\widgets\ActiveForm::begin(['id' => 'js-cart-form', 'enableClientValidation' => false]) ?>
                <div class="cart-section">
                    <div class="title title_medium">Контактная информация</div>
                    <div class="cart-fields-row">
                        <div class="cart-fields-row__col cart-fields-row__col_half">
                            <div class="cart-field">
                                <div class="cart-field__title">Имя</div>
                                <div class="cart-field__input">
                                    <?= $form->field($model, 'name')
                                        ->textInput()
                                        ->label(false)
                                        ->error(false)
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="cart-fields-row__col cart-fields-row__col_half">
                            <div class="cart-field">
                                <div class="cart-field__title">Номер телефона</div>
                                <div class="cart-field__input">
                                    <?= $form->field($model, 'phone')
                                        ->widget(\yii\widgets\MaskedInput::class, [
                                            'mask' => '+7 (999) 999 99 99',
                                            'options' => [
                                                'placeholder' => '',
                                                'type' => 'tel',
                                            ],
                                            'clientOptions' => [
                                                'clearIncomplete' => true,
                                            ],
                                        ])
                                        ->label(false)
                                        ->error(false)
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart-section">
                    <div class="title title_medium">Доставка по Москве</div>
                    <div class="cart-fields-row">
                        <div class="cart-fields-row__col">
                            <div class="cart-field">
                                <div class="cart-field__title">Улица</div>
                                <div class="cart-field__input">
                                    <?= $form->field($model, 'street')
                                        ->textInput()
                                        ->label(false)
                                        ->error(false)
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="cart-fields-row__col cart-fields-row__col_half">
                            <div class="cart-field">
                                <div class="cart-field__title">Дом</div>
                                <div class="cart-field__input">
                                    <?= $form->field($model, 'home')
                                        ->textInput()
                                        ->label(false)
                                        ->error(false)
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="cart-fields-row__col cart-fields-row__col_half">
                            <div class="cart-field">
                                <div class="cart-field__title">Квартира / Офис</div>
                                <div class="cart-field__input">
                                    <?= $form->field($model, 'apart')
                                        ->textInput()
                                        ->label(false)
                                        ->error(false)
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart-section">
                    <div class="cart-section__block">
                        <div class="title title_medium">Дата доставки</div>
                        <div class="cart-fields-row" id="fofofo">
                            <div class="cart-fields-row__col cart-fields-row__col_half">
                                <div class="cart-field">
                                    <div class="cart-field__title">День</div>
                                    <div class="select">
                                        <select name="Order[delivery_date]">
                                            <?php foreach (Yii::$app->collector->dateWord(40) as $item) : ?>
                                                <option value="<?= $item[0] ?>"><?= $item[1] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cart-section__block">
                        <div class="title title_medium">Оплата</div>
                        <div class="pay-row">
                            <div class="pay-row__item">
                                <label class="radio-btn">
                                    <input type="radio" name="select-pay" value="<?= $model::PAYMENT_TYPE_CARD ?>" hidden checked>
                                    <span class="radio-btn__icon"></span>
                                    <span>Картой на сайте</span>
                                </label>
                            </div>
                            <div class="pay-row__item">
                                <label class="radio-btn">
                                    <input type="radio" name="select-pay" value="<?= $model::PAYMENT_TYPE_CASH ?>" hidden>
                                    <span class="radio-btn__icon"></span>
                                    <span>Наличными</span>
                                </label>
                            </div>
                            <?= $form->field($model, 'payment_type')
                                ->hiddenInput(['value' => $model::PAYMENT_TYPE_CARD])
                                ->label(false)
                                ->error(false)
                            ?>
                        </div>
                        <?= $form->field($model, 'payment_type')
                            ->hiddenInput(['value' => $model::PAYMENT_TYPE_CARD])
                            ->label(false)
                            ->error(false)
                        ?>
                    </div>
                    <div class="cart-section__block">
                        <div class="cart-field js-toggle-container">
                            <div class="cart-field__title title-expand">
                                <span class="js-toggle-btn title-expand__inner">Комментарий к заказу
                                    <span class="icon icon-expand"></span>
                                </span>
                            </div>
                            <div class="cart-field__input js-toggle-content">
                                <?= $form->field($model, 'comment')
                                    ->textarea()
                                    ->label(false)
                                    ->error(false)
                                ?>
                            </div>
                        </div>
                    </div>

                    <?= $form->field($model, 'cid')->hiddenInput()->label(false)->error(false) ?>

                    <div class="cart-submit">
                        <?= Html::submitButton('Оформить заказ', [
                            'class' => 'btn btn-main',
                        ]) ?>
                    </div>

                    <!--<div class="submit-noty required-field">
                        Пожалуйста, заполните обязательные поля.
                    </div>

                    <div class="submit-noty min-delivery">
                        *Минимальная сумма заказа <?/*= Yii::$app->collector->numFormat($delivery->min_sum) */?> ₽
                    </div>-->
                </div>
                <?php \yii\widgets\ActiveForm::end() ?>
                <div class="text-policy">ННажимая “Офрмить заказ”, вы даете
                    <a href="docs/politics_of_privacy.pdf">Согласие</a> на обработку ваших персональных данные и принимаете
                    <a href="docs/user_agreement.pdf">Пользовательское соглашение</a>
                </div>
            </div>
            <div class="side-col side-col-promocode">
                <div id="side-block-wrap" class="side-block-wrap">
                    <div class="side-block">
                        <div class="form-promocode <?= $promocode->sale ? 'applied' : '' ?>">
                            <div class="form-promocode__input">
                                <input type="text" value="<?= $promocode->code ?>" placeholder="Введите промокод">
                            </div>
                            <button class="btn form-promocode__btn">
                                <svg class="icon">
                                    <use xlink:href="img/symbol/sprite.svg#right-arrow"></use>
                                </svg>
                            </button>
                            <span class="btn form-promocode__hide">
                            <svg class="icon">
                                <use xlink:href="img/symbol/sprite.svg#close"></use>
                            </svg>
                        </span>
                            <div class="form-promocode__info">
                                <?= $promocode->sale ? "Скидка на заказ: {$promocode->sale} &#8381;" : '' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
