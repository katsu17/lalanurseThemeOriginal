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
							/* 求人記事か、キャリアコラムかを判別する */
								$isRecruit = False; //これが求人記事であるかどうかを判別するBoolean型の変数にFalseを持たせて宣言しておく
								$terms = get_the_terms($post->ID, 'contents'); //この記事の「記事分別」を取得する
								foreach ($terms as $term) {
									if ($term->slug == 'feature') { //記事分別に「特集」が含まれる場合、ページ中にラベルを表示するための配列を保存する
										$feature = array("name" => $term->name,"slug" => $term->slug,"taxo" => $term->taxonomy);
									} else {
										$contents = array("name" => $term->name,"slug" => $term->slug,"taxo" => $term->taxonomy);
									}
								}
								$terms = get_the_terms($post->ID, 'target');
								if (!empty($terms)) {
									foreach ($terms as $term) {
										$target = array("name" => $term->name,"slug" => $term->slug,"taxo" => $term->taxonomy);
									}
								}
								/*
								 * 求人記事は、WP UserFrontendプラグインのフォームを使って入力するようにしている。
								 * 求人記事だった場合にはis-recruitというフォーム外の非表示メタキーが送られているので、それを使ってこの記事が求人記事がキャリアコラムかを判別する。
								 * is-recruitはbooleanではなくstringの「true」という文字列を保持しているので、
								 * 以下のif内では「それをstrpos関数で検索し、その戻り値がfalseでない」ことに基づいて動作している
								 */
								if (strpos(post_custom("is-recruit"), 'true') !== false){
									$isRecruit = True; //これが求人記事であることを後々判別するため、変数をTrueにする
									$terms = get_the_terms($post->ID, 'pref');
									foreach ($terms as $term) {
										$pref = array("name" => $term->name,"slug" => $term->slug,"taxo" => $term->taxonomy);
									}
									$terms = get_the_terms($post->ID, 'company');
									foreach ($terms as $term) {
										$company = array("name" => $term->name,"slug" => $term->slug,"taxo" => $term->taxonomy);
									}
								}elseif($post->ID==2480 or $post->ID==2400){
                  $terms = get_the_terms($post->ID, 'company');
									foreach ($terms as $term) {
										$company = array("name" => $term->name,"slug" => $term->slug,"taxo" => $term->taxonomy);
									}
                }
							?>
							<nav class="posmenu">
								<div class="contentswidth">
									<?php if($isRecruit): //trueであれば求人記事 ?>
									<a href="/">ホーム</a> &gt; <a href="/contents/recruit">求人情報</a> &gt; <h1><?php echo esc_html($company['name']).'の求人情報'; ?></h1>
									<?php else: //そうでなければキャリアコラム ?>
									<a href="/">ホーム</a> &gt; <a href="/contents/column">キャリアコラム</a> &gt; <h1><?php the_title(); ?></h1>
									<?php endif; ?>
								</div>
							</nav>

							<?php
							if ( has_post_thumbnail() ) { //アイキャッチ画像のURLを取得
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
											/* 記事のタイトルに「 - 」または「。」または「  」が含まれるとき、その前後で改行を入れる */
											if (preg_match("/\s–\s/", $title)) {
												$title = str_replace(" – ", "<br> – ", $title);
											} elseif (strpos($title, "。") !== false) {
												$title = str_replace("。", "。<br>", $title);
											} elseif (strpos($title, "  ") !== false) {
												$title = str_replace("  ", "<br>", $title);
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
										<?php if ($feature != null): //特集記事の場合、ラベルを表示する ?>
										<a href="<?php echo esc_html($feature['taxo'] . '/' . esc_html($feature['slug'])) ?>"><span class="listitem__label catlabel-<?php echo esc_html($feature['taxo']) ?>"><?php echo esc_html($feature['name']) ?></span></a>
										<?php endif; ?>
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
                      <a class="line btn" href="http://line.me/R/msg/text/?<?php the_permalink();?>"><img src="/common_2017/img/sns-line.png" class="line-button" data-hatena-bookmark-layout="simple" alt="LINEで送る"></a>
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
                    <a class="line btn" href="http://line.me/R/msg/text/?<?php the_permalink();?>"><img src="/common_2017/img/sns-line.png" class="line-button" data-hatena-bookmark-layout="simple" alt="LINEで送る"></a>
									</div>
								</div>
								
								<?php require_once('common_2017/adsense1box.php'); ?>
								
							</div>
							
							<?php if($isRecruit): //求人記事の場合、求人概要欄を出力する ?>
							<?php get_post($post->ID); ?>
							<div class="contentsbody detail-recruit">
								<div class="contentswidth">
									<h2 class="contentsh1">求人概要</h2>
									<h3 class="contentsh2"><?php echo esc_html($company['name']) ?></h3>
									<div class="detail-recruit__data">
										<table class="datatable2">
											<tbody>
												<?php
												/*
												 * 求人概要のカスタムフィールドは、
												 * 項目名「recruit-item1th」
												 * 項目内容「recruit-item1td」
												 * 1th、1tdがそれぞれ連番になったメタキーになっているので、for文で繰り上げながら出力していく
												 */
													for ($i = 1; $i < 10; $i++) {
														$customfield_th = "recruit-item".$i."th";
														$customfield_td = "recruit-item".$i."td";
														if(post_custom($customfield_th)) {
															$text_th = (post_custom($customfield_th));
															$text_td = (post_custom($customfield_td));
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
							
							<?php if ($company['name'] == '株式会社gene' or $company['name'] == '看護医療ゼミ'): //株式会社geneの記事のみ、特例的にセミナーを表示する ?>
							<div class="contentsbody seminarbox">
								<div class="contentswidth">
									<h2>直近で開催予定の<?php echo $company['name'];?>主催セミナー</h2>
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
													'value' => $company['name'],
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
										<div class="line-it-button" data-lang="ja" data-type="share-a" data-url="<?php echo esc_html($current_url); ?>" style="display: none;"></div>
										<script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
										<?php else: ?>
										<p class="detail-share__text">この記事が気に入ったら<br>
										いいね！しよう</p>
										<div class="fb-like" data-href="https://www.facebook.com/lalanurse.net" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="false"></div>
										<p class="detail-share__text">最新情報をお届けします</p>
										<?php endif; ?>
										<!--<div class="detail-share__button"><a href="#" class="button button--line">LINEで共有</a></div>-->
										<p class="detail-share__renew">LALANURSEは水曜日更新です。</p>
									</div>
								</div>
								
								<?php require_once('common_2017/fbpagebox.php'); ?>
								<?php require_once('common_2017/adsense2box.php'); ?>

							</div>

							<?php endwhile; endif; ?>
							<?php wp_reset_postdata(); ?>

<?php get_footer();
