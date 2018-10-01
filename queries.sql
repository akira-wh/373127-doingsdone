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
      password = '$2y$10$3Y8bk7P7WGP005OpodF1/ebO.zMzTlHJPIUFslTKfH3uwk7v2T3SS'; -- powerfulPassword13

INSERT INTO users
  SET name = 'Канэда',
      email = 'doingsdone02@inbox.ru',
      password = '$2y$10$3Y8bk7P7WGP005OpodF1/ebO.zMzTlHJPIUFslTKfH3uwk7v2T3SS'; -- powerfulPassword13

/** Моделирование таблицы категорий. */
INSERT INTO categories
  SET name = 'Входящие',
      creator_id = '1'; -- Игнат

INSERT INTO categories
  SET name = 'Учеба',
      creator_id = '1'; -- Игнат

INSERT INTO categories
  SET name = 'Работа',
      creator_id = '1'; -- Игнат

INSERT INTO categories
  SET name = 'Дом',
      creator_id = '2'; -- Леночка

INSERT INTO categories
  SET name = 'Мой магазин',
      creator_id = '2'; -- Леночка

INSERT INTO categories
  SET name = 'Авто',
      creator_id = '3'; -- Руслан

INSERT INTO categories
  SET name = 'Сервис ProjectX',
      creator_id = '3'; -- Руслан

INSERT INTO categories
  SET name = 'Тур по Европе',
      creator_id = '3'; -- Руслан

INSERT INTO categories
  SET name = 'Дела в Скайриме',
      creator_id = '4'; -- Довакин

INSERT INTO categories
  SET name = 'Изучение криков (туумов)',
      creator_id = '4'; -- Довакин

INSERT INTO categories
  SET name = 'Umbrella Corp.',
      creator_id = '5'; -- Канэда

INSERT INTO categories
  SET name = 'Ремонт',
      creator_id = '5'; -- Канэда

/** Моделирование таблицы задач. */
INSERT INTO tasks
  SET name = 'Встреча с другом',
      category_id = '1', -- Входящие
      deadline = '2018-10-20 19:00';

INSERT INTO tasks
  SET name = 'Зайти в банк по поводу доп.счета',
      category_id = '1', -- Входящие
      deadline = '2018-11-15 09:00';

INSERT INTO tasks
  SET name = 'Сделать задание первого раздела',
      category_id = '2', -- Учеба
      deadline = '2018-09-12 10:00',
      is_complete = '1';

INSERT INTO tasks
  SET name = 'Заменить Open Server на реальные инструменты',
      category_id = '2', -- Учеба
      deadline = '2018-10-15 10:00';

INSERT INTO tasks
  SET name = 'Настроить xdebug для Atom и VS Code',
      category_id = '2', -- Учеба
      deadline = '2018-09-25 13:00',
      is_complete = '1';

INSERT INTO tasks
  SET name = 'Подготовить портфолио',
      category_id = '3', -- Работа
      deadline = '2018-11-29 17:00';

INSERT INTO tasks
  SET name = 'Собеседование (куратор Марина)',
      category_id = '3', -- Работа
      deadline = '2018-12-01 09:00';

INSERT INTO tasks
  SET name = 'Выполнить тестовое задание',
      category_id = '3', -- Работа
      deadline = '2018-12-05 09:00';

INSERT INTO tasks
  SET name = 'Купить корм для кота',
      category_id = '4', -- Дом
      deadline = '2018-11-15 19:00';

INSERT INTO tasks
  SET name = 'Заказать пиццу на ужин',
      category_id = '4', -- Дом
      deadline = '2018-11-11 17:00';

INSERT INTO tasks
  SET name = 'Обновление осенней коллекции',
      category_id = '5', -- Мой магазин
      deadline = '2018-10-10 09:00';

INSERT INTO tasks
  SET name = 'Провести инвентаризацию',
      category_id = '5', -- Мой магазин
      deadline = '2018-10-12 09:00';

INSERT INTO tasks
  SET name = 'Заменить ремкомплект стеклоподъемника',
      category_id = '6', -- Авто
      deadline = '2018-09-10 14:00',
      is_complete = '1';

INSERT INTO tasks
  SET name = 'Замена масла и резины',
      category_id = '6', -- Авто
      deadline = '2018-12-01 10:00';

INSERT INTO tasks
  SET name = 'Позвонить Илье, заказать макеты',
      category_id = '7', -- Сервис ProjectX
      deadline = '2018-09-20 11:00',
      is_complete = '1';

INSERT INTO tasks
  SET name = 'Выбор стека технологий',
      category_id = '7', -- Сервис ProjectX
      deadline = '2018-10-20 08:00';

INSERT INTO tasks
  SET name = 'Начало работы над проектом',
      category_id = '7', -- Сервис ProjectX
      deadline = '2018-10-20 11:00';

INSERT INTO tasks
  SET name = 'Собеседование в посольстве (виза)',
      category_id = '8', -- Тур по Европе
      deadline = '2018-11-01 09:00';

INSERT INTO tasks
  SET name = 'Подобрать отели (Барселона, Рим, Париж, Дублин)',
      category_id = '8', -- Тур по Европе
      deadline = '2018-11-05 13:00';

INSERT INTO tasks
  SET name = 'Договориться с гидом',
      category_id = '8', -- Тур по Европе
      deadline = '2018-11-05 17:00';

INSERT INTO tasks
  SET name = 'Занести товар в гильдию',
      category_id = '9', -- Дела в Скайриме
      deadline = '2018-11-05 13:00';

INSERT INTO tasks
  SET name = 'Достать бивень мамонта для Сульги',
      category_id = '9', -- Дела в Скайриме
      deadline = '2018-12-04 21:00';

INSERT INTO tasks
  SET name = 'Безжалостная сила',
      category_id = '10', -- Изучение криков (туумов)
      is_complete = '1';

INSERT INTO tasks
  SET name = 'Гармония Кин',
      category_id = '10', -- Изучение криков (туумов)
      is_complete = '1';

INSERT INTO tasks
  SET name = 'Смертный приговор',
      category_id = '10'; -- Изучение криков (туумов)

INSERT INTO tasks
  SET name = 'Драконобой',
      category_id = '10'; -- Изучение криков (туумов)

INSERT INTO tasks
  SET name = 'Стрельнуть номер Шевы',
      category_id = '11', -- Umbrella Corp.
      is_complete = '1';

INSERT INTO tasks
  SET name = 'Пиво с Рэдфилдом',
      category_id = '11', -- Umbrella Corp.
      deadline = '2019-01-05';

INSERT INTO tasks
  SET name = 'Летим в Африку',
      category_id = '11', -- Umbrella Corp.
      deadline = '2019-02-01 11:00';

INSERT INTO tasks
  SET name = 'Заклинивает гильзу (проверить боек)',
      category_id = '12', -- Ремонт
      deadline = '2019-01-01 15:00';

INSERT INTO tasks
  SET name = 'Низкая компрессия в цилиндре мотоцикла',
      category_id = '12', -- Ремонт
      deadline = '2019-01-01 20:00';

/** Моделирование запросов к БД. */
/** Получение списка всех проектов одного пользователя. */
SELECT categories.name AS category, users.name AS creator FROM categories
  JOIN users ON categories.creator_id = users.id
  WHERE users.name = 'Довакин';

/** Получение списка всех задач одного проекта. */
SELECT tasks.name AS task, categories.name AS category FROM tasks
  JOIN categories ON tasks.category_id = categories.id
  WHERE categories.id = '8';

/** Смена статуса задачи на "ВЫПОЛНЕНА", отображение результата. */
UPDATE tasks SET is_complete = '1'
  WHERE id = 1;

SELECT name AS task, is_complete FROM tasks
  WHERE id = 1;

/** Получение задач на определенные сутки. */
SELECT * FROM tasks
  WHERE deadline BETWEEN '2019-01-01' AND '2019-01-02';

/** Обновление названия задачи и статуса по идентификатору. */
UPDATE tasks SET name = 'Обновить название задачи по идентификатору', is_complete = '1'
  WHERE id = 2;

SELECT * FROM tasks
  WHERE id = 2;
