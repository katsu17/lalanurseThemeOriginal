<?php

/*
Template Name: 記事一覧ページテンプレート
*/
get_header(); ?>

<?php 

	if (is_tax()) { //カスタム分類のアーカイブである場合
		$taxonomy_slug = get_query_var('taxonomy'); //表示するカスタム分類のタクソノミースラッグを取得
		$term_title = single_term_title("", false); //PHPで使えるようにタクソノミータイトルを取得
		if ($taxonomy_slug == 'pref' || $taxonomy_slug == 'company') { //「地域」または「団体」のアーカイブを表示している場合
			$archive_title = $term_title . 'の求人情報一覧'; //タイトルはこのように表示する
		} elseif ($taxonomy_slug == 'target') { //または「対象職種」のアーカイブを表示している場合
			$archive_title = $term_title . 'の掲載記事一覧'; //タイトルはこのように表示する
		} else { //そのいずれでもない場合
			$archive_title = $term_title . '一覧'; //タイトルはこのように表示する
		}
  }elseif(is_archive) {
    $posttype_slug = esc_html(get_post_type_object(get_post_type())->name);
    $archive_title = esc_html(get_post_type_object(get_post_type())->label ).'一覧';
	} else { //カスタム分類のアーカイブでない、全ての記事一覧の場合
		$archive_title = '掲載記事一覧'; //タイトルはこのように表示する
	}
?>
							<nav class="posmenu">
								<div class="contentswidth">
									<a href="/">ホーム</a> &gt; <span><?php echo $archive_title; ?></span>
								</div>
							</nav>

							<header id="contentsheaderblock" class="contentsheader aaa">
								<div class="contentswidth">
								<?php if ($taxonomy_slug == 'pref' || $taxonomy_slug == 'company' || $term == 'recruit'): //これらの分類のアーカイブの場合、カバーに表示するアイコンを変える ?>
									<h1 class="contentsheader-header" style="background: url(/img/articles-recruit-h1-bg.png) center bottom no-repeat; background-size: 77px auto;"><?php echo $archive_title; ?></h1>
								<?php else: ?>
									<h1 class="contentsheader-header"><?php echo $archive_title; ?></h1>
								<?php endif; ?>
								</div>
							</header>

							<div class="contentsbody recruit-column">
								<div class="contentswidth">
                  
                  <?php
                    // [ user.php ]
                    if(isset($_GET['status'])) {
                        $status = $_GET['status'];
                    }
                  ?>
                  <?php if($term == 'recruit'): //ここを編集 ?>
                  <?php
                    $args = array(
                      'post_type' =>'job',
                      'posts_per_page' => 3,
                    );
                    $the_query = new WP_Query( $args );
                    if($the_query->have_posts()):
                  ?>
                  <ul class="seminarlist">	
                  <?php while($the_query->have_posts()): $the_query->the_post(); ?>
									
                    <li class="listitem">
											<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											<div class="listitem__excerpt"><?php echo post_custom("wpcf-requirement"); ?></div>
                      <div class="listitem__excerpt"><?php echo post_custom("wpcf-type"); ?></div>
											<div class="listitem__button button--brown"><a href="<?php the_permalink(); ?>" class="button">詳しく見る</a></div>
										</li>
                  
                  <?php endwhile; ?>
                  </ul>
                  <div class="archive_link">
                    <a href="/job/" class="button button--white"><span>すべての求人情報を見る</span></a>
                  </div>
                  <?php endif; ?>
                  <?php endif; ?>
                  
                  
                  
									<?php get_template_part('parts/archive-articles/searchbox'); ?>
									<?php require_once('common_2017/adsense1box.php'); ?>
									
									<ul class="columnlist">
										<?php
										//$paged = (int) get_query_var('paged');
										$paged = (int) get_query_var('page');
										if (is_tax()) { //カスタム分類のアーカイブの場合
											$taxonomy = get_query_var('taxonomy');
											$args = array(
												'paged' => $paged,
												'posts_per_page' => 9,
												'post_type' => 'articles',
												'tax_query' => array(
													'relation' => 'AND', array(
														'taxonomy' => $taxonomy,
														'field' => 'slug',
														'terms' => $term
													)
												),
												'orderby' => 'date',
												'order' => 'DESC',
												'post_status' => 'publish'
											);
										} else { //記事コンテンツ全てのアーカイブの場合
											$args = array(
												'paged' => $paged,
												'posts_per_page' => 9,
												'post_type' => 'articles',
												'orderby' => 'date',
												'order' => 'DESC',
												'post_status' => 'publish'
											);
										}
										$the_query = new WP_Query($args);
										if ( $the_query->have_posts() ) :
											while ( $the_query->have_posts() ) : $the_query->the_post();
										?>
										<?php get_template_part('parts/archive-articles/archive-loop'); ?>
										<?php endwhile; endif; ?>
									</ul>
									<div class="wp-pagenavi">
										<?php
										if ($the_query->max_num_pages > 1) {
											echo paginate_links(array(
												//'base' =>  . '%_%',
												'base' => remove_query_arg( 'page' ) . '%_%',
												'format' => '?page=%#%',
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
