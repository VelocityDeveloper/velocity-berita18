<?php
if (is_active_sidebar('main-sidebar')) {
	echo '<div class="main-seidebar">';
		dynamic_sidebar( 'main-sidebar' );
	echo '</div>';
}