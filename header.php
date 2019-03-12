<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"  dir="ltr" lang="ja" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
<?php require_once('common_2017/headercontents.php'); ?>
	<?php wp_head(); ?>
</head>

<?php
	if (is_archive()) {
		if (is_category()) {
			$body_class = 'seminar';
		} else {
			$body_class = 'articles';
		}
	} else if (is_page('seminar')) {
		$body_class = 'seminar';
	} else if (is_singular('articles')) {
		$body_class = 'articles';
		$body_sub_class = 'detail';
	} else if (is_single()) {
		$body_class = 'seminar';
		$body_sub_class = 'detail';
	} else if (is_front_page()) {
		$body_class = 'home';
	} else {
		$body_class = get_post($wp_query->post->ID)->post_name;
	}
?>

<body class="<?php echo esc_html($body_class); if (!empty($body_sub_class)) {echo ' '.esc_html($body_sub_class);} ?>" data-headermainmenu="<?php echo esc_html($body_class) ?>">
	<?php if(!is_mobile()): ?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.9&appId=1477585108983544";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<?php endif; ?>

	<div id="allwrapperblock">
		<?php require_once('common_2017/headerblock.php'); ?>
		<div id="scrollblock">
			<div id="scrollwrapperblock">
				<div id="contentsblock">
					<article>