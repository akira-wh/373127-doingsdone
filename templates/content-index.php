<main class="content__main">
  <h2 class="content__main-heading">Список задач</h2>

  <form class="search-form" action="index.php" method="post">
    <input class="search-form__input" type="text" name="" placeholder="Поиск по задачам" value="">
    <input class="search-form__submit" type="submit" name="" value="Искать">
  </form>

  <div class="tasks-controls">
    <nav class="tasks-switch">
      <a class="tasks-switch__item
                <?= $_SESSION['tasks_filter'] === 'all' ? 'tasks-switch__item--active' : ''; ?>"
          href="index.php?filter=all">
        Все задачи
      </a>
      <a class="tasks-switch__item
                <?= $_SESSION['tasks_filter'] === 'today' ? 'tasks-switch__item--active' : ''; ?>"
          href="index.php?filter=today">
        Повестка дня
      </a>
      <a class="tasks-switch__item
                <?= $_SESSION['tasks_filter'] === 'tomorrow' ? 'tasks-switch__item--active' : ''; ?>"
          href="index.php?filter=tomorrow">
        Завтра
      </a>
      <a class="tasks-switch__item
                <?= $_SESSION['tasks_filter'] === 'expired' ? 'tasks-switch__item--active' : ''; ?>"
          href="index.php?filter=expired">
        Просроченные
      </a>
    </nav>

    <label class="checkbox">
      <input class="checkbox__input visually-hidden show_completed"
             type="checkbox" <?= $_SESSION['show_completed_tasks'] ? 'checked' : ''; ?>>
      <span class="checkbox__text">Показывать выполненные</span>
    </label>
  </div>

  <table class="tasks">

    <?php
      foreach ($tasks as $taskData):
        if ((!isset($selectedCategoryID) || $selectedCategoryID === $taskData['category_id']) &&
            (!$taskData['is_complete'] || $_SESSION['show_completed_tasks'])):
    ?>
          <tr class="tasks__item task
                    <?= shouldHighlightTask($taskData['deadline']) ? 'task--important' : ''; ?>
                    <?= $taskData['is_complete'] ? 'task--completed' : ''; ?>">
            <td class="task__select">
              <label class="checkbox task__checkbox">
                <input class="checkbox__input visually-hidden task__checkbox"
                        type="checkbox"
                        value="<?= $taskData['id']; ?>"
                        <?= $taskData['is_complete'] ? 'checked' : ''; ?>>
                <span class="checkbox__text"><?= strip_tags($taskData['name']); ?></span>
              </label>
            </td>

            <td class="task__file">
              <?php if (isset($taskData['attachment_label'])): ?>
                <a class="download-link" href="attachments/<?= $taskData['attachment_filename']; ?>">
                  <?= controlStringLength($taskData['attachment_label'], 22); ?>
                </a>
              <?php endif; ?>
            </td>

            <td class="task__date"><?= getEuropeanDateFormat($taskData['deadline']); ?></td>
          </tr>
    <?php
        endif;
      endforeach;
    ?>

  </table>
</main>
