<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\tests\fixtures\UserFixture;

final class LoginCest
{
  /**
   * Load fixtures before db transaction begin
   * Called in _before()
   * @see \Codeception\Module\Yii2::_before()
   * @see \Codeception\Module\Yii2::loadFixtures()
   */
  public function _fixtures(): array
  {
    return [
      'user' => [
        'class' => UserFixture::class,
      ],
    ];
  }

  public function invalidLoginByUser(FunctionalTester $I): void
  {
    $I->amOnPage('/admin/login/');
    $I->fillField('Username', 'user');
    $I->fillField('Password', '111111');
    $I->click('Login');

    $I->dontSeeLink('Logout');
    $I->see('Incorrect username or password.', '.help-block-error');
  }

  public function loginByAdmin(FunctionalTester $I): void
  {
    $I->amOnPage('/admin/login/');
    $I->fillField('Username', 'admin');
    $I->fillField('Password', '111111');
    $I->click('Login');

    $I->seeLink('Logout');
    $I->dontSee('Login');
    $I->dontSee('Please fill out the following fields to login:');
  }
}
