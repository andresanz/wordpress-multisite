    </main><!-- #main -->

    <footer class="site-footer">
        <?php
        $footer_text = get_theme_mod( 'bearpress_footer_text', '' );
        if ( $footer_text ) {
            echo wp_kses_post( $footer_text );
        } else {
            printf(
                '<a href="%s">%s</a>',
                esc_url( home_url( '/' ) ),
                esc_html( get_bloginfo( 'name' ) )
            );
        }
        ?>
    </footer>

</div><!-- .site-wrapper -->

<?php wp_footer(); ?>
</body>
</html>
