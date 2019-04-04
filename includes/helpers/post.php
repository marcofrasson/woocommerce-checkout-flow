<?php

namespace FlowDigital\WC_Checkout_Flow\functions;

function get_post( $id, $post_type = 'post' ) {
	$post = \get_post( \intval( $id ) );
	if ( $post && $post_type === $post->post_type ) {
		return $post;
	}

	return false;
}
