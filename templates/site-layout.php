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
      <div class="container <?= (isset($pageSidebar)) ? 'container--with-sidebar' : ''; ?>">
        <!-- HEADER HERE -->
        <?= $pageHeader; ?>

        <div class="content">
          <!-- SIDEBAR HERE (OPTIONAL) -->
          <?= (isset($pageSidebar)) ? $pageSidebar : ''; ?>

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
