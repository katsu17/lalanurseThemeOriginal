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
							
							<?php
								$isRecruit = False;
								$terms = get_the_terms($post->ID, 'contents');
								foreach ($terms as $term) {
									$contents = array("name" => $term->name,"slug" => $term->slug,"taxo" => $term->taxonomy);
								}
								$terms = get_the_terms($post->ID, 'target');
								if (!empty($terms)) {
									foreach ($terms as $term) {
										$target = array("name" => $term->name,"slug" => $term->slug,"taxo" => $term->taxonomy);
									}
								}
								if (strpos(post_custom("is-recruit"), 'true') !== false){
									$isRecruit = True;
									$terms = get_the_terms($post->ID, 'pref');
									foreach ($terms as $term) {
										$pref = array("name" => $term->name,"slug" => $term->slug,"taxo" => $term->taxonomy);
									}
									$terms = get_the_terms($post->ID, 'company');
									foreach ($terms as $term) {
										$company = array("name" => $term->name,"slug" => $term->slug,"taxo" => $term->taxonomy);
									}
								}
							?>
							<nav class="posmenu">
								<div class="contentswidth">
									<?php if($isRecruit): ?>
									<a href="/">ホーム</a> &gt; <a href="/contents/recruit">求人情報</a> &gt; <h1><?php echo esc_html($company['name']).'の求人情報'; ?></h1>
									<?php else: ?>
									<a href="/">ホーム</a> &gt; <a href="/contents/column">キャリアコラム</a> &gt; <h1><?php the_title(); ?></h1>
									<?php endif; ?>
									<!-- recruit-test -->
								</div>
							</nav>
							<style type="text/css">
								.articles .contentsheader{
									padding: 0;
									z-index: 0;
									overflow: hidden;
								}
								.articles .contentsheader::before {
									content: '';
									background: inherit;/*.bgImageで設定した背景画像を継承する*/
									-webkit-filter: blur(5px);
									-moz-filter: blur(5px);
									-o-filter: blur(5px);
									-ms-filter: blur(5px);
									filter: blur(5px);
									position: absolute;
									/*ブラー効果で画像の端がボヤけた分だけ位置を調整*/
									top: -5px;
									left: -5px;
									right: -5px;
									bottom: -5px;
									z-index: -1;/*重なり順序を一番下にしておく*/
								}
								.articles .contentsheader::after{
									content: '';
									display: block;
									background: linear-gradient(to bottom, transparent 0, rgba(0,0,0,0.5) 100%);
									height: 50%;
									position: absolute;
									margin: auto;
									left: 0;
									right: 0;
									bottom: 0;
								}
								.articles.detail .contentsheader .contentswidth {
									position: relative;
									height: 100%;
								}
								.contentsheader-title {
									position: absolute;
									bottom: 0;
									left: 0;
									right: 0;
									margin: auto;
									height: 50%;
								}
								.articles.detail .contentsheader-header {
									z-index: 100;
									position: absolute;
									margin: auto;
									top: 0;
									left: 0;
									right: 0;
									bottom: 0;
									height: 200px;
									text-align: center;
								}
							</style>

							<?php
							if ( has_post_thumbnail() ) {
								$thumbnail_id = get_post_thumbnail_id();
								$eye_img = wp_get_attachment_image_src( $thumbnail_id , 'full' );
								$eye_img_src = $eye_img[0];
							}
							else {
								$eye_img_src = "/common_2017/img/dummy.jpg";
							}
							?>
							<header id="contentsheaderblock" class="contentsheader" style="background:url('<?php echo esc_html("$eye_img_src") ?>') center center no-repeat; background-size: cover;">
								<div class="contentswidth" style="background:url('<?php echo esc_html("$eye_img_src") ?>') center center no-repeat; background-size: cover;">
									<div class="contentsheader-title">
										<p class="contentsheader-header">
										<?php
											$title = get_the_title($ID->post);
											if (preg_match("/\s–\s/", $title)) {
												$title = str_replace(" – ", "<br> – ", $title);
											} elseif (strpos($title, "。") !== false) {
												$title = str_replace("。", "。<br>", $title);
											}
											echo $title;
										?>
											<?php if($isRecruit) {echo '<span>'.esc_html($company['name']).'</span>';} ?>
											<span><?php echo get_the_date('Y.m.d'); ?></span>
										</p>
									</div>
								</div>
							</header>
							<div class="contentsbody detail-label">
								<div class="contentswidth">
									<div class="detail-label__category">
										<a href="<?php echo esc_html($contents['taxo'] . '/' . esc_html($contents['slug'])) ?>"><span class="listitem__label catlabel-<?php echo esc_html($contents['taxo']) ?>"><?php echo esc_html($contents['name']) ?></span></a>
										<a href="<?php echo esc_html($target['taxo'] . '/' . esc_html($target['slug'])) ?>"><span class="listitem__label catlabel-<?php echo esc_html($target['taxo']) ?>"><?php echo esc_html($target['name']) ?></span></a>
										<?php if($isRecruit): ?>
											<a href="<?php echo esc_html($pref['taxo'] . '/' . esc_html($pref['slug'])) ?>"><span class="listitem__label catlabel-<?php echo esc_html($pref['taxo']) ?>"><?php echo esc_html($pref['name']) ?></span></a>
											<a href="<?php echo esc_html($company['taxo'] . '/' . esc_html($company['slug'])) ?>"><span class="listitem__label catlabel-<?php echo esc_html($company['taxo']) ?>"><?php echo esc_html($company['name']) ?></span></a>
										<?php endif; ?>
									</div>
									<div class="detail-label__sns">
										<div class="snsbox">
											<a href="https://www.facebook.com/share.php?u=<?php echo get_the_permalink(); ?>" target="_blank" onclick="window.open(this.href, 'FBwindow', 'width=650, height=450, menubar=no, toolbar=no, scrollbars=yes'); return false;" ><img src="/common_2017/img/sns-facebook.png" alt="Facebook共有ボタン"></a>
											<a href="http://twitter.com/share?url=<?php echo get_the_permalink(); ?>" target="_blank"><img src="/common_2017/img/sns-twitter.png" alt="Twitter共有ボタン"></a>
											<a href="http://b.hatena.ne.jp/entry/<?php echo get_the_permalink(); ?>" target="_blank"><img src="/common_2017/img/sns-hatena.png" class="hatena-bookmark-button" data-hatena-bookmark-layout="simple" alt="はてなブックマーク共有ボタン"></a>
										</div>
									</div>
								</div>
							</div>

							<div class="contentsbody detail-content">
								<div class="contentswidth">
									<?php echo get_post_field('post_content',$post->ID) ?>
									<div class="snsbox">
										<a href="https://www.facebook.com/share.php?u=<?php echo get_the_permalink(); ?>" target="_blank" onclick="window.open(this.href, 'FBwindow', 'width=650, height=450, menubar=no, toolbar=no, scrollbars=yes'); return false;" ><img src="/common_2017/img/sns-facebook.png" alt="Facebook共有ボタン"></a>
										<a href="http://twitter.com/share?url=<?php echo get_the_permalink(); ?>" target="_blank"><img src="/common_2017/img/sns-twitter.png" alt="Twitter共有ボタン"></a>
										<a href="http://b.hatena.ne.jp/entry/<?php echo get_the_permalink(); ?>" target="_blank"><img src="/common_2017/img/sns-hatena.png" class="hatena-bookmark-button" data-hatena-bookmark-layout="simple" alt="はてなブックマーク共有ボタン"></a>
									</div>
								</div>
								
								<?php require_once('common_2017/adsense1box.php'); ?>
								
							</div>
							
							<?php if($isRecruit): ?>
							<?php get_post($post->ID); ?>
							<div class="contentsbody detail-recruit">
								<div class="contentswidth">
									<h2 class="contentsh1">求人概要</h2>
									<h3 class="contentsh2"><?php echo esc_html($company['name']) ?></h3>
									<div class="detail-recruit__data">
										<table class="datatable2">
											<tbody>
												<?php
													$pattern = '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/u';
													$replacement = '<a href="\1" target="_blank">\1</a>';
													for ($i = 1; $i < 10; $i++) {
														$customfield_th = "recruit-item".$i."th";
														$customfield_td = "recruit-item".$i."td";
														if(post_custom($customfield_th)) {
															$text_th = (post_custom($customfield_th));
															$text_td = (post_custom($customfield_td));
															/*
															if(preg_match($pattern,post_custom($customfield_td))){
																/* テキスト中にhttpを含む場合、リンクテキストに変換する 
																$text_td = preg_replace($pattern,$replacement,post_custom($customfield_td));
																/* テキスト中にメールアドレスを含む場合の変換処理だが、機能しない
																if(preg_match($pattern_mail,$text_td)){
																	$pattern_mail = '|^[0-9a-z_./?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$|u';
																	$replacement_mail = '<a href="mailto:\1">\1</a>';
																	$text_td = preg_replace($pattern_mail,$replacement_mail,$text_td);
																}
															} else {
																$text_td = (post_custom($customfield_td));
															}*/
												?>
												<tr>
													<th><?php echo $text_th; ?></th>
													<td><?php echo nl2br($text_td); ?></td>
												</tr>
												<?php
														}
													}
												?>
											</tbody>
										</table>
									</div>
									<div class="detail-recruit__contactbtn button--brown"><a href="<?php echo post_custom("recruit-url"); ?>" class="button"
									<?php if(post_custom('recruit-urltype') == 'form'): ?>
									>この求人に問い合わせる
									<?php else: ?>
									 target="_blank" onClick="ga('send','event',this.href,location.href,'label');">採用サイトを見る
									<?php endif; ?>
									</a></div>
								</div>
							</div>
							<?php endif; ?>
							
							<?php if ($company['name'] == '株式会社gene'): //株式会社geneのみ、セミナーを表示する ?>
							<div class="contentsbody seminarbox">
								<div class="contentswidth">
									<h2>直近で開催予定の株式会社gene主催セミナー</h2>
									<ul class="seminarlist">
										<?php
										$paged = (int) get_query_var('paged');
										$now = date_format(date_create(),"Y-m-d");
										$args = array(
											'posts_per_page' => 6,
											'paged' => $paged,
											'meta_query' => array(
												array(
													'key'	=> 'wpcf-date',
													'value'	=> $now,
													'compare' => '>',
													'type' => 'DATE',
												),
												array(
													'key'	=> 'wpcf-owner',
													'value' => '株式会社gene',
													'compare' => '='
												),
												'relation' => 'AND'
											),
											'meta_key' => 'wpcf-date',
											'orderby' => 'meta_value',
											'order' => 'ASC',
											'post_type' => 'post',
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
								</div>
							</div>
							<?php endif; //geneセミナー表示終わり ?>


							<div class="contentsbody detail-share">
								<div class="contentswidth">
									<div class="sharebox sharebox<?php if(is_mobile()): ?>-line<?php else: ?>-fb<?php endif; ?>">
										<div class="detail-share__image"><img src="<?php echo esc_html("$eye_img_src") ?>" width="470" alt="<?php echo get_the_title($ID->post) ?>のアイキャッチ"></div>
										<?php if(is_mobile()): ?>
										<p class="detail-share__text">この記事が気に入ったら、<br>
										あなたの周りにいる看護師のご友人・<br>
										ご家族にもぜひ教えてあげてください。</p>
										<div class="line-it-button" data-lang="ja" data-type="share-a" data-url="http://lalanurse.net" style="display: none;"></div>
										<script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
										<?php else: ?>
										<p class="detail-share__text">この記事が気に入ったら<br>
										いいね！しよう</p>
										<div class="fb-like" data-href="https://www.facebook.com/lalanurse.net" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="false"></div>
										<p class="detail-share__text">最新情報をお届けします</p>
										<?php endif; ?>
										<!--<div class="detail-share__button"><a href="#" class="button button--line">LINEで共有</a></div>-->
										<p class="detail-share__renew">LALANURSEは毎週水曜日更新です。</p>
									</div>
								</div>
								
								<?php require_once('common_2017/fbpagebox.php'); ?>
								<?php require_once('common_2017/adsense2box.php'); ?>

							</div>

							<?php endwhile; endif; ?>
							<?php wp_reset_postdata(); ?>

<?php get_footer();
