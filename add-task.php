<?php

  // Установка таймзоны для Казахстана, г.Алматы.
  date_default_timezone_set('Asia/Almaty');

  // Сессия.
  require_once('./session.php');

  // Библиотека констант.
  require_once('./constants.php');

  // Настройки и утитлиты для работы с моделью.
  require_once('./model-workers.php');

  // Библиотека утилит общего назначения.
  require_once('./utils.php');

  /////////////////////////////////////////////////////////////////////////
  //
  // Сборка и рендер страницы.
  //
  /////////////////////////////////////////////////////////////////////////

  // Если пользователь неавторизирован — редирект на гостевую страницу.
  if (!isset($_SESSION['user'])) {
    header('Location: guest.php');
  }

  // Получение идентификатора пользователя.
  $userID = $_SESSION['user']['id'];

  // Получение категорий, задач и статистики по ним из БД.
  $categories = getCategories($databaseConnection, $userID);
  $tasks = getTasks($databaseConnection, $userID);
  plugVirtualInbox($categories, $tasks);
  plugStatistic($categories, $tasks);

  // Ошибки валидации формы.
  $errors = [];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Оригинальные названия полей формы.
    // Используются для проверки целостности формы.
    $originalFieldsNames = [
      'name',
      'category_id',
      'deadline'
    ];

    // Проверка целостности формы.
    // Если заводские поля отсутствуют или присутствуют инородные — отображение ошибки.
    if (isFormIntegrityBroken($originalFieldsNames, $_POST)) {
      $errorMessage = FORM_ERROR_MESSAGE['integrityBroken'];
      require_once('./error.php');
      die();
    }

    // Обрезка обрамляющих пробелов у полей.
    $_POST = trimStringsSpaces($_POST);

    // Валидация поля 'Название задачи' —  должно быть заполнено.
    if (!strlen($_POST['name'])) {
      $errors['name'] = FORM_ERROR_MESSAGE['valueMissing'];
      // Длина не должна превышать объем ячейки в таблице пользователей.
    } else if (strlen($_POST['name']) > MAX_TASK_NAME_LENGTH) {
      $errors['name'] = FORM_ERROR_MESSAGE['taskNameTooLong'];
    }

    // Валидация поля 'Выбор категории (проекта)'.
    // У пользователя должна существовать выбранная категория.
    $userCategoriesID = array_column($categories, 'id');
    if (!in_array($_POST['category_id'], $userCategoriesID)) {
      $errors['category_id'] = FORM_ERROR_MESSAGE['selectedCategoryNotExist'];
    }

    // Валидация поля 'Дата выполнения' (если заполнено).
    if (strlen($_POST['deadline'])) {
      // Дата должна иметь валидный формат.
      if (date_parse($_POST['deadline'])['error_count']) {
        $errors['deadline'] = FORM_ERROR_MESSAGE['incorrectDateFormat'];
          // Нельзя наметить выполнение задачи на дату из прошлого.
      } else if (strtotime($_POST['deadline']) <= strtotime('-1 day')) {
        $errors['deadline'] = FORM_ERROR_MESSAGE['dateFromThePast'];
      }
    }

    // Если форма заполнена корректно — формирование и отправка данных в СУБД.
    if (empty($errors)) {
      // Обработка прикрепленного файла (если передан).
      if (isset($_FILES['attachment']) && !empty($_FILES['attachment']['name'])) {
        $attachmentData = $_FILES['attachment'];

        $attachmentLabel = $attachmentData['name'];
        $labelParts = explode('.', $attachmentLabel);
        $extension = array_pop($labelParts);

        $attachmentFilename = uniqid() . ".{$extension}";

        $tempPath = $attachmentData['tmp_name'];
        $newPath = __DIR__ . '/attachments/' . $attachmentFilename;
        move_uploaded_file($tempPath, $newPath);

        // Добавление в форму данных обработанного файла.
        $_POST['attachment_label'] = $attachmentLabel;
        $_POST['attachment_filename'] = $attachmentFilename;
      }

      // Запись в форму ID пользователя.
      $_POST['creator_id'] = $userID;

      // Удаление из формы пустых необязательных полей.
      // Удаление ссылки на виртуальный раздел INBOX (Входящие).
      foreach ($_POST as $field => $value) {
        if (empty($value) || ($field === 'category_id' && $value === VIRTUAL_CATEGORY_INBOX)) {
          unset($_POST[$field]);
        }
      }

      // Сохранение задачи и редирект на главную страницу.
      saveTask($databaseConnection, $_POST);
      header('Location: index.php');
    }
  }

  // Сборка основной раскладки и метаинформации страницы.
  $pageLayout = fillView(VIEW['siteLayout'], [
    'pageTitle' => PAGE_TITLE['addTask'],

    'pageHeader' => fillView(VIEW['siteHeader']),

    'pageSidebar' => fillView(VIEW['sidebarCategories'], [
      'categories' => $categories
    ]),

    'pageContent' => fillView(VIEW['contentAddTask'], [
      'categories' => $categories,
      'errors' => $errors
    ]),

    'pageFooter' => fillView(VIEW['siteFooter'])
  ]);

  // Рендер страницы.
  print($pageLayout);
