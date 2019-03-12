<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>
						</article>
					</div>

				<?php require_once('common_2017/footerblock.php'); ?>
				</div>
			</div>
		</div>
		<?php require_once('common_2017/script.php'); ?>
<?php if(is_page()):?>
	<script src="/common_2017/js/titletofield.js"></script>
<?php endif; ?>
		<?php wp_footer(); ?>
	</body>
</html>