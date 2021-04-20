<?php
/**
 * The template for displaying the 404 template in the Twenty Twenty theme.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>

<main id="site-content" role="main">

	<div class="section-inner thin error404-content">

		<h1 class="entry-title"><?php _e( 'Page Not Found', 'twentytwenty' ); ?></h1>

		<script type='text/javascript'>
            function SubmitForm() {
                let escrowbot_id = document.getElementById('escrowbot_id').value;

                //check val for length / valid IP here

                window.location.href='/' + escrowbot_id;
                return false;
            }
        </script>
        <form method="get" action="/" onsubmit="return SubmitForm()">
            <input type="text" placeholder="id" id="escrowbot_id" name="escrowbot_id" value="<?php echo($escrowbot_id); ?>">
            <input type="submit" value="INSPECCIONAR ID" style="width: 100%;">
        </form>


	</div><!-- .section-inner -->

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
