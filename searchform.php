<?php
/**
 * The template for custom Mode search form
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mode
 */
?>

<form class="site-search" action="/" role="search" method="get" id="searchform">
    <label>
        <span class="screen-reader-text"><?php esc_attr_e( 'Search:', 'mode' ); ?></span>
        <input type="text" name="s" id="search" class="site-search_input" value="<?php the_search_query(); ?>" placeholder="<?php esc_attr_e( 'Search and hit enter...', 'mode' ); ?>">
    </label>
    <button type="submit" id="searchsubmit" class="site-search_submit">
        <i class="mo mo-search" aria-hidden="true"></i>
    </button>
</form>