<?php
/**
* Returns word count of the sentences.
*
* @since @since Speedy 1.0.0
*/
if ( ! function_exists( 'speedy_words_count' ) ) :
	function speedy_words_count( $length = 25, $speedy_content = null ) {
		$length = absint( $length );
		$source_content = preg_replace( '`\[[^\]]*\]`', '', $speedy_content );
		$trimmed_content = wp_trim_words( $source_content, $length, '...' );
		return $trimmed_content;
	}
endif;