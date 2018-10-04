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

  // Получение названия страницы.
  $pageTitle = PAGES_TITLES['index'];

  // Сборка header.
  $pageHeader = fillView(VIEWS['siteHeader']);

  // Открытие соединения с БД.
  $databaseConnection = mysqli_connect('doingsdone', 'root', '', 'doingsdone');
  mysqli_set_charset($databaseConnection, 'uft8');

  // Формирование запроса на получение списка категорий из БД.
  $requestString = 'SELECT categories.id, categories.name FROM categories
                    JOIN users ON categories.creator_id = users.id
                    WHERE users.id = 4';

  // Отправка запроса.
  $requestForCategories = mysqli_query($databaseConnection, $requestString);

  // Парсинг полученных данных из БД.
  $categories = mysqli_fetch_all($requestForCategories, MYSQLI_ASSOC);

  // Формирование запроса на получение списка задач из БД.
  $requestString = 'SELECT tasks.name,
                            tasks.category_id,
                            tasks.deadline,
                            tasks.attachment_name,
                            tasks.is_complete FROM tasks
                    JOIN categories ON tasks.category_id = categories.id
                    JOIN users ON categories.creator_id = users.id
                    WHERE users.id = 4';

  // Отправка запроса.
  $requestForTasks = mysqli_query($databaseConnection, $requestString);

  // Парсинг полученных данных из БД.
  $tasks = mysqli_fetch_all($requestForTasks, MYSQLI_ASSOC);

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
