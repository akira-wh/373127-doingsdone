<?php

  /**
   * Сборка разметки View по переданному шаблону.
   *
   * 1. Проверка на существование и доступность шаблона view.
   * 2. Начало буферизации контента.
   * 3. Импорт переменных с данными из массива $data.
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
   * @param string $requiredCategory — название категории
   * @param array $tasks — список задач
   * @return number — подсчитанное количество задач
   */
  function countCategoryTasks($requiredCategory, $tasks) {
    $counter = 0;

    foreach ($tasks as $task) {
      if ($task['category'] === $requiredCategory) {
        $counter++;
      }
    }

    return $counter;
  }
?>
