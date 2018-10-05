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

  // Соединение с БД.
  $databaseConnection = mysqli_connect('doingsdone', 'root', '', 'doingsdone');
  mysqli_set_charset($databaseConnection, 'uft8');

  // Формирование запросов на получение списка категорий и задач из БД.
  $requestForCategories = 'SELECT categories.id, categories.name FROM categories
                          JOIN users ON categories.creator_id = users.id
                          WHERE users.id = 4; ';

  $requestForTasks = 'SELECT tasks.name,
                              tasks.category_id,
                              tasks.deadline,
                              tasks.attachment_name,
                              tasks.is_complete FROM tasks
                      JOIN categories ON tasks.category_id = categories.id
                      JOIN users ON categories.creator_id = users.id
                      WHERE users.id = 4; ';

  // Отправка запроса.
  $request = mysqli_multi_query($databaseConnection, $requestForCategories.$requestForTasks);

  // Получение, обработка и сохранение результата запроса.
  $expectedResults = 2;
  while ($expectedResults) {
    mysqli_next_result($databaseConnection);
    $receivedData = mysqli_store_result($databaseConnection);

    if ($receivedData) {
      switch ($expectedResults) {
        case 2:
          $categories = mysqli_fetch_all($receivedData, MYSQLI_ASSOC);
          break;
        case 1:
          $tasks = mysqli_fetch_all($receivedData, MYSQLI_ASSOC);
          break;
      }
    }

    $expectedResults--;
  }

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
