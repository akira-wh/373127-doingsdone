<?php

  // Библиотека констант.
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
   * Проверка необходимости подсветить задачу с приближающимся дедлайном.
   * Если до дедлайна <= 1 сутки, задача должна быть подсвечена.
   *
   * @param string $datetime — DATETIME дедлайна в валидном формате
   * @return boolean — выделить задачу над остальными? true || false
   */
  function shouldHighlightTask($datetime) {
    if (!$datetime) {
      return false;
    }

    $deadlineTime = strtotime($datetime);
    $currentTime = time();
    $timeReserveInDays = floor(($deadlineTime - $currentTime) / SECONDS_IN_DAY);

    return $timeReserveInDays <= ONE_DAY;
  }

  /**
   * Приведение DATETIME к дате в европейском формате (ДД.ММ.ГГГГ).
   *
   * 1. Удаление времени (не используется в приложении).
   * 2. Приведение даты к нужному формату отображения.
   *
   * @param string $datetime — дата и время
   * @return string — дата
   *
   */
  function getEuropeanDateFormat($datetime) {
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
