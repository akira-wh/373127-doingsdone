<?php
  // Установка таймзоны для Казахстана, г.Алматы.
  date_default_timezone_set('Asia/Almaty');

  // Показывать выполненные задачи? 1 || 0
  $shouldShowCompletedTasks = rand(0, 1);

  // Подключение библиотеки констант:
  // названия страниц, пути и названия шаблонов view, etc.
  require_once('./constants.php');

  // Подключение библиотеки функций-утилит.
  require_once('./utils.php');

  /////////////////////////////////////////////////////////////////////////
  //
  // Сборка и рендер страницы.
  //
  /////////////////////////////////////////////////////////////////////////

  // Получение идентификатора пользователя.
  $userID = intval($_GET['user_id'] ?? 0);

  // Соединение с СУБД.
  $databaseConnection = new mysqli('doingsdone', 'root', '', 'doingsdone');
  $databaseConnection->set_charset('utf-8');

  // Формирование запросов на получение категорий, задач и статистики по ним из СУБД.
  $requestForCategories = "SELECT id, name FROM categories WHERE creator_id = {$userID}";

  $requestForTasks = "SELECT id, name, category_id, deadline, attachment_name, is_complete
                      FROM tasks WHERE creator_id = {$userID}";

  $requestForStatistics = "SELECT category_id, COUNT(category_id) as tasks_number
                            FROM tasks WHERE creator_id = {$userID}
                            GROUP BY category_id";

  // Получение, обработка и сохранение результата запросов к СУБД.
  $categories = getDatabaseData($databaseConnection, $requestForCategories);
  $tasks = getDatabaseData($databaseConnection, $requestForTasks);
  $statistics = getDatabaseData($databaseConnection, $requestForStatistics);

  // Получение названия страницы.
  $pageTitle = PAGES_TITLES['index'];

  // Сборка header.
  $pageHeader = fillView(VIEWS['siteHeader']);

  // Сборка sidebar (список категорий).
  $pageSidebar = fillView(VIEWS['sidebarCategories'], [
    'categories' => $categories,
    'statistics' => $statistics
  ]);

  // Сборка основного контента.
  $pageContent = fillView(VIEWS['contentIndex'], [
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
