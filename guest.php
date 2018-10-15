<?php

  // Библиотека констант.
  require_once('./constants.php');

  // Библиотека утилит общего назначения.
  require_once('./utils.php');

  // Если пользователь уже авторизирован — редирект на главную страницу.
  if (isset($_SESSION['user'])) {
    header('Location: /');
  }

  // Сборка основной раскладки и метаинформации страницы.
  $pageLayout = fillView(VIEW['siteLayout'], [
    'pageTitle' => PAGE_TITLE['guest'],
    'pageHeader' => fillView(VIEW['siteHeader']),
    'pageContent' => fillView(VIEW['contentGuest']),
    'pageFooter' => fillView(VIEW['siteFooter'])
  ]);

  // Рендер страницы.
  print($pageLayout);
