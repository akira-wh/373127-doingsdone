<section class="content__side">
  <h2 class="content__side-heading">Проекты</h2>

  <nav class="main-navigation">
    <ul class="main-navigation__list">

      <?php foreach ($categories as $category): ?>
        <?php
          // Защита от вредоносного пользовательского ввода.
          $categoryName = strip_tags($category);

          // Количество задач, входящих в категорию.
          $categoryTasksNumber = countCategoryTasks($category, $tasks);
        ?>
        <li class="main-navigation__list-item">
          <a class="main-navigation__list-item-link" href="#">
            <?= $categoryName; ?>
          </a>
          <span class="main-navigation__list-item-count">
            <?= $categoryTasksNumber; ?>
          </span>
        </li>
      <?php endforeach; ?>

    </ul>
  </nav>

  <a class="button button--transparent button--plus content__side-button"
      href="pages/form-project.html" target="project_add">
    Добавить проект
  </a>
</section>
