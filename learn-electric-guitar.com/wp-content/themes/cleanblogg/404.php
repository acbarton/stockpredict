<?php get_header(); ?>
<div class="cb-content">
	<div class="container-fluid">
    	<div class="row">
            <div class="page-404 col-xs-12">
				<h1>404</h1>
				<p><?php _e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.',  'cleanblogg' ); ?></p>
            	<?php get_search_form(); ?>
			</div>
		</div>
	</div>
</div>	
<?php get_footer(); ?>