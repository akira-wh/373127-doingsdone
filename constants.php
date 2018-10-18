<?php

  /**
   * Путь к директории с шаблонами view (путь относительный).
   */
  define('VIEWS_DIRECTORY_PATH', './templates/');

  /**
   * Названия шаблонов view.
   */
  define('VIEW', [
    // Контент гостевой страницы.
    'contentGuest' => 'content-guest.php',

    // Контент главной страницы.
    'contentIndex' => 'content-index.php',

    // Контент страницы авторизации пользователя.
    'contentLogin' => 'content-login.php',

    // Контент страницы регистрации пользователя.
    'contentRegistration' => 'content-registration.php',

    // Контент страницы добавления задач.
    'contentAddTask' => 'content-add-task.php',

    // Контент страницы добавления категории.
    'contentAddCategory' => 'content-add-category.php',

    // Контент страницы вывода ошибки.
    'contentError' => 'content-error.php',

    // Сайдбар со списком категорий (проектов).
    'sidebarCategories' => 'sidebar-categories.php',

    // Сайдбар с предложением авторизироваться.
    'sidebarLogin' => 'sidebar-login.php',

    // Сетка-каркас всех страниц сайта.
    'siteLayout' => 'site-layout.php',

    // Header сайта.
    'siteHeader' => 'site-header.php',

    // Footer сайта.
    'siteFooter' => 'site-footer.php'
  ]);

  /**
   * Названия страниц сайта.
   */
  define('PAGE_TITLE', [
    // Гостевая страница
    'guest' => '',

    // Страница авторизации.
    'login' => '— Авторизация',

    // Главная страница.
    'index' => '— Главная',

    // Страница добавления задач.
    'addTask' => '— Добавление задачи',

    // Страница добавления категорий.
    'addCategory' => '— Добавление проекта',

    // Страница регистрации.
    'registration' => '— Регистрация нового пользователя',

    // Страница отображения ошибки.
    'error' => '— Ошибка'
  ]);

  /**
   * Идентификатор виртуального раздела INBOX (Входящие).
   */
  define('VIRTUAL_CATEGORY_INBOX', 'inbox');

  /**
   * НОЛЬ — начало отсчета.
   */
  define('ZERO_COUNT', 0);

  /**
   * Максимально допустимая длина имени пользователя.
   */
  define('MAX_USERNAME_LENGTH', 64);

  /**
   * Максимально допустимая длина названия задачи.
   */
  define('MAX_TASK_NAME_LENGTH', 255);

  /**
   * Максимально допустимая длина названия категории.
   */
  define('MAX_CATEGORY_NAME_LENGTH', 64);

  /**
   * Максимально допустимая длина пользовательского email.
   */
  define('MAX_EMAIL_LENGTH', 100);

  /**
   * Сообщения об ошибках валидации форм.
   */
  define('FORM_ERROR_MESSAGE', [
    'integrityBroken' => 'Нарушена целостность и безопасность данных формы.<br>Повторите отправку позже.',

    'valueMissing' => 'Это поле необходимо заполнить',

    'usernameTooLong' => 'Имя превышает максимально допустимую длину в '.
                          MAX_USERNAME_LENGTH.' символов',

    'taskNameTooLong' => 'Название задачи превышает максимально допустимую длину в '.
                          MAX_TASK_NAME_LENGTH.' символов',

    'categoryNameTooLong' => 'Название категории превышает максимально допустимую длину в '.
                              MAX_CATEGORY_NAME_LENGTH.' символов',

    'emailTooLong' => 'Email превышает максимально допустимую длину в '.
                        MAX_EMAIL_LENGTH.' символов',

    'emailAlreadyRegistred' => 'Пользователь с указаным почтовым ящиком уже зарегистрирован',

    'emailNotRegistred' => 'Указанный почтовый ящик не зарегистрирован в системе',

    'selectedCategoryNotExist' => 'Выбранная категория не существует',

    'categoryAlreadyExist' => 'Указанная категория уже существует',

    'incorrectDateFormat' => 'Дата должна быть в формате ДД.ММ.ГГГГ',

    'incorrectEmailFormat' => 'Введенный email имеет некорректный формат',

    'incorrectPassword' => 'Вы ввели неверный пароль',

    'dateFromThePast' => 'Нельзя наметить выполнение задачи на дату из прошлого'
  ]);
