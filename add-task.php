<?php

  // Установка таймзоны для Казахстана, г.Алматы.
  date_default_timezone_set('Asia/Almaty');

  // Подключение библиотеки констант:
  // названия страниц, пути и названия шаблонов view, etc.
  require_once('./constants.php');

  // Подключение конфигурации СУБД, объекта соединения и связанных утилит.
  require_once('./database-connection-helper.php');

  // Подключение библиотеки функций-утилит общего назначения.
  require_once('./utils.php');

  /////////////////////////////////////////////////////////////////////////
  //
  // Сборка и рендер страницы.
  //
  /////////////////////////////////////////////////////////////////////////

  // Получение идентификатора пользователя.
  $userID = intval($_GET['user_id'] ?? 1);

  // Ошибки валидации формы.
  $errors = [];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = &$_POST;
    $attachmentData = $_FILES['attachment'];

    // Валидация поля 'Название задачи'. Должно быть заполнено.
    if (!strlen($formData['name'])) {
      $errors['name'] = 'Необходимо указать название задачи';
    }

    // Валидация поля 'Дата выполнения'.
    // Если заполнено — должно иметь валидный формат даты.
    if (strlen($formData['deadline']) && date_parse($formData['deadline'])['error_count']) {
      $errors['deadline'] = 'Дата должна быть в формате ДД.ММ.ГГГГ';
    }

    // Обработка и сохранение прикрепленного файла (если передан).
    if (!empty($attachmentData['name'])) {
      $attachmentName = $attachmentData['name'];

      $nameParts = explode('.', $attachmentName);
      $extension = array_pop($nameParts);

      $attachmentFilename = uniqid() . ".{$extension}";

      $tempPath = $attachmentData['tmp_name'];
      $newPath = __DIR__ . '/attachments/' . $attachmentFilename;
      move_uploaded_file($tempPath, $newPath);

      // Добавление в форму данных обработанного файла.
      $formData['attachment_name'] = $attachmentName;
      $formData['attachment_filename'] = $attachmentFilename;
    }

    // Если форма заполнена корректно — отправка данных в СУБД.
    if (empty($errors)) {
      // Запись в форму ID пользователя.
      $formData['creator_id'] = $userID;

      // Удаление из формы пустых необязательных полей.
      // Удаление ссылки на виртуальный раздел INBOX (Входящие).
      foreach ($formData as $field => $value) {
        if (empty($value) ||
            ($field === 'category_id' && $value === VIRTUAL_CATEGORY_ID['inbox'])) {
          unset($formData[$field]);
        }
      }

      // Конвертация данных формы в SQL-запрос.
      $formKeys = implode(', ', array_keys($formData));
      $formValues = implode("', '", $formData);
      $requestString = "INSERT INTO tasks ({$formKeys}) VALUES ('{$formValues}')";

      // Отправка данных и автопереход на главную страницу.
      uploadData($databaseConnection, $requestString);
      header('Location: index.php');
    }
  }

  // Получение категорий, задач и статистики по ним из БД.
  $categories = downloadData($databaseConnection, compileRequestForCategories($userID));

  // Название страницы.
  $pageTitle = PAGE_TITLE['addTask'];

  // Сборка header.
  $pageHeader = fillView(VIEW['siteHeader']);

  // Сборка sidebar (список категорий).
  $pageSidebar = fillView(VIEW['sidebarCategories'], ['categories' => $categories]);

  // Сборка основного контента.
  $pageContent = fillView(VIEW['contentAddTask'], [
    'categories' => $categories,
    'errors' => $errors
  ]);

  // Сборка footer.
  $pageFooter = fillView(VIEW['siteFooter']);

  // Сборка основной раскладки и метаинформации страницы.
  $pageLayout = fillView(VIEW['siteLayout'], [
    'pageTitle' => $pageTitle,
    'pageHeader' => $pageHeader,
    'pageSidebar' => $pageSidebar,
    'pageContent' => $pageContent,
    'pageFooter' => $pageFooter
  ]);

  // Рендер страницы.
  print($pageLayout);
