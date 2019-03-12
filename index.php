<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>


							<div class="contentsbody home-column">
								<div class="contentswidth">
									<ul class="columnlist">
										<?php
										/* 以下の条件で記事一覧を取得する */
										$args = array(
											'posts_per_page' => 9, //9件だけ取得する
											'post_type' => 'articles', //投稿タイプarticlesから取得する
											'orderby' => 'date', //日付順でソートする
											'order' => 'DESC', //降順でソートする
											'post_status' => 'publish' //公開済みのものを取得する
										);
										$the_query = new WP_Query($args);
										if ( $the_query->have_posts() ) :
											while ( $the_query->have_posts() ) : $the_query->the_post();
										?>
										<li class="listitem">
											<?php
											/* 記事のサムネイル画像を取得する */
											if ( has_post_thumbnail() ) { //記事がサムネイルを持っていれば
												$thumbnail_id = get_post_thumbnail_id();
												$eye_img = wp_get_attachment_image_src( $thumbnail_id , 'large' );
												$eye_img_src = $eye_img[0]; //変数に画像URLを格納する
											}
											else { //記事に画像がなければダミー
												$eye_img_src = "/common_2017/img/dummy.jpg";
											}
											?>
											<a href="<?php the_permalink(); ?>" style="background:url(<?php echo $eye_img_src; ?>) center; background-size:cover;">
											<div class="listitem__header">
												<div class="listitem__description">
													<div class="listitem__labels">
														<time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('Y.m.d'); ?></time>
														<?php
														/* 記事種別・地域・団体名・対象職種のラベルを表示する */
															$contents = get_the_terms($post->ID, 'contents'); //投稿が持っている「記事種別」のタームを取得し、ラベルを出力する
															foreach ($contents as $content) {
																echo '<span class="listitem__label catlabel-'. esc_html($content->taxonomy). '">' . esc_html($content->name) . '</span>';
																if ($content->term_id == 7) { //記事種別が「求人情報」だった場合は地域・団体名を追加出力する動作を行う
																	$prefs = get_the_terms($post->ID, 'pref');
																	foreach ($prefs as $pref) {
																		echo '<span class="listitem__label catlabel-'. esc_html($pref->taxonomy). '">' . esc_html($pref->name) . '</span>';
																	}
																	$companies = get_the_terms($post->ID, 'company');
																	foreach ($companies as $company) {
																		echo '<span class="listitem__label catlabel-'. esc_html($company->taxonomy). '">' . esc_html($company->name) . '</span>';
																	}
																}
															}
															$targets = get_the_terms($post->ID, 'target'); //投稿が持っている「対象職種」のタームを取得し、ラベルを出力する
															foreach ($targets as $target) {
																echo '<span class="listitem__label catlabel-'. esc_html($target->taxonomy). '">' . esc_html($target->name) . '</span>';
															}
														?>
													</div>
													<h3 class="listitem__title"><?php the_title(); ?></h3>
												</div>
											</div>
										</a></li>
										<?php endwhile; endif; ?>
										<?php wp_reset_postdata(); ?>
									</ul>
									<div class="home-column__schedule">
										<div class="listitem__button button--brown"><a href="articles" class="button">全ての記事を見る</a></div>

									</div>
									<?php // require_once('common_2017/adsense1box.php'); ?>
								</div>
							</div>

							<div class="contentsbody home-seminar seminarbox">
								<div class="contentswidth">
									<header>
										<h2><img src="img/seminarh2.png" width="377" alt="セミナー・研修会情報"/></h2>
										<p><span>キャリアアップに役立つ<br>セミナー情報を掲載しています。</span></p>
									</header>
									<ul class="seminarlist">
										<?php
										/* 以下の条件で研修会情報一覧を取得する */
										$args = array(
											'posts_per_page' => 3, //3件
											'post_type' => 'post', //投稿タイプが「一般投稿」
											'orderby' => 'date', //日付順でソート
											'order' => 'DESC', //降順
											'post_status' => 'publish' //公開済み
										);
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
										<?php wp_reset_postdata(); ?>
									</ul>
									<div class="seminarbox__allposts">
										<a href="seminar" class="button button--white"><span>すべての研修会情報を見る</span></a>
									</div>
								</div>
							</div>
							
							<?php require_once('common_2017/bannerblock.php'); ?>

<?php get_footer();
