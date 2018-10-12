<main class="content__main">
  <h2 class="content__main-heading">Добавление задачи</h2>

  <form class="form" action="index.html" method="post">
    <div class="form__row">
      <label class="form__label" for="name">Название <sup>*</sup></label>
      <input class="form__input"
              id="name"
              type="text"
              name="name"
              placeholder="Введите название"
              value="">
    </div>

    <div class="form__row">
      <label class="form__label" for="project">Проект <sup>*</sup></label>
      <select class="form__input form__input--select" id="project" name="project">
        <option value="">Входящие</option>
      </select>
    </div>

    <div class="form__row">
      <label class="form__label" for="date">Дата выполнения</label>
      <input class="form__input form__input--date"
              id="date"
              type="date"
              name="date"
              placeholder="Введите дату в формате ДД.ММ.ГГГГ"
              value="">
    </div>

    <div class="form__row">
      <label class="form__label" for="preview">Файл</label>
      <div class="form__input-file">
        <input class="visually-hidden"
                id="preview"
                type="file"
                name="preview"
                value="">
        <label class="button button--transparent" for="preview">
          <span>Выберите файл</span>
        </label>
      </div>
    </div>

    <div class="form__row form__row--controls">
      <input class="button" type="submit" name="" value="Добавить">
    </div>
  </form>
</main>
