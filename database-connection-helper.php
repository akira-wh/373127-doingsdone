<?php

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

  // Кодировка данных.
  $databaseConnection->set_charset($configuration['charset']);

  /////////////////////////////////////////////////////////////////////////
  //
  // Утилиты для работы с СУБД.
  //
  /////////////////////////////////////////////////////////////////////////

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
        return is_integer($item + 0) ? (integer) $item : (float) $item;
      }

      // В иных случаях конвертация не производится.
      return $item;
    }, $data);
  }
