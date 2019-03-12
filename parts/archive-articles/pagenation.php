									<div class="home-column__schedule">
										<p>毎週水曜日更新<span>※第5水曜日の更新はおやすみです。</span></p>
									</div>
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
									<!-- pagenation -->
