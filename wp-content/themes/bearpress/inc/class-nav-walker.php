<?php
/**
 * BearPress_Nav_Walker
 *
 * Renders nav menu items as bare <a> tags — no ul, no li, no classes.
 * Matches BearBlog's inline nav style exactly.
 */
class BearPress_Nav_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		// No sub-menus rendered — BearBlog is flat nav only
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {}

	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		if ( $depth > 0 ) return; // top-level only

		$item    = $data_object;
		$classes = empty( $item->classes ) ? [] : (array) $item->classes;
		$active  = in_array( 'current-menu-item', $classes ) || in_array( 'current-page-ancestor', $classes );

		$atts              = [];
		$atts['href']      = ! empty( $item->url ) ? $item->url : '#';
		$atts['title']     = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target']    = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']       = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['aria-current'] = $active ? 'page' : '';

		// Build attribute string
		$attr_str = '';
		foreach ( array_filter( $atts ) as $key => $val ) {
			$attr_str .= ' ' . esc_attr( $key ) . '="' . esc_attr( $val ) . '"';
		}

		$output .= '<a' . $attr_str . '>' . apply_filters( 'the_title', $item->title, $item->ID ) . '</a> ';
	}

	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {}
}
