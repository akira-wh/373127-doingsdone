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

  // Запись и последующее обновление режима отображения задач (показывать выполненные?).
  if (!isset($_GET['show_completed']) && !isset($_SESSION['show_completed_tasks'])) {
    $_SESSION['show_completed_tasks'] = 0;
  } else if (isset($_GET['show_completed'])) {
    $_SESSION['show_completed_tasks'] = (integer) $_GET['show_completed'];
  }

  // Изменение статуса задачи по клику на чекбоксе.
  if (isset($_GET['task_id']) && isset($_GET['check'])) {
    $taskID = (integer) $_GET['task_id'];
    $taskExecutionStatus = (integer) $_GET['check'];

    $isTaskExist = (boolean) getTask($databaseConnection, $userID, $taskID);
    if ($isTaskExist) {
      updateTaskStatus($databaseConnection, $userID, $taskID, $taskExecutionStatus);
    } else {
      header('Location: index.php');
    }
  }

  // Получение категорий, задач и статистики по ним из БД.
  $categories = getCategories($databaseConnection, $userID);
  $tasks = getTasks($databaseConnection, $userID);
  plugVirtualInbox($categories, $tasks);
  plugStatistic($categories, $tasks);

  // Проверка ключа 'category_id' в массиве $_GET.
  //
  // Если ничего не выбрано — отрисовка всех задач.
  //
  // Если выбран виртуальный раздел INBOX — отрисовка задач без категории.
  //
  // Если выбрана пользовательская категория — проверка существования категории.
  // Если категория существует — отрисовка связанных задач. Иначе код 404.
  //
  $selectedCategoryID = null;

  if (isset($_GET['category_id'])) {
    switch ($_GET['category_id']) {
      case VIRTUAL_CATEGORY_INBOX:
        $selectedCategoryID = VIRTUAL_CATEGORY_INBOX;
        break;

      default:
        $selectedCategoryID = (integer) $_GET['category_id'];
        $allCategoriesID = array_column($categories, 'id');
        $hasSelectedCategoryExist = in_array($selectedCategoryID, $allCategoriesID);

        if (!$hasSelectedCategoryExist) {
          http_response_code(404);
          $errorMessage = 'Выбранная категория не найдена.';
          require_once('./error.php');
        }
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
      'selectedCategoryID' => $selectedCategoryID,
      'shouldShowCompletedTasks' => $_SESSION['show_completed_tasks'],
      'tasks' => $tasks
    ]),

    'pageFooter' => fillView(VIEW['siteFooter'])
  ]);

  // Рендер страницы.
  print($pageLayout);
