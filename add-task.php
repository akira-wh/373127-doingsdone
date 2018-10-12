<?php

  // Установка таймзоны для Казахстана, г.Алматы.
  date_default_timezone_set('Asia/Almaty');

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

  // Название страницы.
  $pageTitle = PAGE_TITLE['addTask'];

  // Сборка header.
  $pageHeader = fillView(VIEW['siteHeader']);

  // Сборка sidebar (список категорий).
  $pageSidebar = fillView(VIEW['sidebarCategories'], ['categories' => $categories]);

  // Сборка основного контента.
  $pageContent = fillView(VIEW['contentAddTask']);

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
