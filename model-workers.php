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
    die();
  }

  // Выбор кодировки данных.
  $databaseConnection->set_charset($configuration['charset']);

  /**
   * Получение категорий пользователя, отсортированных по алфавиту.
   *
   * @param object $databaseConnecion — объект подключения к СУБД
   * @param integer $userID — ID пользователя по базе
   * @return array — данные из БД, сконвертированные в массив
   */
  function getCategories($databaseConnection, $userID) {
    $requestString = "SELECT id, name
                      FROM categories
                      WHERE creator_id = {$userID}";

    return downloadData($databaseConnection, $requestString);
  }

  /**
   * Сохранение данных новой категории.
   *
   * @param object $databaseConnecion — объект подключения к СУБД
   * @param array $formData — данные формы регистрации
   */
  function saveCategory($databaseConnection, $formData) {
    list($keys, $placeholders) = parseKeysAndPlaceholders($formData);

    $requestString = "INSERT INTO categories ({$keys}) VALUES ({$placeholders})";

    uploadData($databaseConnection, $requestString, $formData);
  }

  /**
   * Получение задач пользователя.
   *
   * @param object $databaseConnecion — объект подключения к СУБД
   * @param integer $userID — ID пользователя по базе
   * @return array — данные из БД, сконвертированные в массив
   */
  function getTasks($databaseConnection, $userID) {
    $requestString = "SELECT id,
                              name,
                              category_id,
                              deadline,
                              attachment_label,
                              attachment_filename,
                              is_complete
                      FROM tasks
                      WHERE creator_id = {$userID}";

    return downloadData($databaseConnection, $requestString);
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
   * Обновления статуса задачи (выполнена|не выполнена).
   *
   * @param object $databaseConnecion — объект подключения к СУБД
   * @param integer $userID — ID пользователя по базе
   * @param integer $taskID — ID задачи по базе
   * @param integer $taskExecutionStatus — новый статус задачи
   */
  function updateTaskStatus($databaseConnection, $userID, $taskID, $taskExecutionStatus) {
    $requestString = "UPDATE tasks
                      SET is_complete = ?
                      WHERE id = ? AND creator_id = ?";

    uploadData($databaseConnection, $requestString, [$taskExecutionStatus, $taskID, $userID]);
  }

  /**
   * Проверка существования определенной задачи пользователя.
   *
   * @param object $databaseConnecion — объект подключения к СУБД
   * @param integer $userID — ID пользователя по базе
   * @param integer $taskID — ID задачи по базе
   * @return boolean — задача существует? true || false
   */
  function doesTaskExist($databaseConnection, $userID, $taskID) {
    $requestString = "SELECT COUNT(id) as verdict
                      FROM tasks
                      WHERE id = {$taskID} AND creator_id = {$userID}";

    $verdict = downloadData($databaseConnection, $requestString, PARSE_DATA_ROW)['verdict'];

    return (boolean) $verdict;
  }

  /**
   * Получение данных пользователя.
   *
   * @param object $databaseConnecion — объект подключения к СУБД
   * @param string $userEmail — email адрес пользователя
   * @return array — данные из БД, сконвертированные в массив
   */
  function getUser($databaseConnection, $userEmail) {
    $userEmail = $databaseConnection->real_escape_string($userEmail);

    $requestString = "SELECT * FROM users WHERE email = '{$userEmail}'";

    return downloadData($databaseConnection, $requestString, PARSE_DATA_ROW);
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
   * Проверка существования пользователя.
   *
   * @param object $databaseConnecion — объект подключения к СУБД
   * @param string $userEmail — email адрес пользователя
   * @return boolean — пользователь существует? true || false
   */
  function doesUserExist($databaseConnection, $userEmail) {
    $userEmail = $databaseConnection->real_escape_string($userEmail);

    $requestString = "SELECT COUNT(id) as verdict
                      FROM users
                      WHERE email = '{$userEmail}'";

    $verdict = downloadData($databaseConnection, $requestString, PARSE_DATA_ROW)['verdict'];

    return (boolean) $verdict;
  }

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
      die();
    }

    switch ($parseMethod) {
      case PARSE_DATA_ALL:
        $adaptedData = $receivedData->fetch_all(MYSQLI_ASSOC);
        break;

      case PARSE_DATA_ROW:
        $adaptedData = $receivedData->fetch_array(MYSQLI_ASSOC);
        break;
    }

    $adaptedData = $adaptedData ? convertArrayStringsToNumbers($adaptedData) : [];

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
      die();
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
