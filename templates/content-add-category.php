<main class="content__main">
  <h2 class="content__main-heading">Добавление проекта</h2>

  <form class="form"  action="add-category.php" method="post">
    <div class="form__row">
      <label class="form__label" for="project_name">Название <sup>*</sup></label>
      <input class="form__input <?= isset($errors['name']) ? 'form__input--error' : ''; ?>"
              id="project_name"
              type="text"
              name="name"
              placeholder="Введите название проекта"
              value="<?= $_POST['name'] ?? ''; ?>">

      <?php if (isset($errors['name'])): ?>
        <p class="form__message">
          <span class="form__message error-message"><?= $errors['name']; ?></span>
        </p>
      <?php endif; ?>
    </div>

    <div class="form__row form__row--controls">
      <input class="button" type="submit" value="Добавить">
    </div>
  </form>
</main>
