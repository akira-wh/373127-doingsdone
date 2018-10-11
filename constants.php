<?php

  /**
   * Путь к директории с шаблонами view (путь относительный).
   */
  define('VIEWS_DIRECTORY_PATH', './templates/');

  /**
   * Названия шаблонов view.
   */
  define('VIEW', [
    // Основной контент index.html.
    'contentIndex' => 'content-index.php',

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
    // Название index.html.
    'index' => 'Дела в порядке — Главная'
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
