<main class="content__main">
  <h2 class="content__main-heading">Вход на сайт</h2>

  <form class="form" action="login.php" method="post">
    <div class="form__row">
      <label class="form__label" for="email">E-mail <sup>*</sup></label>
      <input class="form__input <?= isset($errors['email']) ? 'form__input--error' : ''; ?>"
              id="email"
              type="email"
              name="email"
              placeholder="Введите e-mail"
              value="<?= $_POST['email'] ?? ''; ?>">

      <?php if (isset($errors['email'])): ?>
        <p class="form__message"><?= $errors['email']; ?></p>
      <?php endif; ?>
    </div>

    <div class="form__row">
      <label class="form__label" for="password">Пароль <sup>*</sup></label>
      <input class="form__input <?= isset($errors['password']) ? 'form__input--error' : ''; ?>"
              id="password"
              type="password"
              name="password"
              placeholder="Введите пароль"
              value="<?= $_POST['password'] ?? ''; ?>">

      <?php if (isset($errors['password'])): ?>
        <p class="form__message"><?= $errors['password']; ?></p>
      <?php endif; ?>
    </div>

    <div class="form__row form__row--controls">
      <input class="button" type="submit" value="Войти">
    </div>
  </form>
</main>
