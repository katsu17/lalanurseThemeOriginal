<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
									<a href="/">ホーム</a> &gt; 採用情報詳細 &gt; <span><?php the_title(); ?></span>
								</div>
							</nav>

							<header id="contentsheaderblock" class="contentsheader">
								<div class="contentswidth">
									<div>
										<h1 class="contentsheader-header"><?php the_title(); ?></h1>
									</div>
									<p class="catch"><?php echo post_custom("wpcf-lead"); ?></p>
								</div>
							</header>

							<div class="contentsbody detail-content">
								<div class="contentswidth">
									<?php if (!empty(post_custom('wpcf-image'))) : ?>
									<p style="text-align: center;"><?php echo wp_get_attachment_image($attachment_id=post_custom('wpcf-image') , $size='large', $icon='false', $attr=''); ?></p>
									<?php endif; ?>
									<p><?php echo nl2br(post_custom("wpcf-content")); ?></p>
								</div>
							</div>

							<div class="contentsbody detail-data">
								<div class="contentswidth">
									<h2 class="contentsh1">採用情報詳細</h2>
									<table class="datatable1">
										<tbody>
											<tr>
												<th>名称（法人名、グループ名）</th>
												<td><?php echo the_title(); ?></td>
											</tr>

											<tr>
												<th>応募資格</th>
												<td><?php echo nl2br(post_custom("wpcf-requirement")); ?></td>
											</tr>
											<tr>
												<th>新卒可否</th>
												<td><?php echo nl2br(post_custom("wpcf-newgraduates")); ?></td>
											</tr>
											<tr>
												<th>募集人員</th>
												<td><?php echo post_custom("wpcf-job"); ?></td>
											</tr>
											<tr>
												<th>雇用形態</th>
												<td><?php echo nl2br(post_custom("wpcf-type")); ?></td>
											</tr>
											<tr>
												<th>勤務地</th>
												<td><?php echo nl2br(post_custom("wpcf-prace")); ?></td>
											</tr>
											<tr>
												<th>アクセス</th>
												<td><?php echo nl2br(post_custom("wpcf-access")); ?></td>
											</tr>
											<tr>
												<th>車通勤可否</th>
												<td><?php echo post_custom("wpcf-car"); ?></td>
											</tr>
											<tr>
												<th>給与等</th>
												<td><?php echo nl2br(post_custom("wpcf-guarantee")); ?></td>
											</tr>
											<tr>
												<th>諸手当</th>
												<td><?php echo nl2br(post_custom("wpcf-allowance")); ?></td>
											</tr>
											<tr>
												<th>休日・休暇</th>
												<td><?php echo nl2br(post_custom("wpcf-holiday")); ?></td>
											</tr>
											<tr>
												<th>福利厚生</th>
												<td><?php echo nl2br(post_custom("wpcf-welfare")); ?></td>
											</tr>
											<tr>
												<th>応募方法・応募期間</th>
												<td><?php echo nl2br(post_custom("wpcf-term")); ?></td>
											</tr>
											<tr>
												<th>採用サイトURL</th>
												<td><?php echo post_custom("wpcf-url"); ?></td>
											</tr>
											<tr>
												<th>その他</th>
												<td><?php echo nl2br(post_custom("wpcf-others")); ?></td>
											</tr>

										</tbody>                  
									</table>
									
									<?php require_once('common_2017/adsense1box.php'); ?>

								</div>
							</div>
							<?php endwhile; endif; ?>
							<?php wp_reset_postdata(); ?>
							
							<div class="contentsbody seminarbox">
								<div class="contentswidth">
									<h2>最新のセミナー・研修会</h2>
									<ul class="seminarlist">
										<?php
										$args = array(
											'posts_per_page' => 3,
											'post_type' => 'post',
											'orderby' => 'date',
											'order' => 'DESC',
											'post_status' => 'publish'
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
										<a href="/seminar" class="button button--white"><span>すべての研修会情報を見る</span></a>
									</div>
									
									<?php require_once('common_2017/adsense2box.php'); ?>
									<?php require_once('common_2017/fbpagebox.php'); ?>
									
								</div>
							</div>

<?php get_footer();
