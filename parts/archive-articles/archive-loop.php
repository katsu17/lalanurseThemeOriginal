										<li class="listitem">
											<?php
											if ( has_post_thumbnail() ) {
												$thumbnail_id = get_post_thumbnail_id();
												$eye_img = wp_get_attachment_image_src( $thumbnail_id , 'large' );
												$eye_img_src = $eye_img[0];
											}
											else {
												$eye_img_src = "/common_2017/img/dummy.jpg";
											}
											?>
											<a href="<?php the_permalink(); ?>" style="background:url(<?php echo $eye_img_src; ?>) center; background-size:cover;">
											<div class="listitem__header">
												<div class="listitem__description">
													<div class="listitem__labels">
														<time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('Y.m.d'); ?></time>
														<?php
															$contents = get_the_terms($post->ID, 'contents');
															foreach ($contents as $content) {
																echo '<span class="listitem__label catlabel-'. esc_html($content->taxonomy). '">' . esc_html($content->name) . '</span>';
																if ($content->term_id == 7) { //求人情報なら
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
															$targets = get_the_terms($post->ID, 'target');
															foreach ($targets as $target) {
																echo '<span class="listitem__label catlabel-'. esc_html($target->taxonomy). '">' . esc_html($target->name) . '</span>';
															}
														?>
													</div>
													<h3 class="listitem__title"><?php the_title(); ?></h3>
												</div>
											</div>
										</a></li>