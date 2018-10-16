<?php

  // Библиотека констант.
  require_once('./constants.php');

  /**
   * Количество секунд в сутках (86400).
   */
  define('SECONDS_IN_DAY', 86400);

  /**
   * 1 сутки.
   */
  define('ONE_DAY', 1);

  /**
   * Сборка разметки View по переданному шаблону.
   *
   * 1. Проверка на существование и доступность шаблона view.
   * 2. Начало буферизации контента.
   * 3. Распаковка переменных с данными из массива $data.
   * 4. Подключение и сборка view по импортированным данным.
   * 5. Выгрузка собранного контента.
   *
   * @param string $viewFilename — название файла с шаблоном view
   * @param array $data — входные данные в массиве
   * @return string — собранная разметка view
   */
  function fillView($viewFilename, $data = []) {
    $viewPath = VIEWS_DIRECTORY_PATH.$viewFilename;
    $view = '';

    if (is_readable($viewPath)) {
      ob_start();
      extract($data);
      require_once($viewPath);
      $view = ob_get_clean();
    }

    return $view;
  }

  /**
   * Проверка необходимости подсветить задачу с подошедшим дедлайном.
   * Если дедлайн сегодня — задача будет быть подсвечена.
   *
   * @param string $datetime — DATETIME дедлайна в валидном формате
   * @return boolean — выделить задачу над остальными? true || false
   */
  function shouldHighlightTask($datetime) {
    if (!$datetime) {
      return false;
    }

    $deadlineDate = date('d.m.Y', strtotime($datetime));
    $currentDate = date('d.m.Y', time());

    return $deadlineDate === $currentDate;
  }

  /**
   * Приведение DATETIME к дате в европейском формате (ДД.ММ.ГГГГ).
   *
   * 1. Удаление времени (не используется в приложении).
   * 2. Приведение даты к нужному формату отображения.
   *
   * @param string $datetime — дата и время
   * @return string — дата (или пустая строка, если DATETIME невалидный)
   *
   */
  function getEuropeanDateFormat($datetime) {
    if (date_parse($datetime)['error_count']) {
      return '';
    }

    return date('d.m.Y', strtotime($datetime));
  }

  /**
   * Конвертация строковых элементов массива в числа.
   * Необходима для данных из БД (СУБД отдает числа в виде строк).
   *
   * @param array $data — массив, элементы которого подлежат конвертации
   * @return array — массив с конвертированными данными
   */
  function convertArrayStringsToNumbers($data) {
    return array_map(function($item) {
      // Если проверяется массив — рекурсивная проверка вглубь.
      if (is_array($item)) {
        return convertArrayStringsToNumbers($item);
      }

      // Если в строке находится число — преобразование к реальному числу.
      if (is_numeric($item)) {
        return is_integer($item + 0) ? (integer) $item : (float) $item;
      }

      // В иных случаях конвертация не производится.
      return $item;
    }, $data);
  }

  /**
   * Внедрение в категории и задачи виртуального раздела INBOX (Входящие).
   * INBOX необходим для удобного управления задачами без конкретных категорий.
   *
   * NB! Списки категорий и задач модифицируются ПО ССЫЛКЕ (знак &).
   *
   * @param array $categories — список категорий
   * @param array $tasks — список задач
   */
  function plugVirtualInbox(&$categories, &$tasks) {
    array_unshift($categories, [
      'id' => VIRTUAL_CATEGORY_INBOX,
      'name' => 'Входящие'
    ]);

    foreach ($tasks as &$taskData) {
      if ($taskData['category_id'] === null) {
        $taskData['category_id'] = VIRTUAL_CATEGORY_INBOX;
      }
    }
  }

  /**
   * Добавление категориям счетчика привязанных задач.
   *
   * NB! Список категорий модифицируется ПО ССЫЛКЕ (знак &).
   *
   * @param array $categories — список категорий
   * @param array $tasks — список задач
   */
  function plugStatistic(&$categories, $tasks) {
    foreach ($categories as &$categoryData) {
      $tasksIncluded = array_reduce($tasks, function($accum, $taskData) use ($categoryData) {
        return ($taskData['category_id'] === $categoryData['id']) ? ++$accum : $accum;
      }, ZERO_COUNT);

      $categoryData['tasks_included'] = $tasksIncluded;
    }
  }
