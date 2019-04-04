<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use FlowDigital\WC_Checkout_Flow\functions as h;

$link_label = esc_html__( 'Clique aqui para redefinir sua senha', 'wc-checkout-flow' );
$link_label = \apply_filters( h\prefix( 'reset_password_link_label' ), $link_label );

?>

<?php do_action( 'before_wc_checkout_flow_email_reset_password_message', $username ); ?>

<?php
$message = get_option( 'wc_checkout_flow_reset_password' );
$message = str_replace( array( '[username]', '[shop_name]', '[reset_password_url]', '[reset_password_label]' ),
	array( esc_html( $username ), $shop_name, $reset_password_url, $link_label ), $message );

echo $message;
?>

<?php do_action( 'after_wc_checkout_flow_email_reset_password_message', $username ); ?>
