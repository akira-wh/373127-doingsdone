<?php

  /**
   * Сборка разметки View по переданному шаблону.
   *
   * 1. Проверка на существование и доступность шаблона view.
   * 2. Начало буферизации контента.
   * 3. Распаковка переменных с данными из массива $data.
   * 4. Подключение и сборка view по импортированным данным.
   * 5. Выгрузка собранного контента.
   *
   * @param string $viewPath — путь к файлу с шаблоном view
   * @param array $data — входные данные, упакованные в массив
   * @return string — собранная разметка view
   */
  function fillView($viewPath, $data = []) {
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
    $counter = array_reduce($tasks, function($accum, $task) use ($category) {
      return ($task['category'] === $category) ? ++$accum : $accum;
    }, 0);

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

    $secondsInHour = 3600;
    $timeReserveInHours = floor(($deadlineTime - $currentTime) / $secondsInHour);

    return ($timeReserveInHours <= 24);
  }
