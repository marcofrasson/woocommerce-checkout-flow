<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<?php do_action( 'before_wc_checkout_flow_email_new_user_message', $username ); ?>

<?php
$message = get_option( 'wc_checkout_flow_new_account' );
$message = str_replace( array( '[username]', '[shop_name]', '[my_account_page_url]', '[password]' ),
	array( esc_html( $username ), $shop_name, $my_account_page_url, $password ), $message );

echo $message;
?>

<?php do_action( 'after_wc_checkout_flow_email_new_user_message', $username ); ?>
