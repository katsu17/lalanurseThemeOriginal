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
  //if (have_posts()){
    //$archive_title = get_search_query()."の検索結果";
  //}else{
    //$archive_title ="検索結果なし";
  //}
?>
							<nav class="posmenu">
								<div class="contentswidth">
                  <a href="/">ホーム</a> &gt; <a href="/seminar/">セミナー・研修会情報</a> &gt; <span>検索結果</span>
								</div>
							</nav>
              
							<header id="contentsheaderblock" class="contentsheader">
								<div class="contentswidth">
									<?php //if ( have_posts() ) : ?>
                  <!--<h1 class="contentsheader-header"><?php echo $archive_title; ?></h1>-->
                  <?php //else : ?>
                  <h1 class="contentsheader-header">検索結果</h1>
                  <?php //endif; ?>
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
										if ( have_posts() ) :
										while ( have_posts() ) : the_post();
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
