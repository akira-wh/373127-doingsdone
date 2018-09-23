<?php

  // Пути и названия шаблонов view (пути относительные).
  $viewsPaths = [
    'contentIndex' => './templates/content-index.php',
    'sidebarCategories' => './templates/sidebar-categories.php',
    'siteLayout' => './templates/site-layout.php',
    'siteHeader' => './templates/site-header.php',
    'siteFooter' => './templates/site-footer.php'
  ];

  // Названия страниц сайта.
  $pagesTitles = [
    'index' => 'Дела в порядке — Главная'
  ];

  // Категории задач (проекты).
  $categories = [
    'incoming' => 'Входящие',
    'education' => 'Учеба',
    'work' => 'Работа',
    'housework' => 'Домашние дела',
    'auto' => 'Авто'
  ];

  // Список задач.
  $tasks = [
    [
      'name' => 'Собеседование в IT компании',
      'deadline' => '01.12.2018',
      'category' => $categories['work'],
      'isComplete' => false
    ],
    [
      'name' => 'Выполнить тестовое задание',
      'deadline' => '25.12.2018',
      'category' => $categories['work'],
      'isComplete' => false
    ],
    [
      'name' => 'Сделать задание первого раздела',
      'deadline' => '21.12.2018',
      'category' => $categories['education'],
      'isComplete' => true
    ],
    [
      'name' => 'Встреча с другом',
      'deadline' => '22.12.2018',
      'category' => $categories['incoming'],
      'isComplete' => false
    ],
    [
      'name' => 'Купить корм для кота',
      'deadline' => '',
      'category' => $categories['housework'],
      'isComplete' => false
    ],
    [
      'name' => 'Заказать пиццу',
      'deadline' => '',
      'category' => $categories['housework'],
      'isComplete' => false
    ]
  ];
