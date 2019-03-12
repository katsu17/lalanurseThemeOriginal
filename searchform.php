<?php
/**
 * Template for displaying search forms in Twenty Seventeen
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
?>

<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo $unique_id; ?>">
		<span class="screen-reader-text">検索：</span>
	</label>
	<input type="search" id="<?php echo $unique_id; ?>" class="search-field" placeholder="検索内容..." value="<?php echo get_search_query(); ?>" name="s" style="margin: 0 20px;" />
  <!--<input type="hidden" name="post_type" value="seminar">-->
	<button type="submit" class="search-submit"><span class="screen-reader-text">検索</span></button>
</form>
