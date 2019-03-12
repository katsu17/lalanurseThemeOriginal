<?php
/*
Template Name: 検索テスト
*/
get_header(); ?>
<?php

		$the_cat_name = ''; //現在のカテゴリー名を取得しない
		$archive_title = 'セミナー・研修会情報';
?>
							<nav class="posmenu">
								<div class="contentswidth">
									<a href="/">ホーム</a> &gt; <span><?php echo $archive_title; ?></span>
								</div>
							</nav>
              
							<header id="contentsheaderblock" class="contentsheader">
								<div class="contentswidth">
									<h1 class="contentsheader-header"><?php echo $archive_title; ?></h1>
								</div>
							</header>

              <div class="contentsbody">
                <div class="contentswidth">
                 <?php get_search_form(); ?> 
                </div>
              </div>

							<div class="contentsbody seminar-list">
								<div class="contentswidth">
									<div class="searchbox">
										<p>絞り込み</p>
										<ul>
											<li class="head catlabel-pref">地域</li>
											<?php
												/* 地域を絞り込むためのリストを表示する */
												$args = array( //現在投稿されている研修会情報を全て取得する
													'type'                     => 'post',
													'child_of'                 => 0,
													'parent'                   => '',
													'orderby'                  => 'id',
													'order'                    => 'ASC',
													'hide_empty'               => 1,
													'hierarchical'             => 1,
													'exclude'                  => '',
													'include'                  => '',
													'number'                   => '',
													'taxonomy'                 => 'category',
													'pad_counts'               => false 
												);
												$categories = get_categories( $args ); //現在投稿されている研修会情報が紐付いている全てのカテゴリー（地域）を取得する
												$now = date_format(date_create(),"Y-m-d"); //現在の日時を変数で用意しておく
												foreach ($categories as $category) {
													//絞り込みリストにカテゴリを出力していく
													$cat_slug = $category->slug; //リンク用のスラッグを取得
													$cat_name = $category->name; //表示用の名前を取得
													$args = array(
														'post_type' => 'post',
														'post_status' => 'publish',
														'tax_query' => array(
															'relation' => 'AND', array(
																'taxonomy' => 'category',
																'field' => 'slug',
																'terms' => $cat_slug
															)
														),
														'meta_query' => array( //現在の日時より未来にセミナーの開催予定がある研修会情報を持つカテゴリー（地域）だけを表示の対象にする
															array(
																'key'	=> 'wpcf-date', //セミナー開催日をメタキーから取得し、キーとする
																'value'	=> $now, //現在の日時を値とする
																'compare' => '>', //キーと値を比較し、キーが現在の日時より大きい（未来）のものだけを対象にする
																'type' => 'DATE' //キーと値をDATE型として比較する
															)
														)
													);
													$the_query = new WP_Query($args); //この時点で、未来の研修会情報が1件もない地域はhave_postsがemptyになっている
													if (!empty($the_query->have_posts())) { //情報を1件でも持っている地域だったら
														if ($cat_name != $the_cat_name) { //カテゴリー一覧で表示している場合、現在のカテゴリー名と一致しないときだけ出力する
															echo '<li><a href="' . esc_html($cat_slug) . '">' . esc_html($cat_name) . '</a></li>';
														}
													}
													wp_reset_postdata();
												}
											?>
										</ul>
									</div>
									
									<?php require_once('common_2017/adsense1box.php'); ?>
									
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
