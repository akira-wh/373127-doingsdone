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

  // Ошибки валидации формы.
  $errors = [];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Список полей, обязательных к заполнению.
    $requiredFields = [
      'email',
      'password',
      'name'
    ];

    foreach ($requiredFields as $field) {
      if (!strlen($_POST[$field])) {
        $errors[$field] = 'Это поле необходимо заполнить';
      } else if ($field === 'email' && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Укажите корректный email';
      }
    }

    if (empty($errors)) {
      $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

      $isUserRegistred = downloadData($databaseConnection, getCheckUserRequest($_POST['email']));
      $isUserRegistred = $isUserRegistred[0]['is_registred'];

      if ($isUserRegistred) {
        $errors['email'] = 'Данный email уже зарегистрирован в системе. Укажите другой email.';
      } else {
        // Отправка данных и автопереход на главную страницу.
        uploadData($databaseConnection, getAddUserRequest($_POST), $_POST);
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
