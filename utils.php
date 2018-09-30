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
   * @param string $category — название категории
   * @param array $tasks — список задач
   * @return number — подсчитанное количество задач
   */
  function countCategoryTasks($category, $tasks) {
    return array_reduce($tasks, function($counter, $task) use ($category) {
      return ($task['category'] === $category) ? ++$counter : $counter;
    }, 0);
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
