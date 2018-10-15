<?php

  // Библиотека констант.
  require_once('./constants.php');

  // Библиотека утилит общего назначения.
  require_once('./utils.php');

  /**
   * Метод обработки данных из СУБД.
   * Парсить только 1 строку.
   */
  define('PARSE_DATA_ROW', 'parseDataRow');

  /**
   * Метод обработки данных из СУБД.
   * Парсить все строки.
   */
  define('PARSE_DATA_ALL', 'parseDataAll');

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

  if ($databaseConnection->connect_errno) {
    $errorMessage = "Ошибка подключения. ".
                    "MYSQLI connect_errno: {$databaseConnection->connect_errno}";
    require_once('./error.php');
  }

  // Выбор кодировки данных.
  $databaseConnection->set_charset($configuration['charset']);

  /**
   * Получение категорий и количества привязанных к ним задач.
   *
   * NB! В результирующий список добавляется виртуальный раздел INBOX (Входящие).
   *     Он позволяет управлять задачами без категорий.
   *
   * @param object $databaseConnecion — объект подключения к СУБД
   * @param integer $userID — ID пользователя по базе
   * @return array — данные из БД, сконвертированные в массив
   */
  function getCategories($databaseConnection, $userID) {
    $virtualInbox = VIRTUAL_CATEGORY_INBOX;

    $requestString = "SELECT '{$virtualInbox}' as id, 'Входящие' as name,
                              COUNT(tasks.id) as tasks_included
                      FROM tasks
                      WHERE creator_id = {$userID} AND category_id IS NULL

                      UNION

                      SELECT categories.id, categories.name, COUNT(tasks.id) as tasks_included
                      FROM categories
                      JOIN tasks ON tasks.category_id = categories.id
                      WHERE categories.creator_id = {$userID}
                      GROUP BY tasks.category_id";

    return downloadData($databaseConnection, $requestString);
  }

  /**
   * Получение задач.
   *
   * NB! Задачи без категорий определяются в виртуальный раздел INBOX (Входящие).
   *
   * @param object $databaseConnecion — объект подключения к СУБД
   * @param integer $userID — ID пользователя по базе
   * @return array — данные из БД, сконвертированные в массив
   */
  function getTasks($databaseConnection, $userID) {
    $virtualInbox = VIRTUAL_CATEGORY_INBOX;

    $requestString = "SELECT id, name, IFNULL(category_id, '{$virtualInbox}') as category_id,
                              deadline, attachment_label, attachment_filename, is_complete
                      FROM tasks
                      WHERE creator_id = {$userID}";

    return downloadData($databaseConnection, $requestString);
  }

  /**
   * Сохранение данных нового пользователя.
   *
   * @param object $databaseConnecion — объект подключения к СУБД
   * @param array $formData — данные формы регистрации
   */
  function saveUser($databaseConnection, $formData) {
    list($keys, $placeholders) = parseKeysAndPlaceholders($formData);
    $requestString = "INSERT INTO users ({$keys}) VALUES ({$placeholders})";

    uploadData($databaseConnection, $requestString, $formData);
  }

  /**
   * Сохранение данных новой задачи.
   *
   * @param object $databaseConnecion — объект подключения к СУБД
   * @param array $formData — данные формы добавления задачи
   */
  function saveTask($databaseConnection, $formData) {
    list($keys, $placeholders) = parseKeysAndPlaceholders($formData);
    $requestString = "INSERT INTO tasks ({$keys}) VALUES ({$placeholders})";

    uploadData($databaseConnection, $requestString, $formData);
  }

  /**
   * Проверка существования пользователя в БД.
   *
   * @param object $databaseConnecion — объект подключения к СУБД
   * @param string $userEmail — email адрес пользователя
   * @return array — данные из БД, сконвертированные в массив
   */
  function checkUserRegistred($databaseConnection, $userEmail) {
    $requestString = "SELECT COUNT(id) as is_registred
                      FROM users
                      WHERE email = '{$userEmail}'";

    return downloadData($databaseConnection, $requestString, PARSE_DATA_ROW);
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
   * @param string $requestString — SQL-запрос
   * @param string $parseMethod — метод обработки полученных данных
   * @return array — данные из БД, сконвертированные в массив
   */
  function downloadData($databaseConnection, $requestString, $parseMethod = PARSE_DATA_ALL) {
    $receivedData = $databaseConnection->query($requestString);

    if ($databaseConnection->errno) {
      $errorMessage = "Во время получения данных произошла ошибка. ".
                      "MYSQLI errno: {$databaseConnection->errno}";
      require_once('./error.php');
    }

    switch ($parseMethod) {
      case PARSE_DATA_ALL:
        $adaptedData = $receivedData->fetch_all(MYSQLI_ASSOC);
        break;

      case PARSE_DATA_ROW:
        $adaptedData = $receivedData->fetch_array(MYSQLI_ASSOC);
        break;
    }

    $adaptedData = convertArrayStringsToNumbers($adaptedData);

    return $adaptedData;
  }

  /**
   * Передача данных в СУБД с помощью подготовленных выражений.
   *
   * @param object $databaseConnection — объект подключения к СУБД
   * @param string $requestString — SQL-запрос с плейсхолдерами вместо значений
   * @param array $data — данные
   */
  function uploadData($databaseConnection, $requestString, $data = []) {
    $statement = $databaseConnection->prepare($requestString);

    if ($data) {
      $types = '';
      $values = [];

      foreach ($data as $value) {
        if (is_integer($value)) {
          $type = 'i';
        } else if (is_float($value)) {
          $type = 'd';
        } else if (is_string($value)) {
          $type = 's';
        } else {
          $type = null;
        }

        if ($type) {
          $types .= $type;
          $values[] = $value;
        }
      }

      $statement->bind_param($types, ...$values);
    }

    $statement->execute();

    if ($statement->errno) {
      $errorMessage = "Во время передачи данных произошла ошибка. ".
                      "MYSQLI errno: {$statement->errno}";
      require_once('./error.php');
    }
  }

  /**
   * Получение из данных формы ключей и плейсхолдеров для SQL-запроса.
   *
   * @param array $formData — данные формы
   * @return array — массив с ключами и плейсхолдерами (2 строки)
   */
  function parseKeysAndPlaceholders($formData) {
    $keys = join(', ', array_keys($formData));

    $placeholders = array_fill(0, count($formData), '?');
    $placeholders = join(', ', $placeholders);

    return [$keys, $placeholders];
  }
