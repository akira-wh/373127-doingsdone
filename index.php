<?php

  // Установка таймзоны для Казахстана, г.Алматы.
  date_default_timezone_set('Asia/Almaty');

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

  // Изменение статуса задачи по клику на чекбоксе.
  if (isset($_GET['task_id']) && isset($_GET['check'])) {
    $selectedTaskID = (integer) $_GET['task_id'];
    $newExecutionStatus = (integer) $_GET['check'];

    if (doesTaskExist($databaseConnection, $userID, $selectedTaskID)) {
      updateTaskStatus($databaseConnection, $userID, $selectedTaskID, $newExecutionStatus);
    }
  }

  // Получение категорий, задач и статистики по ним из БД.
  $categories = getCategories($databaseConnection, $userID);
  $tasks = getTasks($databaseConnection, $userID);
  plugVirtualInbox($categories, $tasks);
  plugStatistic($categories, $tasks);

  // Режим отображения задач (показывать выполненные или нет?).
  // Запись и последующее обновление.
  if (!isset($_GET['show_completed']) && !isset($_SESSION['show_completed_tasks'])) {
    $_SESSION['show_completed_tasks'] = 0;
  } else if (isset($_GET['show_completed'])) {
    $_SESSION['show_completed_tasks'] = (integer) $_GET['show_completed'];
  }

  // Фильтрация списка задач с учетом выбранной категории (проекта).
  // Если категория не выбрана — задачи не фильтруются.
  if (isset($_GET['category_id'])) {
    $userCategoriesID = array_column($categories, 'id');
    $selectedCategoryID = ($_GET['category_id'] === VIRTUAL_CATEGORY_INBOX) ? VIRTUAL_CATEGORY_INBOX :
                                                                              (integer) $_GET['category_id'];

    // Проверка существования выбранной категории у пользователя.
    if (in_array($selectedCategoryID, $userCategoriesID)) {
      $tasks = filterCategoryTasks($selectedCategoryID, $tasks);
    } else {
      http_response_code(404);
      $errorMessage = 'Выбранная категория не найдена.';
      require_once('./error.php');
      die();
    }
  }

  // Фильтрация списка задач с учетом доп.фильтра (задачи на завтра, просроченные, etc).
  // Фильтр активен всегда, поэтому он сохраняется в $_SESSION.
  if (!isset($_GET['filter']) && !isset($_SESSION['tasks_filter'])) {
    $_SESSION['tasks_filter'] = 'all';
  } else {
    switch ($_GET['filter'] ?? $_SESSION['tasks_filter']) {
      case 'today':
        $_SESSION['tasks_filter'] = 'today';
        $tasks = filterTodayTasks($tasks);
        break;
      case 'tomorrow':
        $_SESSION['tasks_filter'] = 'tomorrow';
        $tasks = filterTomorrowTasks($tasks);
        break;
      case 'expired':
        $_SESSION['tasks_filter'] = 'expired';
        $tasks = filterExpiredTasks($tasks);
        break;
      default:
        $_SESSION['tasks_filter'] = 'all';
        break;
    }
  }

  // Сборка основной раскладки и метаинформации страницы.
  $pageLayout = fillView(VIEW['siteLayout'], [
    'pageTitle' => PAGE_TITLE['index'],

    'pageHeader' => fillView(VIEW['siteHeader']),

    'pageSidebar' => fillView(VIEW['sidebarCategories'], [
      'categories' => $categories
    ]),

    'pageContent' => fillView(VIEW['contentIndex'], [
      'tasks' => $tasks
    ]),

    'pageFooter' => fillView(VIEW['siteFooter'])
  ]);

  // Рендер страницы.
  print($pageLayout);
