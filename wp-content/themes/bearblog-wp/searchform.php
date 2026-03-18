<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input
        type="search"
        class="search-field"
        placeholder="<?php esc_attr_e( 'Search…', 'bearpress' ); ?>"
        value="<?php echo esc_attr( get_search_query() ); ?>"
        name="s"
        aria-label="<?php esc_attr_e( 'Search', 'bearpress' ); ?>"
    >
    <button type="submit"><?php esc_html_e( 'Search', 'bearpress' ); ?></button>
</form>
