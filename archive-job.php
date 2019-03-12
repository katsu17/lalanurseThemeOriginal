<?php
/*
Template Name: 記事一覧ページテンプレート
*/
get_header(); ?>

<?php 

		$archive_title = '求人投稿一覧'; //タイトルはこのように表示する
?>
							<nav class="posmenu">
								<div class="contentswidth">
									<a href="/">ホーム</a> &gt; <span><?php echo $archive_title; ?></span>
								</div>
							</nav>

							<header id="contentsheaderblock" class="contentsheader">
								<div class="contentswidth">
									<h1 class="contentsheader-header" style="background: url(/img/articles-recruit-h1-bg.png) center bottom no-repeat; background-size: 77px auto;"><?php echo $archive_title; ?></h1>
								</div>
							</header>

							<div class="contentsbody recruit-column">
								<div class="contentswidth">
                  
              
                  
									<?php require_once('common_2017/adsense1box.php'); ?>
									
                  <?php if(have_posts()): ?>
									<ul class="seminarlist">	
                    <?php while(have_posts()): the_post();?>
                    <li class="listitem">
											<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											<div class="listitem__excerpt"><?php echo post_custom("wpcf-requirement"); ?></div>
                      <div class="listitem__excerpt"><?php echo post_custom("wpcf-type"); ?></div>
											<div class="listitem__button button--brown"><a href="<?php the_permalink(); ?>" class="button">詳しく見る</a></div>
										</li>
                    <?php endwhile; ?>
                  </ul>
                  <?php endif; ?>
									<div class="wp-pagenavi">
										<?php
										if ($the_query->max_num_pages > 1) {
											echo paginate_links(array(
												'base' => get_pagenum_link(1) . '%_%',
												'format' => '?paged=%#%',
												'current' => max(1, $paged),
												'total' => $the_query->max_num_pages
											));
										}
										?>
									</div>
  								</div>
							</div>
							<?php wp_reset_postdata(); ?>

							<?php require_once('common_2017/bannerblock.php'); ?>

<?php get_footer();
