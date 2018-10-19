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

  // Если пользователь неавторизирован — редирект на гостевую страницу.
  if (!isset($_SESSION['user'])) {
    header('Location: guest.php');
  }

  // Получение идентификатора пользователя.
  $userID = $_SESSION['user']['id'];

  // Получение категорий, задач и статистики по ним из БД.
  $categories = getCategories($databaseConnection, $userID);
  $tasks = getTasks($databaseConnection, $userID);
  plugVirtualInbox($categories, $tasks);
  plugStatistic($categories, $tasks);

  // Ошибки валидации формы.
  $errors = [];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Оригинальные названия полей формы.
    // Используются для проверки целостности формы.
    $originalFieldsNames = ['name'];

    // Проверка целостности формы.
    // Если заводские поля отсутствуют или присутствуют инородные — отображение ошибки.
    if (isFormIntegrityBroken($originalFieldsNames, $_POST)) {
      $errorMessage = FORM_ERROR_MESSAGE['integrityBroken'];
      require_once('./error.php');
      die();
    }

    // Обрезка обрамляющих пробелов у полей.
    $_POST = trimStringsSpaces($_POST);

    // Валидация поля 'Название категории' —  должно быть заполнено.
    if (!strlen($_POST['name'])) {
      $errors['name'] = FORM_ERROR_MESSAGE['valueMissing'];
      // Длина не должна превышать объем ячейки в таблице пользователей.
    } else if (strlen($_POST['name']) > MAX_CATEGORY_NAME_LENGTH) {
      $errors['name'] = FORM_ERROR_MESSAGE['categoryNameTooLong'];
    }

    // Проверка категории на существование в БД.
    // Категория не должна ранее существовать.
    if (empty($errors)) {
      foreach ($categories as $categoryData) {
        if ($_POST['name'] === $categoryData['name']) {
          $errors['name'] = FORM_ERROR_MESSAGE['categoryAlreadyExist'];
          break;
        }
      }
    }

    // Если форма заполнена корректно — формирование и отправка данных в СУБД.
    if (empty($errors)) {
      // Запись в форму ID пользователя.
      $_POST['creator_id'] = $userID;

      // Сохранение категории и редирект на главную страницу.
      saveCategory($databaseConnection, $_POST);
      header('Location: index.php');
    }
  }

  // Сборка основной раскладки и метаинформации страницы.
  $pageLayout = fillView(VIEW['siteLayout'], [
    'pageTitle' => PAGE_TITLE['addCategory'],

    'pageHeader' => fillView(VIEW['siteHeader']),

    'pageSidebar' => fillView(VIEW['sidebarCategories'], [
      'categories' => $categories
    ]),

    'pageContent' => fillView(VIEW['contentAddCategory'], [
      'errors' => $errors
    ]),

    'pageFooter' => fillView(VIEW['siteFooter'])
  ]);

  // Рендер страницы.
  print($pageLayout);
