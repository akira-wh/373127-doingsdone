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

  // Ошибки валидации формы.
  $errors = [];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Защита строк от влияния обрамляющих пробелов.
    foreach ($_POST as $key => $value) {
      $_POST[$key] = trim($value);
    }

    // Валидация поля 'Название задачи'. Должно быть заполнено.
    if (!strlen($_POST['name'])) {
      $errors['name'] = 'Необходимо указать название задачи';
    }

    // Валидация поля 'Дата выполнения' (если заполнено).
    if (strlen($_POST['deadline'])) {
      // Поле должно иметь валидный формат даты.
      if (date_parse($_POST['deadline'])['error_count']) {
        $errors['deadline'] = 'Дата должна быть в формате ДД.ММ.ГГГГ';

        // Дата выполнения задачи не должна быть раньше, чем дата создания.
      } else if (strtotime($_POST['deadline']) <= strtotime('-1 day')) {
        $errors['deadline'] = 'Дата выполнения задачи не должна быть раньше, чем дата создания';
      }
    }

    // Обработка и сохранение прикрепленного файла (если передан).
    $attachmentData = $_FILES['attachment'];

    if (!empty($attachmentData['name'])) {
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

    // Если форма заполнена корректно — отправка данных в СУБД.
    if (empty($errors)) {
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

  // Получение категорий, задач и статистики по ним из БД.
  $categories = getCategories($databaseConnection, $userID);
  $tasks = getTasks($databaseConnection, $userID);
  plugVirtualInbox($categories, $tasks);
  plugStatistic($categories, $tasks);

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
