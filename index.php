<?php

  // Установка таймзоны для Казахстана, г.Алматы.
  date_default_timezone_set('Asia/Almaty');

  // Показывать выполненные задачи? 1 || 0
  $shouldShowCompletedTasks = rand(0, 1);

  // Подключение библиотеки констант:
  // названия страниц, пути и названия шаблонов view, etc.
  require_once('./constants.php');

  // Подключение конфигурации СУБД, объекта соединения и связанных утилит.
  require_once('./database-connection-helper.php');

  // Подключение библиотеки функций-утилит общего назначения.
  require_once('./utils.php');

  /////////////////////////////////////////////////////////////////////////
  //
  // Сборка и рендер страницы.
  //
  /////////////////////////////////////////////////////////////////////////

  // Получение идентификатора пользователя.
  $userID = intval($_GET['user_id'] ?? 1);

  // Формирование запросов на получение категорий, задач, и статистики по ним из СУБД.
  $requestForCategories = "SELECT categories.id, categories.name,
                                  COUNT(tasks.category_id) as tasks_included
                            FROM categories
                            JOIN tasks ON categories.id = tasks.category_id
                            WHERE categories.creator_id = {$userID}
                            GROUP BY tasks.category_id";

  $requestForTasks = "SELECT id, name, category_id, deadline,
                              attachment_name, attachment_filename, is_complete
                      FROM tasks
                      WHERE creator_id = {$userID}";

  // Получение, обработка и сохранение результатов запросов к СУБД.
  $categories = downloadData($databaseConnection, $requestForCategories);
  $tasks = downloadData($databaseConnection, $requestForTasks);

  // Внедрение в данные виртуального раздела INBOX (под задачи без категорий).
  plugVirtualInbox($categories, $tasks);

  // Проверка ключа 'category_id' в массиве $_GET.
  //
  // Если выбран виртуальный раздел INBOX — отрисовка задач без категории.
  //
  // Если выбрана пользовательская категория —
  // проверка существования данной категории и отрисовка связанных задач.
  // Если категория не существует — код 404 'NOT FOUND'.
  //
  // Если ни одна категория не выбрана — отрисовка всех задач пользователя.
  if (isset($_GET['category_id'])) {
    if ($_GET['category_id'] === VIRTUAL_CATEGORY_ID['inbox']) {
      $selectedCategoryID = VIRTUAL_CATEGORY_ID['inbox'];
    } else {
      $selectedCategoryID = (integer) $_GET['category_id'];
      $allCategoriesID = array_column($categories, 'id');

      $hasSelectedCategoryExist = in_array($selectedCategoryID, $allCategoriesID);
      if (!$hasSelectedCategoryExist) {
        http_response_code(404);
        exit();
      }
    }
  } else {
    $selectedCategoryID = VIRTUAL_CATEGORY_ID['all'];
  }

  // Название страницы.
  $pageTitle = PAGE_TITLE['index'];

  // Сборка header.
  $pageHeader = fillView(VIEW['siteHeader']);

  // Сборка sidebar (список категорий).
  $pageSidebar = fillView(VIEW['sidebarCategories'], ['categories' => $categories]);

  // Сборка основного контента.
  $pageContent = fillView(VIEW['contentIndex'], [
    'selectedCategoryID' => $selectedCategoryID,
    'shouldShowCompletedTasks' => $shouldShowCompletedTasks,
    'tasks' => $tasks
  ]);

  // Сборка footer.
  $pageFooter = fillView(VIEW['siteFooter']);

  // Сборка основной раскладки и метаинформации страницы.
  $pageLayout = fillView(VIEW['siteLayout'], [
    'pageTitle' => $pageTitle,
    'pageHeader' => $pageHeader,
    'pageSidebar' => $pageSidebar,
    'pageContent' => $pageContent,
    'pageFooter' => $pageFooter
  ]);

  // Рендер страницы.
  print($pageLayout);
