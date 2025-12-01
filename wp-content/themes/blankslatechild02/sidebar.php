  <aside>
    <?php if (is_active_sidebar('primary-widget-area')) : ?>
      <?php dynamic_sidebar('primary-widget-area'); ?>
    <?php else : ?>
      <h3>Sidebar</h3>
      <p>Add some widgets.</p>
    <?php endif; ?>
  </aside>