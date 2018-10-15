<?php

  // Сессия.
  require_once('./session.php');

  // Закрытие сессии и редирект на гостевую страницу.
  if (isset($_SESSION['user'])) {
    $_SESSION = [];
  }

  header('Location: index.php');
