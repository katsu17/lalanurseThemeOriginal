									<div class="searchbox">
										<p>タグから選ぶ</p>
										<ul>
											<li class="head catlabel-contents">種類</li>
											<?php
												$contents = get_terms('contents');
												foreach ($contents as $content) {
													echo '<li><a href="/' . esc_html($content->taxonomy) . '/' . esc_html($content->slug) . '">' . esc_html($content->name) . '</a></li>';
												}
											?>
											<li class="head catlabel-pref">地域</li>
											<?php
												$prefs = get_terms('pref');
												foreach ($prefs as $pref) {
													echo '<li><a href="/' . esc_html($pref->taxonomy) . '/' . esc_html($pref->slug) . '">' . esc_html($pref->name) . '</a></li>';
												}
											?>
											<li class="head catlabel-company">団体</li>
											<?php
												$companies = get_terms('company');
												foreach ($companies as $company) {
													echo '<li><a href="/' . esc_html($company->taxonomy) . '/' . esc_html($company->slug) . '">' . esc_html($company->name) . '</a></li>';
												}
											?>
											<li class="head catlabel-target">職種</li>
											<?php
												$targets = get_terms('target');
												foreach ($targets as $target) {
													echo '<li><a href="/' . esc_html($target->taxonomy) . '/' . esc_html($target->slug) . '">' . esc_html($target->name) . '</a></li>';
												}
											?>
										</ul>
									</div>
									