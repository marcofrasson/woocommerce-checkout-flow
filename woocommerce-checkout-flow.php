<?php
/**
 * Plugin Name:          WooCommerce Checkout Flow
 * Plugin URI:           https://github.com/marcofrasson/woocommerce-checkout-flow
 * Description:          Plugin para WordPress e WooCommerce que ajuda na usabilidade de criação de contas dos usuários no checkout.
 * Author:               Flow Digital Creative Ecommerce
 * Author URI:           https://goflow.digital
 * Version:              1.0.1
 * License: 						 GPLv3
 * License URI: 				 http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:          wc-checkout-flow
 * Domain Path:          /languages
 * WC requires at least: 3.0.0
 * WC tested up to:      3.5.0
 *
 * WooCommerce Checkout Flow is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * WooCommerce Checkout Flow is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

if ( ! defined( 'WPINC' ) ) {
	die();
}

require_once 'vendor/autoload.php';
require_once 'includes/helpers.php';

FlowDigital\WC_Checkout_Flow\Core\Config::setup( __FILE__ );

require_once 'includes/boot.php';

FlowDigital\WC_Checkout_Flow\Core\Plugin::run();
