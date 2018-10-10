<section class="content__side">
  <h2 class="content__side-heading">Проекты</h2>

  <nav class="main-navigation">
    <ul class="main-navigation__list">

      <?php foreach ($categories as $categoryData): ?>
        <li class="main-navigation__list-item">
          <a class="main-navigation__list-item-link" href="index.php?category_id=<?= $categoryData['id']; ?>">
            <?= strip_tags($categoryData['name']); ?>
          </a>
          <span class="main-navigation__list-item-count">
            <?= $categoryData['tasks_included']; ?>
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
