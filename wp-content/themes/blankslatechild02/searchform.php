<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
  <label>
    <span class="screen-reader-text">Search for:</span>
    <input type="search" class="search-field" placeholder="Search…" value="<?php echo get_search_query(); ?>" name="s" />
  </label>
  <button type="submit" class="search-submit">Search</button>
</form>

<style>
.search-form { display: flex; gap: 0.5rem; justify-content: center; }
.search-field { padding: 0.65rem 0.9rem; border-radius: 10px; border: 1px solid #bbb; min-width: min(420px, 70vw); }
.search-submit { padding: 0.65rem 0.9rem; border-radius: 10px; border: 1px solid #bbb; background: transparent; }
</style>