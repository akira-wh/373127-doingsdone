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

  // Соединение с СУБД.
  $databaseConnection = new mysqli('doingsdone', 'root', '', 'doingsdone');
  $databaseConnection->set_charset('utf-8');

  // Формирование запросов на получение категорий и задач из БД.
  // Получение, обработка и сохранение результата запросов к СУБД.
  $requestForCategories = 'SELECT id, name FROM categories WHERE creator_id = 4';
  $categories = getDatabaseData($databaseConnection, $requestForCategories);

  $requestForTasks = 'SELECT name, category_id, deadline, attachment_name, is_complete
                      FROM tasks WHERE creator_id = 4';
  $tasks = getDatabaseData($databaseConnection, $requestForTasks);

  // Получение названия страницы.
  $pageTitle = PAGES_TITLES['index'];

  // Сборка header.
  $pageHeader = fillView(VIEWS['siteHeader']);

  // Сборка sidebar (список категорий).
  $pageSidebar = fillView(VIEWS['sidebarCategories'], [
    'categories' => $categories,
    'tasks' => $tasks
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
