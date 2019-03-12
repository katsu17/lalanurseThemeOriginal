<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

							<?php if(have_posts()): while(have_posts()): the_post(); ?>
							
							<nav class="posmenu">
								<div class="contentswidth">
									<a href="/">ホーム</a> &gt; <span><?php the_title(); ?></span>
								</div>
							</nav>
							
							<header id="contentsheaderblock" class="contentsheader">
								<div class="contentswidth">
									<h1 class="contentsheader-header"><?php the_title(); ?></h1>
								</div>
							</header>
							
							<div class="contentsbody detail-content">
								<div class="contentswidth">
									<?php the_content() ?>
								</div>
							</div>

							<?php endwhile; endif; ?>
							<?php wp_reset_postdata(); ?>

<?php get_footer();
