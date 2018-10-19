<main class="content__main">
  <h2 class="content__main-heading">Добавление задачи</h2>

  <form class="form" action="add-task.php" method="post" enctype="multipart/form-data">
    <div class="form__row">
      <label class="form__label" for="name">Название <sup>*</sup></label>
      <input class="form__input <?= isset($errors['name']) ? 'form__input--error' : ''; ?>"
              id="name"
              type="text"
              name="name"
              placeholder="Введите название"
              value="<?= $_POST['name'] ?? ''; ?>">

      <?php if (isset($errors['name'])): ?>
        <p class="form__message">
          <span class="form__message error-message"><?= $errors['name']; ?></span>
        </p>
      <?php endif; ?>

    </div>

    <div class="form__row">
      <label class="form__label" for="category_id">Проект</label>
      <select class="form__input form__input--select" id="category_id" name="category_id">

        <?php foreach ($categories as $categoryData): ?>
          <option value="<?= $categoryData['id'] ?>"><?= $categoryData['name'] ?></option>
        <?php endforeach; ?>

      </select>

      <?php if (isset($errors['category_id'])): ?>
        <p class="form__message">
          <span class="form__message error-message"><?= $errors['category_id']; ?></span>
        </p>
      <?php endif; ?>
    </div>

    <div class="form__row">
      <label class="form__label" for="deadline">Дата выполнения</label>
      <input class="form__input form__input--date <?= isset($errors['deadline']) ? 'form__input--error' : ''; ?>"
              id="deadline"
              type="date"
              name="deadline"
              placeholder="Введите дату в формате ДД.ММ.ГГГГ"
              value="<?= $_POST['deadline'] ?? ''; ?>">

      <?php if (isset($errors['deadline'])): ?>
        <p class="form__message">
          <span class="form__message error-message"><?= $errors['deadline']; ?></span>
        </p>
      <?php endif; ?>

    </div>

    <div class="form__row">
      <label class="form__label" for="attachment">Файл</label>
      <div class="form__input-file">
        <input class="visually-hidden"
                id="attachment"
                type="file"
                name="attachment">
        <label class="button button--transparent" for="attachment">
          <span>Выберите файл</span>
        </label>
      </div>
    </div>

    <div class="form__row form__row--controls">
      <input class="button" type="submit" value="Добавить">
    </div>
  </form>
</main>
