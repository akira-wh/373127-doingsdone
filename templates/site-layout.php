<?php

  // Содержит ли страница сайдбар? TRUE || FALSE.
  //
  // Данный параметр влияет на сетку страницы:
  // 1. Дополнительный класс-модификатор для div.container,
  // 2. Вывод самого сайдбара в контейнер div.content.
  $doesPageContainsSidebar = isset($pageSidebar);
?>

<!DOCTYPE html>
<html lang="ru">

  <head>
    <meta charset="UTF-8">
    <title><?= $pageTitle; ?></title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/flatpickr.min.css">
  </head>

  <body>
    <h1 class="visually-hidden">Дела в порядке</h1>

    <div class="page-wrapper">
      <div class="container <?= ($doesPageContainsSidebar) ? 'container--with-sidebar' : ''; ?>">
        <!-- HEADER HERE -->
        <?= $pageHeader; ?>

        <div class="content">
          <!-- SIDEBAR HERE (OPTIONAL) -->
          <?= ($doesPageContainsSidebar) ? $pageSidebar : ''; ?>

          <!-- CONTENT HERE -->
          <?= $pageContent; ?>
        </div>
      </div>
    </div>

    <!-- FOOTER HERE -->
    <?= $pageFooter; ?>

    <script src="flatpickr.js"></script>
    <script src="script.js"></script>
  </body>
</html>
