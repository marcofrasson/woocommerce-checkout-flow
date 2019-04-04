<?php

namespace FlowDigital\WC_Checkout_Flow\Utils;

use FlowDigital\WC_Checkout_Flow\functions as h;

class User {

	/**
	 * @return \WP_User object on success, \WP_Error on failure.
	 */
	public static function register( $email, $login_on_success = true ) {
		if ( \is_email( $email ) ) {
			$username        = self::get_username_by_email( $email );
			$username_exists = \username_exists( $username );
			$count           = 2;
			$user            = null;

			while ( $username_exists ) {
				if ( ! \username_exists( $username + $count ) ) {
					$username = $username + $count;
					break;
				}
				$count += 1;
			}

			$password = self::generate_password();

			$result = wp_create_user(
				$username,
				$password,
				$email
			);

			if ( ! \is_wp_error( $result ) ) {
				$user_id = $result;

				wp_update_user( [
					'ID'   => $user_id,
					'role' => 'customer'
				] );

				if ( $login_on_success ) {
					$result = self::login( $email, $password );
				} else {
					$result = get_user_by( 'id', $user_id );
				}

				self::send_email_new_user( $username, $password, $email );
			}

			return $result;
		}

		return new \WP_Error( 'invalid_email', __( 'E-mail inválido.' ) );
	}

	public static function login( $email, $password ) {
		$creds = array(
			'user_login'    => $email,
			'user_password' => $password,
			'remember'      => true
		);

		$user = \wp_signon( $creds, \is_ssl() );

		return $user;
	}

	public static function change_password( $email, $password ) {
		$user = get_user_by( 'email', $email );

		if ( $user ) {
			$user_id = $user->ID;
			wp_set_password( $password, $user_id );

			return true;
		}

		return false;
	}

	public static function email_exists( $email ) {
		return \email_exists( $email );
	}

	public static function generate_password( $size = 12 ) {
		$size = \apply_filters( h\prefix( 'password_length' ), $size );

		return \wp_generate_password( $size, false, false );
	}

	public static function send_email_new_user( $username, $password, $email ) {
		$shop_name = get_bloginfo( 'name' );
		$title     = esc_html__( 'Seja bem-vindo', 'wc-checkout-flow' );
		$subject   = sprintf( esc_html__( 'Sua conta em %1$s foi criada', 'wc-checkout-flow' ), esc_html( $shop_name ) );
		$message   = wc_get_template_html(
			'pre-checkout/email-new-user.php',
			[
				'username'            => $username,
				'password'            => $password,
				'shop_name'           => $shop_name,
				'my_account_page_url' => get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ),
			],
			'',
			h\config_get( 'WC_TEMPLATE_PATH' )
		);

		WC()->mailer()->send(
			$email,
			$subject,
			WC()->mailer()->wrap_message( $title, $message )
		);
	}

	public static function send_email_reset_password( $email ) {
		$shop_name    = get_bloginfo( 'name' );
		$user         = \get_user_by( 'email', $email );
		$title        = esc_html__( 'Pedido de redefinição de senha', 'wc-checkout-flow' );
		$subject      = sprintf( esc_html__( 'Pedido de redefinição de senha em %1$s', 'wc-checkout-flow' ), esc_html( $shop_name ) );
		$hash         = self::create_email_hash( $email );
		$checkout_url = get_permalink( get_option( 'woocommerce_checkout_page_id' ) );

		$message = wc_get_template_html(
			'pre-checkout/email-reset-password.php',
			[
				'username'           => $user->user_login,
				'shop_name'          => $shop_name,
				'reset_password_url' => add_query_arg( h\prefix( 'hash' ), $hash, $checkout_url ),
			],
			'',
			h\config_get( 'WC_TEMPLATE_PATH' )
		);

		WC()->mailer()->send(
			$email,
			$subject,
			WC()->mailer()->wrap_message( $title, $message )
		);
	}

	public static function validate_email_hash( $hash ) {
		$email = \get_transient( h\prefix( "email_hash_$hash" ) );

		if ( \is_email( $email ) ) {
			return $email;
		}

		return false;
	}

	public static function delete_email_hash( $hash ) {
		\delete_transient( h\prefix( "email_hash_$hash" ) );
	}

	protected static function create_email_hash( $email ) {
		$time   = \time();
		$hash   = \hash( 'sha1', "$email:$time", false );
		$expire = 24 * \HOUR_IN_SECONDS;

		\set_transient( h\prefix( "email_hash_$hash" ), $email, $expire );

		return $hash;
	}

	protected static function get_username_by_email( $email ) {
		$parts = explode( '@', $email );

		return $parts[0];
	}
}
