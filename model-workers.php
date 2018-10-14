<?php

  // Библиотека констант.
  require_once('./constants.php');

  // Библиотека утилит общего назначения.
  require_once('./utils.php');

  // Конфигурация соединения с СУБД.
  $configuration = [
    'host' => 'doingsdone',
    'user' => 'root',
    'password' => '',
    'database' => 'doingsdone',
    'charset' => 'utf-8'
  ];

  // Создание соединения с СУБД.
  $databaseConnection = new mysqli(
    $configuration['host'],
    $configuration['user'],
    $configuration['password'],
    $configuration['database']
  );

  // Выбор кодировки данных.
  $databaseConnection->set_charset($configuration['charset']);

  /**
   * Формирование SQL-запроса на получение данных категорий и количества привязанных задач.
   *
   * NB! В результирующий список добавляется виртуальный раздел INBOX (Входящие).
   *     Он позволяет управлять задачами без категорий.
   *
   * @param integer $userID — ID пользователя по базе
   * @return string — строка sql запроса
   */
  function compileRequestForCategories($userID) {
    $virtualInbox = VIRTUAL_CATEGORY_INBOX;

    return "SELECT '{$virtualInbox}' as id, 'Входящие' as name, COUNT(tasks.id) as tasks_included
            FROM tasks
            WHERE creator_id = {$userID} AND category_id IS NULL

            UNION

            SELECT categories.id, categories.name, COUNT(tasks.id) as tasks_included
            FROM categories
            JOIN tasks ON tasks.category_id = categories.id
            WHERE categories.creator_id = {$userID}
            GROUP BY tasks.category_id";
  }

  /**
   * Формирование SQL-запроса на получение задач.
   *
   * NB! Задачи без категорий определяются в виртуальный раздел INBOX (Входящие).
   *
   * @param integer $userID — ID пользователя по базе
   * @return string — строка sql запроса
   */
  function compileRequestForTasks($userID) {
    $virtualInbox = VIRTUAL_CATEGORY_INBOX;

    return "SELECT id, name, IFNULL(category_id, '{$virtualInbox}') as category_id,
                    deadline, attachment_label, attachment_filename, is_complete
            FROM tasks
            WHERE creator_id = {$userID}";
  }

  /////////////////////////////////////////////////////////////////////////
  //
  // Утилиты для работы с СУБД.
  //
  /////////////////////////////////////////////////////////////////////////

  /**
   * Получение данных из СУБД.
   *
   * @param object $databaseConnecion — объект подключения к СУБД
   * @param string $requestString — строка запроса к СУБД
   * @return array — данные из БД, сконвертированные в массив
   */
  function downloadData($databaseConnection, $requestString) {
    $downloadedData = $databaseConnection->query($requestString);

    $adaptedData = $downloadedData->fetch_all(MYSQLI_ASSOC);
    $adaptedData = convertArrayStringsToNumbers($adaptedData);

    return $adaptedData;
  }

  /**
   * Передача данных в СУБД.
   *
   * @param object $databaseConnecion — объект подключения к СУБД
   * @param string $requestString — строка запроса к СУБД
   */
  function uploadData($databaseConnection, $requestString) {
    $outgoingData = $databaseConnection->query($requestString);
  }
