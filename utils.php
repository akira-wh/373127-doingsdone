<?php

  // Подключение библиотеки констант:
  // названия страниц, пути и названия шаблонов view, etc.
  require_once('./constants.php');

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
   * @param array $data — входные данные, упакованные в массив
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
   * Подсчет количества задач, входящих в определенную категорию (проект).
   *
   * @param array $categoryData — данные категории
   * @param array $tasks — список задач
   * @return number — подсчитанное количество задач
   */
  function countCategoryTasks($categoryData, $tasks) {
    $counter = 0;

    foreach ($tasks as $taskData) {
      if ($taskData['category_id'] === $categoryData['id']) {
        $counter++;
      }
    }

    return $counter;
  }

  /**
   * Проверка необходимости выделить|подсветить задачу с приближающимся дедлайном.
   * Если до дедлайна <= 24 часа, задача должна быть выделена|подсвечена.
   *
   * @param string $deadline — дата/время дедлайна в человекочитаемом формате
   * @return boolean — выделить задачу над остальными? true || false
   */
  function shouldHighlightTask($deadline) {
    if (!$deadline) {
      return false;
    }

    $deadlineTime = strtotime($deadline);
    $currentTime = time();
    $timeReserveInHours = floor(($deadlineTime - $currentTime) / SECONDS_IN_HOUR);

    return ($timeReserveInHours <= TWENTY_FOUR_HOURS);
  }

  /**
   * Получение необходимых данных из БД.
   *
   * @param object $databaseConnecion — объект подключения к СУБД
   * @param string $requestString — строка запроса к СУБД
   * @return array — данные из БД, сконвертированные в массив
   */
  function getDatabaseData($databaseConnection, $requestString) {
    $receivedData = $databaseConnection->query($requestString);

    $adaptedData = $receivedData->fetch_all(MYSQLI_ASSOC);
    $adaptedData = convertArrayStringsToNumbers($adaptedData);

    return $adaptedData;
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
        return (is_integer($item + 0)) ? (integer) $item : (float) $item;
      }

      // В иных случаях конвертация не производится.
      return $item;
    }, $data);
  }
