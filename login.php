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
    // Оригинальные названия полей формы.
    // Используются для проверки целостности формы.
    $originalFieldsNames = [
      'email',
      'password'
    ];

    // Проверка целостности формы.
    // Если заводские поля отсутствуют или присутствуют инородные — отображение ошибки.
    if (isFormIntegrityBroken($originalFieldsNames, $_POST)) {
      $errorMessage = FORM_ERROR_MESSAGE['integrityBroken'];
      require_once('./error.php');
      die();
    }

    // Обрезка обрамляющих пробелов у полей.
    $_POST = trimStringsSpaces($_POST);

    // Валидация поля 'Email' —  должно быть заполнено.
    if (!strlen($_POST['email'])) {
      $errors['email'] = FORM_ERROR_MESSAGE['valueMissing'];
      // Контроль максимальной длины, чтобы не гонять лишние запросы к СУБД
    } else if (strlen($_POST['email']) > MAX_EMAIL_LENGTH) {
      $errors['email'] = FORM_ERROR_MESSAGE['emailTooLong'];
      // Должен иметь валидный формат.
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = FORM_ERROR_MESSAGE['incorrectEmailFormat'];
      // Пользователь с указанным email должен существовать в системе.
    } else if (!doesUserExist($databaseConnection, $_POST['email'])) {
      $errors['email'] = FORM_ERROR_MESSAGE['userNotRegistred'];
    }

    // Валидация поля 'Пароль' —  должно быть заполнено.
    if (!strlen($_POST['password'])) {
      $errors['password'] = FORM_ERROR_MESSAGE['valueMissing'];
    }

    // Получение данных сверяемого польвателя, сверка паролей.
    if (empty($errors)) {
      $comparedUserData = getUser($databaseConnection, $_POST['email']);

      // Если аутентификация пройдена —
      // запись данных пользователя в сессию и редирект на главную страницу.
      if (password_verify($_POST['password'], $comparedUserData['password'])) {
        $_SESSION['user'] = $comparedUserData;
        header('Location: index.php');
      } else {
        $errors['password'] = FORM_ERROR_MESSAGE['incorrectPassword'];
      }
    }
  }

  // Сборка основной раскладки и метаинформации страницы.
  $pageLayout = fillView(VIEW['siteLayout'], [
    'pageTitle' => PAGE_TITLE['login'],

    'pageHeader' => fillView(VIEW['siteHeader']),

    'pageSidebar' => fillView(VIEW['sidebarLogin']),

    'pageContent' => fillView(VIEW['contentLogin'], [
      'errors' => $errors
    ]),

    'pageFooter' => fillView(VIEW['siteFooter'])
  ]);

  // Рендер страницы.
  print($pageLayout);
