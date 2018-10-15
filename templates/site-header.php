<header class="main-header">
  <a href="index.php">
    <img src="img/logo.png" width="153" height="42" alt="Логотип Дела в порядке">
  </a>

  <div class="main-header__side">

    <?php if (isset($_SESSION['user'])): ?>
      <a class="main-header__side-item button button--plus open-modal" href="add-task.php">
        Добавить задачу
      </a>

      <div class="main-header__side-item user-menu">
        <div class="user-menu__image">
          <img src="img/user-pic.jpg" width="40" height="40" alt="<?= $_SESSION['user']['name']; ?>">
        </div>

        <div class="user-menu__data">
          <p><?= $_SESSION['user']['name']; ?></p>
          <a href="logout.php">Выйти</a>
        </div>
      </div>
    <? else: ?>
      <a class="main-header__side-item button button--transparent" href="login.php">Войти</a>
    <? endif; ?>

  </div>
</header>
