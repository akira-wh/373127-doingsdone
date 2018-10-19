<?php

  // Библиотека констант.
  require_once('./constants.php');

  /**
   * Длина подстроки с многоточием (3).
   * Многоточием обрезаются длинные пользовательские строки.
   */
  define('THREE_DOTS_LENGTH', 3);

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
   * Добавление категориям счетчика привязанных, актуальных задач.
   *
   * NB! Список категорий модифицируется ПО ССЫЛКЕ (знак &).
   *
   * @param array $categories — список категорий
   * @param array $tasks — список задач
   */
  function plugStatistic(&$categories, $tasks) {
    foreach ($categories as &$categoryData) {

      $activeTasks = array_reduce($tasks, function($accum, $taskData) use ($categoryData) {
        if ($taskData['category_id'] === $categoryData['id'] && !$taskData['is_complete']) {
          return ++$accum;
        }

        return $accum;
      }, ZERO_COUNT);

      $categoryData['active_tasks'] = $activeTasks;
    }
  }

  /**
   * Контроль длины строки.
   * Если длина превышает установленный лимит — строка сокращается.
   *
   * NB! Результирующую строку завершает многоточие (входит в лимит длины).
   *
   * @param string $string — Входная строка
   * @param integer $lengthLimit — Лимит длины
   * @return string — результирующая строка
   */
  function controlStringLength($string, $lengthLimit) {
    $lengthLimit -= THREE_DOTS_LENGTH;

    if (strlen($string) > $lengthLimit) {
      return mb_substr($string, 0, $lengthLimit, 'UTF-8') . '...';
    }

    return $string;
  }

  /**
   * Подрезка пробелов у отдельных строк или строк массива.
   *
   * @param string|array $data — строка или строки массива
   * @return string|array — подрезанная строка или строки массива
   */
  function trimStringsSpaces($data) {
    if (is_array($data)) {
      foreach ($data as $key => $value) {
        $data[$key] = trim($value);
      }
    } else {
      $data = trim($data);
    }

    return $data;
  }

  /**
   * Проверка целостности отправленной формы.
   * Количество и названия полей должны соответствовать оригинальным значениям.
   *
   * @param array $originalFieldsNames — названия оригинальных полей формы
   * @param array $formFields — фактические названия и значения полей формы
   * @return boolean — целостность формы нарушена? true | false
   */
  function isFormIntegrityBroken($originalFieldsNames, $formFields) {
    $formFieldsNames = array_keys($formFields);

    if (count($formFieldsNames) !== count($originalFieldsNames)) {
      return true;
    }

    foreach ($formFieldsNames as $formFieldName) {
      if (!in_array($formFieldName, $originalFieldsNames)) {
        return true;
      }
    }

    return false;
  }

  /**
   * Подбор задач определенной категории.
   *
   * @param integer|string $selectedCategoryID — идентификатор выбранной категории
   * @param array $tasks — данные всех задач
   * @return array — данные отфильтрованных задач
   */
  function filterCategoryTasks($selectedCategoryID, $tasks) {
    $filteredTasks = array_filter($tasks, function($taskData) use ($selectedCategoryID) {
      return $taskData['category_id'] === $selectedCategoryID;
    });

    return $filteredTasks;
  }

  /**
   * Подбор задач на сегодняшний день.
   *
   * @param array $tasks — данные всех задач
   * @return array — данные отфильтрованных задач
   */
  function filterTodayTasks($tasks) {
    $today = date('d.m.Y', time());

    $filteredTasks = array_filter($tasks, function($taskData) use ($today) {
      return $taskData['deadline'] &&
              date('d.m.Y', strtotime($taskData['deadline'])) === $today;
    });

    return $filteredTasks;
  }

  /**
   * Подбор задач на завтрашний день.
   *
   * @param array $tasks — данные всех задач
   * @return array — данные отфильтрованных задач
   */
  function filterTomorrowTasks($tasks) {
    $tomorrow = date('d.m.Y', strtotime('+1 day'));

    $filteredTasks = array_filter($tasks, function($taskData) use ($tomorrow) {
      return $taskData['deadline'] &&
              date('d.m.Y', strtotime($taskData['deadline'])) === $tomorrow;
    });

    return $filteredTasks;
  }

  /**
   * Подбор задач с истекшим дедлайном.
   *
   * @param array $tasks — данные всех задач
   * @return array — данные отфильтрованных задач
   */
  function filterExpiredTasks($tasks) {
    $yesterday = strtotime('-1 day');

    $filteredTasks = array_filter($tasks, function($taskData) use ($yesterday) {
      return $taskData['deadline'] &&
              strtotime($taskData['deadline']) <= $yesterday;
    });

    return $filteredTasks;
  }
