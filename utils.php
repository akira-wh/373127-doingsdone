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

    return $timeReserveInHours <= TWENTY_FOUR_HOURS;
  }

  /**
   * Модификация строки с датой и временем (DATETIME).
   *
   * 1. Удаление времени (не используется в приложении).
   * 2. Приведение даты к формату ДД.ММ.ГГГГ.
   *
   * @param string $datetime — дата и время
   * @return string — дата в локальном формате
   *
   */
  function getDateFormatDDMMYYYY($datetime) {
    return date('d.m.Y', strtotime($datetime));
  }
