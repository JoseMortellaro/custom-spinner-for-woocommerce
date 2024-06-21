<?php
/*
Plugin Name: Custom Spinner For WooCommerce
Description: Load your custom spinner for the WooCommerce checkout and cart pages
Author: Jose Mortellaro
Author URI: https://josemortellaro.com/
Domain Path: /languages/
Text Domain: custom-spinner-for-woocommerce
Version: 0.0.2
Requires Plugins: woocommerce
*/
/*  This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/
defined( 'ABSPATH' ) || exit; // Exit if accessed directly

//Definitions
define( 'CUSTOM_SPINNER_FOR_WOOCOMMERCE_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'CUSTOM_SPINNER_FOR_WOOCOMMERCE_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );

if( is_admin() ){
  if( isset( $_GET['page'] ) && 'wc-settings' === sanitize_text_field( $_GET['page'] ) ){
    require_once CUSTOM_SPINNER_FOR_WOOCOMMERCE_PLUGIN_DIR.'/admin/csw-admin.php';
  }
  	//It adds a settings link to the action links in the plugins page
	add_filter( 'plugin_action_links_'.untrailingslashit( plugin_basename( __FILE__ ) ) , function( $links ){
   	 	array_push( $links,'<a class="csfw-link" href="'.admin_url( 'admin.php?page=wc-settings&tab=custom_spinner' ).'">' . __( 'Settings' ). '</a>' );
  		return $links;
	} );
}
else{
  add_action( 'wp_head',function(){
    if( ( function_exists( 'is_checkout' ) && is_checkout() ) || ( function_exists( 'is_cart' ) && is_cart() ) ){
      $id = get_option( 'custom_spinner_gif' );
      if( $id && absint( $id ) > 0 ){
        $srcA = wp_get_attachment_image_src( $id );
        if( $srcA && is_array( $srcA ) && esc_url( $srcA[0] ) === $srcA[0] ){
          $src = $srcA[0];
          ?>
		  <style id="csfw-css">
		  .woocommerce .blockUI.blockOverlay:before,.woocommerce .loader:before{
			position: absolute;
			content:" ";
			background-image: url("<?php echo esc_url( $src ); ?>") !important;
			background-size:cover !important;
			background-position: center !important;
			background-repeat:no-repeat !important;
			top: 50%;
			left: 50%;
			margin-left: -16px;
			margin-top: -16px;
			width: 32px;
			height: 32px;
			animation: spin 1.5s linear infinite;
		  }
		  </style>
		  <?php
        }
      }
    }
  } );
}
