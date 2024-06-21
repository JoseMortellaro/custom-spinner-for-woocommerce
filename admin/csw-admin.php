<?php
defined( 'CUSTOM_SPINNER_FOR_WOOCOMMERCE_PLUGIN_DIR' ) || exit; // Exit if accessed directly

add_filter( 'woocommerce_settings_tabs_array',function( $settings_tabs ){
  $settings_tabs['custom_spinner'] = esc_html__( 'Custom Spinner', 'custom-spinner-for-woocommerce' );
  return $settings_tabs;
},50 );

add_filter( 'woocommerce_get_sections_products',function( $sections ) {
	$sections['custom_spinner'] = esc_html__( 'Custom Spinner', 'custom-spinner-for-woocommerce' );
	return $sections;
} );

add_action( 'woocommerce_settings_tabs_custom_spinner',function() {
  $id = get_option( 'custom_spinner_gif' );
  if( $id && absint( $id ) > 0 ){
    $srcA = wp_get_attachment_image_src( $id );
    if( $srcA && is_array( $srcA ) && esc_url( $srcA[0] ) === $srcA[0] ){
      $src = $srcA[0];
    }
  }
  woocommerce_admin_fields( eos_custom_spinner_get_settings() );
  ?>
  <style id="csw-css">#custom_spinner_gif{display:none}</style>
  <p><button id="csw-upload" class="button"><?php esc_html_e( 'Upload Spinner','custom-spinner-for-woocommerce' ); ?></button></p>
  <div id="csw-preview-wrp"><img id="csw-preview" style="animation:spin 1.5s linear infinite;width:32px;height:32px" src="<?php echo esc_url( $src ); ?>" /></div>
  <?php
  wp_enqueue_media();
  wp_enqueue_script( 'custom-spinner-for-woocommerce',CUSTOM_SPINNER_FOR_WOOCOMMERCE_PLUGIN_URL.'/admin/assets/js/csw-admin.js', array( 'jquery' ) );
  wp_localize_script( 'custom-spinner-for-woocommerce','csw_params',array( 'upload' => esc_html__( 'Upload Image','custom-spinner-for-woocommerce' ),'use' => esc_html__( 'Use this image','custom-spinner-for-woocommerce' ) ) );
} );

function eos_custom_spinner_get_settings() {
    $settings = array(
        'section_title' => array(
            'name'     => esc_html__( 'Custom spinner for the checkout', 'custom-spinner-for-woocommerce' ),
            'type'     => 'title',
            'desc'     => '',
            'id'       => 'custom_spinner_section_title'
        ),
        'custom_text_text' => array(
            'name' => esc_html__( 'Spinner URL', 'custom-spinner-for-woocommerce' ),
            'type' => 'text',
            'desc' => '',
            'id'   => 'custom_spinner_gif'
        ),
        'section_end' => array(
             'type' => 'sectionend',
             'id' => 'wc_settings_tab_custom_spinner_section_end'
        )
    );
    return apply_filters( 'wc_settings_tab_eos_custom_spinner_get_settings', $settings );
}

add_action( 'woocommerce_update_options_custom_spinner',function() {
    woocommerce_update_options( eos_custom_spinner_get_settings() );
} );
