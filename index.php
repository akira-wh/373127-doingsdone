<?php
  // Установка таймзоны для Казахстана, г.Алматы.
  date_default_timezone_set('Asia/Almaty');

  // Показывать выполненные задачи? 1 || 0
  $shouldShowCompletedTasks = rand(0, 1);

  // Подключение вспомогательной библиотеки данных:
  // названия страниц, пути шаблонов view, категории, задачи etc.
  require_once('./data.php');

  // Подключение библиотеки функций-утилит.
  require_once('./utils.php');

  /////////////////////////////////////////////////////////////////////////
  //
  // Сборка и рендер страницы.
  //
  /////////////////////////////////////////////////////////////////////////

  // Получение названия страницы.
  $pageTitle = $pagesTitles['index'];

  // Сборка header.
  $pageHeader = fillView($views['siteHeader']);

  // Сборка sidebar (список категорий).
  $pageSidebar = fillView($views['sidebarCategories'], [
    'categories' => $categories,
    'tasks' => $tasks
  ]);

  // Сборка основного контента.
  $pageContent = fillView($views['contentIndex'], [
    'shouldShowCompletedTasks' => $shouldShowCompletedTasks,
    'tasks' => $tasks
  ]);

  // Сборка footer.
  $pageFooter = fillView($views['siteFooter']);

  // Сборка основной раскладки и метаинформации страницы.
  $pageLayout = fillView($views['siteLayout'], [
    'pageTitle' => $pageTitle,
    'pageHeader' => $pageHeader,
    'pageSidebar' => $pageSidebar,
    'pageContent' => $pageContent,
    'pageFooter' => $pageFooter
  ]);

  // Рендер страницы.
  print($pageLayout);
?>
