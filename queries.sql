/** Моделирование таблицы пользователей. */
INSERT INTO users
  SET name = 'Игнат',
      email = 'ignat.v@gmail.com',
      password = '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka';

INSERT INTO users
  SET name = 'Леночка',
      email = 'kitty_93@li.ru',
      password = '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa';

INSERT INTO users
  SET name = 'Руслан',
      email = 'warrior07@mail.ru',
      password = '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW';

INSERT INTO users
  SET name = 'Довакин',
      email = 'doingsdone01@inbox.ru',
      password = '$2y$10$qNKMNmYsOcfmH04WTnJQguNFxgqYgCW5Ftk8UfEWMDXWkOgrLd6sO'; -- 12345

INSERT INTO users
  SET name = 'Канэда',
      email = 'doingsdone02@inbox.ru',
      password = '$2y$10$qNKMNmYsOcfmH04WTnJQguNFxgqYgCW5Ftk8UfEWMDXWkOgrLd6sO'; -- 12345

/** Моделирование таблицы категорий. */
INSERT INTO categories
  SET name = 'Учеба',
      creator_id = 1; -- Игнат

INSERT INTO categories
  SET name = 'Работа',
      creator_id = 1; -- Игнат

INSERT INTO categories
  SET name = 'Дом',
      creator_id = 2; -- Леночка

INSERT INTO categories
  SET name = 'Мой магазин',
      creator_id = 2; -- Леночка

INSERT INTO categories
  SET name = 'Авто',
      creator_id = 3; -- Руслан

INSERT INTO categories
  SET name = 'Сервис ProjectX',
      creator_id = 3; -- Руслан

INSERT INTO categories
  SET name = 'Тур по Европе',
      creator_id = 3; -- Руслан

INSERT INTO categories
  SET name = 'Дела в Скайриме',
      creator_id = 4; -- Довакин

INSERT INTO categories
  SET name = 'Изучение криков (туумов)',
      creator_id = 4; -- Довакин

INSERT INTO categories
  SET name = 'Umbrella Corp.',
      creator_id = 5; -- Канэда

INSERT INTO categories
  SET name = 'Ремонт',
      creator_id = 5; -- Канэда

/** Моделирование таблицы задач. */
INSERT INTO tasks
  SET name = 'Встреча с другом',
      creator_id = 1, -- Игнат
      deadline = '2018-10-20';

INSERT INTO tasks
  SET name = 'Зайти в банк по поводу доп.счета',
      creator_id = 1, -- Игнат
      deadline = '2018-11-15';

INSERT INTO tasks
  SET name = 'Сделать задание первого раздела',
      category_id = 1, -- Учеба
      creator_id = 1, -- Игнат
      deadline = '2018-09-12',
      is_complete = 1;

INSERT INTO tasks
  SET name = 'Заменить Open Server на реальные инструменты',
      category_id = 1, -- Учеба
      creator_id = 1, -- Игнат
      deadline = '2018-10-15',
      attachment_label = 'coords.txt',
      attachment_filename = 'coords.txt';

INSERT INTO tasks
  SET name = 'Настроить xdebug для Atom и VS Code',
      category_id = 1, -- Учеба
      creator_id = 1, -- Игнат
      deadline = '2018-09-25',
      is_complete = 1;

INSERT INTO tasks
  SET name = 'Подготовить портфолио',
      category_id = 2, -- Работа
      creator_id = 1, -- Игнат
      deadline = '2018-11-29';

INSERT INTO tasks
  SET name = 'Собеседование (куратор Марина)',
      category_id = 2, -- Работа
      creator_id = 1, -- Игнат
      deadline = '2018-12-01';

INSERT INTO tasks
  SET name = 'Выполнить тестовое задание',
      category_id = 2, -- Работа
      creator_id = 1, -- Игнат
      deadline = '2018-12-05';

INSERT INTO tasks
  SET name = 'Купить корм для кота',
      category_id = 3, -- Дом
      creator_id = 2, -- Леночка
      deadline = '2018-11-15';

INSERT INTO tasks
  SET name = 'Заказать пиццу на ужин',
      category_id = 3, -- Дом
      creator_id = 2, -- Леночка
      deadline = '2018-11-11';

INSERT INTO tasks
  SET name = 'Обновление осенней коллекции',
      category_id = 4, -- Мой магазин
      creator_id = 2, -- Леночка
      deadline = '2018-10-10',
      attachment_label = 'coords.txt',
      attachment_filename = 'coords.txt';

INSERT INTO tasks
  SET name = 'Провести инвентаризацию',
      category_id = 4, -- Мой магазин
      creator_id = 2, -- Леночка
      deadline = '2018-10-12';

INSERT INTO tasks
  SET name = 'Заменить ремкомплект стеклоподъемника',
      category_id = 5, -- Авто
      creator_id = 3, -- Руслан
      deadline = '2018-09-10',
      is_complete = 1;

INSERT INTO tasks
  SET name = 'Замена масла и резины',
      category_id = 5, -- Авто
      creator_id = 3, -- Руслан
      deadline = '2018-12-01';

INSERT INTO tasks
  SET name = 'Позвонить Илье, заказать макеты',
      category_id = 6, -- Сервис ProjectX
      creator_id = 3, -- Руслан
      deadline = '2018-09-20',
      attachment_label = 'coords.txt',
      attachment_filename = 'coords.txt',
      is_complete = 1;

INSERT INTO tasks
  SET name = 'Выбор стека технологий',
      category_id = 6, -- Сервис ProjectX
      creator_id = 3, -- Руслан
      deadline = '2018-10-20';

INSERT INTO tasks
  SET name = 'Начало работы над проектом',
      category_id = 7, -- Сервис ProjectX
      creator_id = 3, -- Руслан
      deadline = '2018-10-20';

INSERT INTO tasks
  SET name = 'Собеседование в посольстве (виза)',
      category_id = 7, -- Тур по Европе
      creator_id = 3, -- Руслан
      deadline = '2018-11-01',
      attachment_label = 'coords.txt',
      attachment_filename = 'coords.txt';

INSERT INTO tasks
  SET name = 'Подобрать отели (Барселона, Рим, Париж, Дублин)',
      category_id = 7, -- Тур по Европе
      creator_id = 3, -- Руслан
      deadline = '2018-11-05';

INSERT INTO tasks
  SET name = 'Договориться с гидом',
      category_id = 7, -- Тур по Европе
      creator_id = 3, -- Руслан
      deadline = '2018-11-05';

INSERT INTO tasks
  SET name = 'Занести товар в гильдию',
      category_id = 8, -- Дела в Скайриме
      creator_id = 4, -- Довакин
      deadline = '2018-11-05';

INSERT INTO tasks
  SET name = 'Достать бивень мамонта для Сульги',
      category_id = 8, -- Дела в Скайриме
      creator_id = 4, -- Довакин
      deadline = '2018-12-04';

INSERT INTO tasks
  SET name = 'Изучить "Безжалостную силу"',
      category_id = 9, -- Изучение криков (туумов)
      creator_id = 4, -- Довакин
      is_complete = 1;

INSERT INTO tasks
  SET name = 'Изучить "Гармонию Кин"',
      category_id = 9, -- Изучение криков (туумов)
      creator_id = 4, -- Довакин
      is_complete = 1;

INSERT INTO tasks
  SET name = 'Изучить "Смертный приговор"',
      category_id = 9, -- Изучение криков (туумов)
      creator_id = 4; -- Довакин

INSERT INTO tasks
  SET name = 'Изучить "Драконобой"',
      category_id = 9, -- Изучение криков (туумов)
      creator_id = 4; -- Довакин

INSERT INTO tasks
  SET name = 'Стрельнуть номер Шевы',
      category_id = 10, -- Umbrella Corp.
      creator_id = 5, -- Канэда
      is_complete = 1;

INSERT INTO tasks
  SET name = 'Пиво с Рэдфилдом',
      category_id = 10, -- Umbrella Corp.
      creator_id = 5, -- Канэда
      deadline = '2019-01-05';

INSERT INTO tasks
  SET name = 'Летим в Африку',
      category_id = 10, -- Umbrella Corp.
      creator_id = 5, -- Канэда
      deadline = '2019-02-01',
      attachment_label = 'coords.txt',
      attachment_filename = 'coords.txt';

INSERT INTO tasks
  SET name = 'Заклинивает гильзу (проверить боек)',
      category_id = 11, -- Ремонт
      creator_id = 5, -- Канэда
      deadline = '2019-01-01';

INSERT INTO tasks
  SET name = 'Низкая компрессия в цилиндре мотоцикла',
      category_id = 11, -- Ремонт
      creator_id = 5, -- Канэда
      deadline = '2019-01-01';
