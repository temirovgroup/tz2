<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

// Создаем Finder для указания файлов и директорий, которые нужно форматировать
$finder = Finder::create()
  ->in([
    __DIR__ . '/frontend', // Директория frontend
    __DIR__ . '/backend',   // Директория backend
    __DIR__ . '/common',    // Директория common
    __DIR__ . '/console',   // Директория console
  ])
  ->exclude('messages')   // Исключаем папку messages
  ->append([
    __FILE__,             // Включаем текущий файл конфигурации
  ])
  ->name('*.php');        // Применять только к PHP-файлам

// Создаем конфигурацию
$config = (new Config())
  ->setFinder($finder) // Указываем Finder
  ->setCacheFile(__DIR__ . '/runtime/' . basename(__FILE__) . '.cache') // Указываем файл кэша
  ->setRiskyAllowed(true) // Разрешаем использование рискованных правил
  ->setRules([
    // Группы правил
    '@PSR12' => true, // Использовать стандарт PSR-12
    '@PHP83Migration' => true, // Включает правила для миграции на PHP 8.3
    '@PhpCsFixer' => true, // Включает стандартные правила PHP-CS-Fixer
    '@PER-CS2.0' => true, // Включает правила стандарта PER-CS 2.0

    // Отдельные правила
    'blank_line_before_statement' => ['statements' => [
      'continue', // Пустая строка перед continue
      'declare',  // Пустая строка перед declare
      'default',  // Пустая строка перед default
      'return',   // Пустая строка перед return
      'throw',    // Пустая строка перед throw
      'try',      // Пустая строка перед try
      'while',    // Пустая строка перед while
    ]],
    'increment_style' => false,
    'blank_line_between_import_groups' => false, // Отключает пустую строку между группами импортов
    'function_declaration' => ['closure_function_spacing' => 'one'],
    'semicolon_after_instruction' => false, // Не добавляем точку с запятой после инструкций
    'no_alternative_syntax' => false, // Сохраняем альтернативный синтаксис
    'class_attributes_separation' => [
      'elements' => [
        'case' => 'only_if_meta', // Пустая строка для case только с аннотациями
        'const' => 'only_if_meta', // Пустая строка для const только с аннотациями
        'method' => 'one', // Одна пустая строка между методами
        'property' => 'one', // Одна пустая строка между свойствами
        'trait_import' => 'only_if_meta', // Пустая строка для trait_import только с аннотациями
      ],
    ],
    'method_chaining_indentation' => false, // Отключает отступы для цепочек методов
    'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'], // Удаляет пробелы перед точкой с запятой в многострочных выражениях
    'no_superfluous_phpdoc_tags' => ['remove_inheritdoc' => true], // Удаляет избыточные теги PHPDoc
    'no_trailing_whitespace_in_string' => false, // Отключает удаление пробелов в конце строк внутри строковых литералов
    'nullable_type_declaration_for_default_null_value' => true, // Добавляет `?` к типам, если параметр имеет значение по умолчанию `null`
    'ordered_class_elements' => ['order' => ['use_trait']], // Упорядочивает элементы класса (только use_trait)
    'ordered_imports' => ['imports_order' => ['class', 'function', 'const']], // Упорядочивает импорты: сначала классы, затем функции, затем константы
    'ordered_types' => ['sort_algorithm' => 'none'], // Отключает сортировку типов в аннотациях
    'php_unit_internal_class' => false, // Отключает добавление аннотации `@internal` для классов PHPUnit
    'php_unit_strict' => false, // Отключает использование строгих сравнений в PHPUnit
    'php_unit_test_class_requires_covers' => false, // Отключает требование аннотации `@covers` для тестовых классов
    'phpdoc_add_missing_param_annotation' => false, // Отключает автоматическое добавление тегов `@param` в PHPDoc
    'phpdoc_align' => false, // Отключает выравнивание тегов PHPDoc
    'phpdoc_no_alias_tag' => ['replacements' => [
      'property-write' => 'property', // Заменяет `property-write` на `property`
      'type' => 'var', // Заменяет `type` на `var`
      'link' => 'see', // Заменяет `link` на `see`
    ]],
    'phpdoc_to_comment' => false, // Отключает преобразование PHPDoc в обычные комментарии
    'phpdoc_types_order' => false, // Отключает сортировку типов в PHPDoc
    'return_assignment' => false, // Отключает предупреждения о возврате результата присваивания

    'trailing_comma_in_multiline' => ['after_heredoc' => true, 'elements' => ['arrays', 'arguments', 'parameters']], // Добавляет trailing запятую в многострочных массивах, аргументах и параметрах
    'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false], // Отключает стиль Yoda (например, `if (42 === $value)`)

    // Дополнительные правила
    'indentation_type' => true, // Использовать пробелы для отступов
    'array_indentation' => true, // Отступы для массивов
    'binary_operator_spaces' => [
      'default' => 'single_space', // Один пробел вокруг бинарных операторов
    ],
    'single_blank_line_at_eof' => false, // Не добавлять пустую строку в конце файла
    'final_class' => false, // Не делать все классы final
    'void_return' => false, // Не добавлять : void к методам без возвращаемого значения
    'final_public_method_for_abstract_class' => false, // Не делать public-методы final в абстрактных классах
    'single_space_around_construct' => true, // Один пробел вокруг управляющих конструкций (if, for, foreach и т.д.)
    'control_structure_braces' => true, // Фигурные скобки для управляющих конструкций
    'control_structure_continuation_position' => false, // Не переносить управляющие конструкции на новую строку
    'declare_parentheses' => true, // Скобки вокруг выражений в declare
    'no_multiple_statements_per_line' => true, // Запретить несколько операторов на одной строке
    'statement_indentation' => true, // Отступы для операторов
    'heredoc_indentation' => false,
    'no_extra_blank_lines' => true, // Удалять лишние пустые строки
    'concat_space' => [
      'spacing' => 'one', // Один пробел вокруг точки конкатенации
    ],
    'echo_tag_syntax' => ['format' => 'short'], // Использовать короткий синтаксис <?= вместо <?php echo
    'declare_strict_types' => false, // Не добавлять declare(strict_types=1)
    'native_function_invocation' => false, // Не добавлять \ перед встроенными функциями (например, count, strlen)
    'no_unused_imports' => true, // Удалять неиспользуемые импорты
    'no_trailing_whitespace' => true, // Удалять пробелы в конце строк
    'no_whitespace_in_blank_line' => true, // Удалять пробелы в пустых строках
    'single_import_per_statement' => true, // Один импорт на строку
    'single_line_after_imports' => true, // Одна пустая строка после импортов
    'no_break_comment' => false, // Не добавлять комментарии к break
    'no_spaces_around_offset' => true, // Убрать пробелы вокруг смещений в массивах
    'no_trailing_comma_in_singleline' => true, // Убрать trailing запятую в однострочных массивах
    'no_whitespace_before_comma_in_array' => true, // Убрать пробелы перед запятыми в массивах
    'trim_array_spaces' => true, // Убрать пробелы вокруг элементов массива
    'whitespace_after_comma_in_array' => true, // Пробел после запятой в массивах
    'type_declaration_spaces' => true, // Пробелы вокруг двоеточия в типах
    'single_line_comment_style' => [
      'comment_types' => ['hash'], // Использовать # для однострочных комментариев
    ],
    'fully_qualified_strict_types' => false, // Не использовать полные имена для типов
    'global_namespace_import' => false, // Не импортировать из глобального пространства имен
    'no_leading_import_slash' => true, // Убрать ведущий слэш в импортах
    'no_unneeded_import_alias' => true, // Убрать ненужные алиасы импортов
    'phpdoc_indent' => true, // Отступы для PHPDoc
    'phpdoc_inline_tag_normalizer' => true, // Нормализация inline-тегов в PHPDoc
    'phpdoc_no_access' => true, // Убрать теги @access
    'phpdoc_order' => true, // Порядок тегов в PHPDoc
    'phpdoc_scalar' => true, // Использовать скалярные типы в PHPDoc
    'phpdoc_separation' => false, // Отключает разделение тегов в PHPDoc
    'phpdoc_single_line_var_spacing' => true, // Пробелы в однострочных PHPDoc
    'phpdoc_summary' => false,  // Точки не обязательны в PHPDoc
    'phpdoc_trim' => true, // Убрать лишние пробелы в PHPDoc
    'phpdoc_types' => true, // Использовать правильные типы в PHPDoc
    'phpdoc_var_without_name' => true, // Разрешить @var без имени переменной
    'heredoc_to_nowdoc' => false, // Отключить преобразование HEREDOC в NOWDOC
  ])
  ->setIndent('  ') // Использовать 2 пробела для отступов
  ->setLineEnding("\n"); // Использовать Unix-стиль окончания строк

return $config;
