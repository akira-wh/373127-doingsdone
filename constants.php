<?php

  /**
   * Путь к директории с шаблонами view (путь относительный).
   */
  define('VIEWS_DIRECTORY_PATH', './templates/');

  /**
   * Названия шаблонов view.
   */
  define('VIEW', [
    // Контент главной страницы.
    'contentIndex' => 'content-index.php',

    // Контент страницы добавления задач.
    'contentAddTask' => 'content-add-task.php',

    // Сайдбар со списком категорий (проектов).
    'sidebarCategories' => 'sidebar-categories.php',

    // Сетка-каркас всех страниц сайта.
    'siteLayout' => 'site-layout.php',

    // Header сайта.
    'siteHeader' => 'site-header.php',

    // Footer сайта.
    'siteFooter' => 'site-footer.php'
  ]);

  /**
   * Названия страниц сайта.
   */
  define('PAGE_TITLE', [
    // Главная страница.
    'index' => 'Главная',

    // Страница добавления задач.
    'addTask' => 'Добавление задачи'
  ]);

  /**
   * Количество секунд в 1 часе (3600).
   */
  define('SECONDS_IN_HOUR', 3600);

  /**
   * Количество часов в сутках (24).
   */
  define('TWENTY_FOUR_HOURS', 24);

  /**
   * Названия виртуальных разделов (категорий задач).
   */
  define('VIRTUAL_CATEGORY_ID', [
    'inbox' => 'inbox',
    'all' => 'all'
  ]);
