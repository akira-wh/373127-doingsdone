<?php

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
    header('Location: /');
  }

  // Ошибки валидации формы.
  $errors = [];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Список полей, обязательных к заполнению.
    $requiredFields = [
      'email',
      'password'
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

    // Получение данных сверяемого польвателя и сверка email.
    if (empty($errors)) {
      $comparedUserData = getUser($databaseConnection, $_POST['email']);

      $isComparedUserExist = (boolean) $comparedUserData;
      if (!$isComparedUserExist) {
        $errors['email'] = 'Указанный email не зарегистрирован в системе';
      }
    }

    // Сверка паролей.
    if (empty($errors)) {
      $isPasswordCorrest = password_verify($_POST['password'], $comparedUserData['password']);
      if (!$isPasswordCorrest) {
        $errors['password'] = 'Вы ввели неверный пароль';
      }
    }

    // Если аутентификация пройдена —
    // открытие сессии и редирект на главную страницу.
    if (empty($errors)) {
      session_start();
      $_SESSION['user'] = $comparedUserData;
      header('Location: /');
    }
  }

  // Сборка основной раскладки и метаинформации страницы.
  $pageLayout = fillView(VIEW['siteLayout'], [
    'pageTitle' => PAGE_TITLE['login'],
    'pageHeader' => fillView(VIEW['siteHeader']),
    'pageSidebar' => fillView(VIEW['sidebarLogin']),
    'pageContent' => fillView(VIEW['contentLogin'], ['errors' => $errors]),
    'pageFooter' => fillView(VIEW['siteFooter'])
  ]);

  // Рендер страницы.
  print($pageLayout);
