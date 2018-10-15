<?php

  // Сессия.
  require_once('./session.php');

  // Библиотека констант.
  require_once('./constants.php');

  // Настройки и утитлиты для работы с моделью.
  require_once('./model-workers.php');

  // Библиотека утилит общего назначения.
  require_once('./utils.php');

  /////////////////////////////////////////////////////////////////////////
  //
  // Сборка и рендер страницы.
  //
  /////////////////////////////////////////////////////////////////////////

  // Если пользователь уже авторизирован — редирект на главную страницу.
  if (isset($_SESSION['user'])) {
    header('Location: index.php');
  }

  // Ошибки валидации формы.
  $errors = [];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Список полей, обязательных к заполнению.
    $requiredFields = [
      'email',
      'password',
      'name'
    ];

    // Валидация полей.
    foreach ($requiredFields as $field) {
      // Проверка на заполненность.
      if (!strlen($_POST[$field])) {
        $errors[$field] = 'Это поле необходимо заполнить';
        // Проверка email адреса на валидность.
      } else if ($field === 'email' && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Укажите корректный email';
      }
    }

    if (empty($errors)) {
      // Проверка пользователя на существование в БД.
      $isUserRegistred = (boolean) getUser($databaseConnection, $_POST['email']);

      if ($isUserRegistred) {
        $errors['email'] = 'Данный email уже зарегистрирован в системе. Укажите другой email.';
      } else {
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Сохранение пользователя и редирект на главную страницу.
        saveUser($databaseConnection, $_POST);
        header('Location: index.php');
      }
    }
  }

  // Сборка основной раскладки и метаинформации страницы.
  $pageLayout = fillView(VIEW['siteLayout'], [
    'pageTitle' => PAGE_TITLE['registration'],
    'pageHeader' => fillView(VIEW['siteHeader']),
    'pageSidebar' => fillView(VIEW['sidebarLogin']),
    'pageContent' => fillView(VIEW['contentRegistration'], ['errors' => $errors]),
    'pageFooter' => fillView(VIEW['siteFooter'])
  ]);

  // Рендер страницы.
  print($pageLayout);
