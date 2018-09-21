<main class="content__main">
  <h2 class="content__main-heading">Список задач</h2>

  <form class="search-form" action="index.php" method="post">
    <input class="search-form__input" type="text" name="" placeholder="Поиск по задачам" value="">
    <input class="search-form__submit" type="submit" name="" value="Искать">
  </form>

  <div class="tasks-controls">
    <nav class="tasks-switch">
      <a class="tasks-switch__item tasks-switch__item--active" href="/">Все задачи</a>
      <a class="tasks-switch__item" href="/">Повестка дня</a>
      <a class="tasks-switch__item" href="/">Завтра</a>
      <a class="tasks-switch__item" href="/">Просроченные</a>
    </nav>

    <label class="checkbox">
      <input class="checkbox__input visually-hidden show_completed"
             type="checkbox" <?= ($shouldShowCompletedTasks) ? 'checked' : ''; ?>>
      <span class="checkbox__text">Показывать выполненные</span>
    </label>
  </div>

  <table class="tasks">
    <?php foreach ($tasks as $task): ?>
      <?php
        // Защита от вредоносного пользовательского ввода.
        $taskName = strip_tags($task['name']);
      ?>
      <?php if (!$task['isComplete']): ?>
        <tr class="tasks__item task">
          <td class="task__select">
            <label class="checkbox task__checkbox">
              <input class="checkbox__input visually-hidden task__checkbox"
                      type="checkbox"
                      value="1">
              <span class="checkbox__text"><?= $taskName; ?></span>
            </label>
          </td>

          <td class="task__file">
            <a class="download-link" href="#">Home.psd</a>
          </td>

          <td class="task__date"><?= $task['deadline'] ?></td>
        </tr>
      <?php elseif ($shouldShowCompletedTasks): ?>
        <tr class="tasks__item task task--completed">
          <td class="task__select">
            <label class="checkbox task__checkbox">
              <input class="checkbox__input visually-hidden"
                      type="checkbox"
                      checked>
              <span class="checkbox__text"><?= $taskName; ?></span>
            </label>
          </td>

          <td class="task__date"><?= $task['deadline'] ?></td>

          <td class="task__controls"></td>
        </tr>
      <?php endif; ?>
    <?php endforeach; ?>
  </table>
</main>
