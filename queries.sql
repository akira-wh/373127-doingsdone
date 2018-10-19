/** Моделирование таблицы пользователей. */
INSERT INTO users
  SET name = 'Довакин',
      email = 'doingsdone01@inbox.ru',
      password = '$2y$10$qNKMNmYsOcfmH04WTnJQguNFxgqYgCW5Ftk8UfEWMDXWkOgrLd6sO'; -- 12345

/** Моделирование таблицы категорий. */
INSERT INTO categories
  SET name = 'Дела в Скайриме',
      creator_id = 1;

INSERT INTO categories
  SET name = 'Изучение криков (туумов)',
      creator_id = 1;

/** Моделирование таблицы задач. */
INSERT INTO tasks
  SET name = 'Забрать дань из Гильдии Воров',
      category_id = 1,
      creator_id = 1,
      deadline = '2018-11-05';

INSERT INTO tasks
  SET name = 'Достать бивень мамонта для Сульги',
      category_id = 1,
      creator_id = 1,
      deadline = '2018-12-04';

INSERT INTO tasks
  SET name = 'Вступить в Темное Братство',
      category_id = 1,
      creator_id = 1,
      deadline = '2018-12-20';

INSERT INTO tasks
  SET name = 'Изучить "Безжалостную силу"',
      category_id = 2,
      creator_id = 1,
      is_complete = 1;

INSERT INTO tasks
  SET name = 'Изучить "Гармонию Кин"',
      category_id = 2,
      creator_id = 1,
      is_complete = 1;

INSERT INTO tasks
  SET name = 'Изучить "Смертный приговор"',
      category_id = 2,
      creator_id = 1;

INSERT INTO tasks
  SET name = 'Изучить "Драконобой"',
      category_id = 2,
      creator_id = 1;

INSERT INTO tasks
  SET name = 'Пройти в Зал Доблести Совнгарда',
      creator_id = 1;

INSERT INTO tasks
  SET name = 'Найти Алдуина в Совнгарде',
      creator_id = 1;

INSERT INTO tasks
  SET name = 'Уничтожить Пожирателя Мира',
      creator_id = 1;
