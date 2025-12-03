<?php

/**
 * Created by PhpStorm.
 */

/* @var $this \yii\web\View */
/* @var $model \frontend\models\Order */
/* @var $delivery \common\models\Delivery|null */

use yii\helpers\Html;

$this->title = 'Сладкоевский - корзина';
?>

<div class="cart-page-wrap"></div>

<?php if (Yii::$app->request->post('isSmall') !== '1') : ?>
  <div class="cart-form-wrap cart-field__input">
    <?php $form = \yii\widgets\ActiveForm::begin(['action' => \yii\helpers\Url::to(['/site/cart']), 'id' => 'js-cart-form']) ?>

    <div class="main-row">
      <div class="main-col-2">
        <?= $form->field($model, 'name')
          ->textInput(['placeholder' => 'Расул'])
          ->error(false)
        ?>
      </div>
      <div class="main-col-2">
        <?= $form->field($model, 'phone')
          ->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '+7 (999) 999 99 99',
            'options' => [
              'placeholder' => '+7',
              'type' => 'tel',
            ],
            'clientOptions' => [
              'clearIncomplete' => true,
            ],
          ])
          ->error(false)
        ?>
      </div>
    </div>

    <p class="city-label">г. Черкесск</p>

    <?= $form->field($model, 'street')
      ->textInput(['placeholder' => 'Ленина'])
      ->error(false)
    ?>

    <div class="main-row">
      <div class="main-col-4">
        <?= $form->field($model, 'house')
          ->textInput(['placeholder' => '12А'])
          ->error(false)
        ?>
      </div>
      <div class="main-col-4 entrance-col">
        <div class="hide-is-private-house">
          <?= $form->field($model, 'entrance')
            ->textInput(['placeholder' => '2'])
            ->error(false)
          ?>
        </div>
        <div class="cart-checkbox-wrap">
          <?= $form->field($model, 'private_house')
            ->checkbox(['label' => 'Частный дом',
              'class' => 'private-house-checkbox',
            ])
            ->error(false)
          ?>
        </div>
      </div>
      <div class="main-col-4">
        <div class="hide-is-private-house">
          <?= $form->field($model, 'floor')
            ->textInput(['placeholder' => '3'])
            ->error(false)
          ?>
        </div>
      </div>
      <div class="main-col-4">
        <div class="hide-is-private-house">
          <?= $form->field($model, 'kv')
            ->textInput([
              'placeholder' => '45',
              'class' => 'hide-is-private-house'])
            ->error(false)
          ?>
        </div>
      </div>
    </div>

    <?= $form->field($model, 'comment')
      ->textarea([
        'rows' => 6,
        'placeholder' => 'Комментарий к заказу',
      ])
      ->error(false)
    ?>

    <div class="btn-group">
      <?= Html::submitButton('Оформить заказ', [
        'class' => 'btn btn-main',
      ]) ?>

      <div class="submit-noty required-field">
        Пожалуйста, заполните обязательные поля.
      </div>

      <div class="submit-noty min-delivery">
        *Минимальная сумма заказа: <?= Yii::$app->collector->numFormat($delivery->min_sum) ?> ₽
      </div>

      <div class="text-policy">Нажимая “Офрмить заказ”, вы даете
        <a target="_blank" href="docs/politics_of_privacy.pdf">Согласие</a> на обработку ваших персональных данные и принимаете
        <a target="_blank" href="docs/user_agreement.pdf">Пользовательское соглашение</a>
      </div>
    </div>

    <?php \yii\widgets\ActiveForm::end() ?>
  </div>

  <div class="promocode-wrapper hidden">
    <div class="promocode-wrap">
      <img class="close-promocode-btn" src="/img/close-icon.png" alt="X">
      <input id="promocode-field" type="text" placeholder="Введите промокод">
      <button class="apply-promocode">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 448.011 448.011" style="enable-background:new 0 0 448.011 448.011;" xml:space="preserve">
                <g>
                  <g>
                    <path d="M438.731,209.463l-416-192c-6.624-3.008-14.528-1.216-19.136,4.48c-4.64,5.696-4.8,13.792-0.384,19.648l136.8,182.4    l-136.8,182.4c-4.416,5.856-4.256,13.984,0.352,19.648c3.104,3.872,7.744,5.952,12.448,5.952c2.272,0,4.544-0.48,6.688-1.472    l416-192c5.696-2.624,9.312-8.288,9.312-14.528S444.395,212.087,438.731,209.463z"/>
                  </g>
                </g>
            </svg>
      </button>
    </div>
  </div>
<?php endif; ?>
