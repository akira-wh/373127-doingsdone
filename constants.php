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

    // Контент страницы регистрации пользователя.
    'contentRegistration' => 'content-registration.php',

    // Контент страницы добавления задач.
    'contentAddTask' => 'content-add-task.php',

    // Контент страницы вывода ошибки.
    'contentError' => 'content-error.php',

    // Сайдбар со списком категорий (проектов).
    'sidebarCategories' => 'sidebar-categories.php',

    // Сайдбар с предложением авторизироваться.
    'sidebarLogin' => 'sidebar-login.php',

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
    'addTask' => 'Добавление задачи',

    // Страница регистрации.
    'registration' => 'Регистрация нового пользователя',

    // Страница отображения ошибки.
    'error' => 'Ошибка'
  ]);

  /**
   * Количество секунд в сутках (86400).
   */
  define('SECONDS_IN_DAY', 86400);

  /**
   * 1 сутки.
   */
  define('ONE_DAY', 1);

  /**
   * Идентификатор виртуального раздела INBOX (Входящие).
   */
  define('VIRTUAL_CATEGORY_INBOX', 'inbox');
