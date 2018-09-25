	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="theme-input">
		<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'madar-lite'); ?>" />
		<input type="submit" class="submit button default" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'madar-lite'); ?>" />
	</form>