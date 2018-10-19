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
      'password',
      'name'
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
      // Длина не должна превышать объем ячейки в таблице пользователей.
    } else if (strlen($_POST['email']) > MAX_EMAIL_LENGTH) {
      $errors['email'] = FORM_ERROR_MESSAGE['emailTooLong'];
      // Должен иметь валидный формат.
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = FORM_ERROR_MESSAGE['incorrectEmailFormat'];
      // Пользователь с указанным email не должен существовать в базе.
    } else if (doesUserExist($databaseConnection, $_POST['email'])) {
      $errors['email'] = FORM_ERROR_MESSAGE['userAlreadyRegistred'];
    }

    // Валидация поля 'Пароль' —  должно быть заполнено.
    if (!strlen($_POST['password'])) {
      $errors['password'] = FORM_ERROR_MESSAGE['valueMissing'];
    }

    // Валидация поля 'Имя пользователя' —  должно быть заполнено.
    if (!strlen($_POST['name'])) {
      $errors['name'] = FORM_ERROR_MESSAGE['valueMissing'];
      // Длина не должна превышать объем ячейки в таблице пользователей.
    } else if (strlen($_POST['name']) > MAX_USERNAME_LENGTH) {
      $errors['name'] = FORM_ERROR_MESSAGE['usernameTooLong'];
    }

    // Если форма заполнена корректно — формирование и отправка данных в СУБД.
    if (empty($errors)) {
      // Запись в форму хеш-пароля пользователя.
      $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

      // Сохранение пользователя и редирект на главную страницу.
      saveUser($databaseConnection, $_POST);
      header('Location: index.php');
    }
  }

  // Сборка основной раскладки и метаинформации страницы.
  $pageLayout = fillView(VIEW['siteLayout'], [
    'pageTitle' => PAGE_TITLE['registration'],

    'pageHeader' => fillView(VIEW['siteHeader']),

    'pageSidebar' => fillView(VIEW['sidebarLogin']),

    'pageContent' => fillView(VIEW['contentRegistration'], [
      'errors' => $errors
    ]),

    'pageFooter' => fillView(VIEW['siteFooter'])
  ]);

  // Рендер страницы.
  print($pageLayout);
