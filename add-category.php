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
    // Защита строк от влияния обрамляющих пробелов.
    $_POST['name'] = trim($_POST['name']);

    // Проверка на заполненность.
    if (!strlen($_POST['name'])) {
      $errors['name'] = 'Придумайте название проекта';
    }

    // Проверка категории на существование в БД.
    if (empty($errors)) {
      foreach ($categories as $categoryData) {
        if ($categoryData['name'] === $_POST['name']) {
          $errors['name'] = 'Данная категория уже существует';
          break;
        }
      }
    }

    // Если валидация пройдена — отправка данных в СУБД.
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
