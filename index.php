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
  $requestForCategories = "SELECT categories.id,
                                  categories.name,
                                  COUNT(tasks.category_id) as tasks_included
                            FROM categories
                            JOIN tasks ON categories.id = tasks.category_id
                            WHERE categories.creator_id = {$userID}
                            GROUP BY tasks.category_id";

  $requestForTasks = "SELECT tasks.id,
                              tasks.name,
                              tasks.category_id,
                              tasks.deadline,
                              tasks.attachment_name,
                              tasks.attachment_filename,
                              tasks.is_complete
                      FROM tasks
                      JOIN categories ON tasks.category_id = categories.id
                      WHERE categories.creator_id = {$userID}";

  // Получение, обработка и сохранение результата запросов к СУБД.
  $categories = getDatabaseData($databaseConnection, $requestForCategories);
  $tasks = getDatabaseData($databaseConnection, $requestForTasks);

  // Проверка ключа 'category_id' в массиве $_GET.
  //
  // Если пользователь выбрал конкретную категорию —
  // проверка существования данной категории и отрисовка связанных задач.
  //
  // Если не выбрал — отрисовка всех задач.
  // Если задача не существует — статус 404 и завершение скрипта.
  if (isset($_GET['category_id'])) {
    $selectedCategoryID = (integer) $_GET['category_id'];
    $allID = array_column($categories, 'id');

    $hasSelectedCategoryExist = in_array($selectedCategoryID, $allID);
    if (!$hasSelectedCategoryExist) {
      http_response_code(404);
      exit();
    }
  } else {
    $selectedCategoryID = null;
  }

  // Получение названия страницы.
  $pageTitle = PAGES_TITLES['index'];

  // Сборка header.
  $pageHeader = fillView(VIEWS['siteHeader']);

  // Сборка sidebar (список категорий).
  $pageSidebar = fillView(VIEWS['sidebarCategories'], ['categories' => $categories]);

  // Сборка основного контента.
  $pageContent = fillView(VIEWS['contentIndex'], [
    'selectedCategoryID' => $selectedCategoryID,
    'shouldShowCompletedTasks' => $shouldShowCompletedTasks,
    'tasks' => $tasks
  ]);

  // Сборка footer.
  $pageFooter = fillView(VIEWS['siteFooter']);

  // Сборка основной раскладки и метаинформации страницы.
  $pageLayout = fillView(VIEWS['siteLayout'], [
    'pageTitle' => $pageTitle,
    'pageHeader' => $pageHeader,
    'pageSidebar' => $pageSidebar,
    'pageContent' => $pageContent,
    'pageFooter' => $pageFooter
  ]);

  // Рендер страницы.
  print($pageLayout);
