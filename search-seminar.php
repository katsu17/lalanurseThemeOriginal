<?php
get_header(); ?>
<?php
	if (is_page('seminar')) { //研修会情報一覧ページで表示されている場合
		$the_cat_name = ''; //現在のカテゴリー名を取得しない
		$archive_title = 'セミナー・研修会情報';
	} else { //それ以外で（研修会情報一覧から地域で絞り込んで）表示されている場合
		$the_cat_name = single_cat_title('', false); //現在のカテゴリー（地域）名を取得する
		$archive_title = $the_cat_name . 'のセミナー・研修会情報';
	}
  if (have_posts()){
    $archive_title = get_search_query()."の検索結果";
  }else{
    $archive_title ="検索結果なし";
  }
?>
							<nav class="posmenu">
								<div class="contentswidth">
									<a href="/">ホーム</a> &gt; <span><?php echo $archive_title; ?></span>
								</div>
							</nav>
              
							<header id="contentsheaderblock" class="contentsheader">
								<div class="contentswidth">aaa
									<?php if ( have_posts() ) : ?>
                  <h1 class="contentsheader-header"><?php echo $archive_title; ?></h1>
                  <?php else : ?>
                  <h1 class="contentsheader-header">検索結果なし</h1>
                  <?php endif; ?>
								</div>
							</header>

              <div class="contentsbody">
                <div class="contentswidth">
                 <?php get_search_form(); ?> 
                </div>
              </div>

							<div class="contentsbody seminar-list">
								<div class="contentswidth">
									
									
									<ul class="seminarlist">
										<?php
										$paged = (int) get_query_var('paged');
										$now = date_format(date_create(),"Y-m-d");
										if (is_page('seminar')) { //全地域の研修会情報一覧を表示している場合
											$args = array(
												'posts_per_page' => 9,
												'paged' => $paged,
												'meta_query' => array( //現時点より未来に開催予定の研修会のみに絞り込む
													array(
														'key'	=> 'wpcf-date',
														'value'	=> $now,
														'compare' => '>',
														'type' => 'DATE',
													)
												),
												'meta_key' => 'wpcf-date', //研修会の開催日をキーとして
												'orderby' => 'meta_value', //研修会の開催日でソートする
												'order' => 'ASC', //昇順
												'post_type' => 'post',
												'post_status' => 'publish'
											);
										} else { //地域で絞り込まれて表示している場合
											$cats = get_the_category();
											foreach ($cats as $cat) {
												$cat_slug = $cat->slug;
											}
											$args = array(
												'posts_per_page' => 9,
												'paged' => $paged,
												'meta_query' => array(
													array(
														'key'	=> 'wpcf-date',
														'value'	=> $now,
														'compare' => '>',
														'type' => 'DATE',
													)
												),
												'meta_key' => 'wpcf-date',
												'orderby' => 'meta_value',
												'order' => 'ASC',
												'post_type' => 'post',
												'tax_query' => array( //当該地域のみに絞り込む
													'relation' => 'AND', array(
														'taxonomy' => 'category',
														'field' => 'slug',
														'terms' => $cat_slug
													)
												),
												'post_status' => 'publish'
											);
										}
										$the_query = new WP_Query($args);
										if ( $the_query->have_posts() ) :
											while ( $the_query->have_posts() ) : $the_query->the_post();
										?>
										<li class="listitem">
											<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											<div class="listitem__excerpt"><?php echo post_custom("wpcf-lead"); ?></div>
											<table class="listitem__table datatable1">
												<tbody>
													<tr>
														<th>開催日</th>
														<td><?php echo date("Y年m月d日", strtotime(post_custom("wpcf-date"))); ?></td>
													</tr> 
													<tr>
														<th>開催地</th>
														<td><?php the_category(', '); ?></td>
													</tr>
												</tbody>
											</table>
											<div class="listitem__button button--brown"><a href="<?php the_permalink(); ?>" class="button">詳しく見る</a></div>
										</li>
										<?php endwhile; endif; ?>
									</ul>
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
										<?php wp_reset_postdata(); ?>
								</div>
							</div>
							
							<div class="contentsbody seminarbox">
								<div class="contentswidth">
									<p><span>研修会開催団体の方は、研修会情報を投稿できます。</span></p>
									<div class="seminarbox__allposts">
										<a href="/press" class="button button--white"><span>研修会情報を投稿する</span></a>
									</div>
								</div>
							</div>

							<?php require_once('common_2017/bannerblock.php'); ?>

<?php get_footer();
