<?php

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

  // Данные пользователей для аутентификации.
  $users = [
    [
      'email' => 'ignat.v@gmail.com',
      'name' => 'Игнат',
      'password' => '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka'
    ],
    [
      'email' => 'kitty_93@li.ru',
      'name' => 'Леночка',
      'password' => '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa'
    ],
    [
      'email' => 'warrior07@mail.ru',
      'name' => 'Руслан',
      'password' => '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW'
    ]
  ];
