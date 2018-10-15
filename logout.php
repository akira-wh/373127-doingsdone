<?php

  // Закрытие сессии и редирект на гостевую страницу.
  if (isset($_SESSION)) {
    $_SESSION = [];
    header('Location: /');
  }
