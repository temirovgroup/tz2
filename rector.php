<?php

/**
 * Конфигурация Rector для PHP 8.3
 *
 * Список всех правил:
 * @see https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md
 */
declare(strict_types=1);

use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\FuncCall\FunctionFirstClassCallableRector;
use Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector;
use Rector\Config\RectorConfig;
use Rector\Php70\Rector\Ternary\TernaryToNullCoalescingRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php80\Rector\NotIdentical\StrContainsRector;
use Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector;
use Rector\Php82\Rector\Param\AddSensitiveParameterAttributeRector;
use Rector\Php83\Rector\ClassConst\AddTypeToConstRector;
use Rector\Set\ValueObject\SetList;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Rector\TypeDeclaration\Rector\ArrowFunction\AddArrowFunctionReturnTypeRector;
use Rector\TypeDeclaration\Rector\Closure\AddClosureVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\Closure\ClosureReturnTypeRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromAssignsRector;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
  ->withPaths([
    __DIR__ . '/frontend',
    __DIR__ . '/backend',
    __DIR__ . '/common',
    __DIR__ . '/console',
  ])
  ->withPhpVersion(PhpVersion::PHP_83)
  ->withSets(
    [
      SetList::CODE_QUALITY,
      SetList::DEAD_CODE,
      SetList::TYPE_DECLARATION,
      SetList::EARLY_RETURN,
      SetList::STRICT_BOOLEANS,
    ],
  )
  ->withRules(rules: [
    AddTypeToConstRector::class, // Добавляет тип к константам
    StrContainsRector::class, // Заменяет strpos на str_contains
    ChangeSwitchToMatchRector::class, // Заменяет switch на match
    ClosureToArrowFunctionRector::class, // Заменяет замыкания на стрелочные функции
    AddSensitiveParameterAttributeRector::class, // Добавляет атрибут #[SensitiveParameter] для параметров, содержащих чувствительные данные
    TernaryToNullCoalescingRector::class,      // Заменяет тернарные операторы на оператор объединения с null (`??`)
    FunctionFirstClassCallableRector::class,   // Преобразует вызовы функций в first-class callable
    StaticArrowFunctionRector::class,          // Делает arrow-функции статическими, если это возможно
    TernaryConditionVariableAssignmentRector::class, // Упрощает тернарные операторы с присваиванием
  ])
  ->withSkip([
    // TypeDeclaration
    ClosureReturnTypeRector::class, // Добавляет тип возвращаемого значения к замыканиям
    AddClosureVoidReturnTypeWhereNoReturnRector::class, // Добавляет тип void к замыканиям, где нет возвращаемого значения
    AddArrowFunctionReturnTypeRector::class, // Добавляет тип возвращаемого значения к стрелочным функциям
    TypedPropertyFromAssignsRector::class, // Добавляет типы свойств на основе присвоений
    // Strict
    DisallowedEmptyRuleFixerRector::class, // Запрещает использование empty()
  ]);

