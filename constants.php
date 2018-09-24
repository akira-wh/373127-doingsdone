<?php

  /**
   * Пути и названия шаблонов view (пути относительные).
   */
  define('VIEWS_PATHS', [
    // Основной контент index.html.
    'contentIndex' => './templates/content-index.php',

    // Сайдбар со списком категорий (проектов).
    'sidebarCategories' => './templates/sidebar-categories.php',

    // Сетка-каркас всех страниц сайта.
    'siteLayout' => './templates/site-layout.php',

    // Header сайта.
    'siteHeader' => './templates/site-header.php',

    // Footer сайта.
    'siteFooter' => './templates/site-footer.php'
  ]);

  /**
   * Названия страниц сайта.
   */
  define('PAGES_TITLES', [
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
