<!DOCTYPE html>
<html lang="ru">

  <head>
    <meta charset="UTF-8">
    <title>Дела в порядке <?= $pageTitle; ?></title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/flatpickr.min.css">
  </head>

  <body <?= basename($_SERVER['PHP_SELF']) === 'guest.php' ? 'class="body-background"' : ''; ?>>
    <h1 class="visually-hidden">Дела в порядке</h1>

    <div class="page-wrapper">
      <div class="container <?= isset($pageSidebar) ? 'container--with-sidebar' : ''; ?>">
        <?= $pageHeader; ?>

        <div class="content">
          <?= $pageSidebar ?? ''; ?>
          <?= $pageContent; ?>
        </div>

      </div>
    </div>

    <?= $pageFooter; ?>

    <script src="flatpickr.js"></script>
    <script src="script.js"></script>
  </body>
</html>
