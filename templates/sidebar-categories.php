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
            <?= $categoryData['active_tasks']; ?>
          </span>
        </li>
      <?php endforeach; ?>

    </ul>
  </nav>

  <a class="button button--transparent button--plus content__side-button"
      href="add-category.php">
    Добавить проект
  </a>
</section>
