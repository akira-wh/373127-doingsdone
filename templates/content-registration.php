<main class="content__main">
  <h2 class="content__main-heading">Регистрация аккаунта</h2>

  <form class="form" action="registration.php" method="post">
    <div class="form__row">
      <label class="form__label" for="email">E-mail <sup>*</sup></label>
      <input class="form__input <?= isset($errors['email']) ? 'form__input--error' : '' ?>"
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
      <input class="form__input <?= isset($errors['password']) ? 'form__input--error' : '' ?>"
              id="password"
              type="password"
              name="password"
              placeholder="Введите пароль"
              value="<?= $_POST['password'] ?? ''; ?>">

      <?php if (isset($errors['password'])): ?>
        <p class="form__message"><?= $errors['password']; ?></p>
      <?php endif; ?>
    </div>

    <div class="form__row">
      <label class="form__label" for="name">Имя <sup>*</sup></label>
      <input class="form__input <?= isset($errors['name']) ? 'form__input--error' : '' ?>"
              id="name"
              type="text"
              name="name"
              placeholder="Как вас зовут?"
              value="<?= $_POST['name'] ?? ''; ?>">

      <?php if (isset($errors['name'])): ?>
        <p class="form__message"><?= $errors['name']; ?></p>
      <?php endif; ?>
    </div>

    <div class="form__row form__row--controls">

      <?php if (!empty($errors)): ?>
        <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
      <?php endif; ?>

      <input class="button" type="submit" name="" value="Зарегистрироваться">
    </div>
  </form>
</main>
