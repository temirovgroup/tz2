<?php
return [
  // лимит на запросы к апи в час
  // общий лимит (используется, если нет лимита для юзера)
  'apiHourLimit' => 1000000,
  // конкретно для юзера
  'apiHourLimitByProfile' => [],
  // аналогичные лимиты чисто на сторис
  'apiHourStoriesLimit' => 1000000,
  'apiHourStoriesLimitByProfile' => [],
];
