<?php 
    $meta = get_post_meta( $post->ID );
    $link_text = get_post_meta( $post->ID, 'dn_slider_link_text', true );
    $link_url = get_post_meta( $post->ID, 'dn_slider_link_url', true );
    //var_dump( $link_text, $link_url );
?>

<!-- codigo html para criação dos dados da metabox-->
<table class="form-table dn-slider-metabox"> 
    <!-- melhorando a segurança com a função nonce -->
<input type="hidden" name="dn_slider_nonce" value="<?php echo wp_create_nonce( "dn_slider_nonce" ); ?>">
    <tr>
      
        <th>
            <label for="dn_slider_link_text"><?php esc_html_e('Link Text', 'dn-slider'); ?></label>
        </th>
        <td>
            <input 
                type="text" 
                name="dn_slider_link_text" 
                id="dn_slider_link_text" 
                class="regular-text link-text"
                value="<?php echo ( isset( $link_text ) ) ? esc_html( $link_text ) : ''; ?>"
                required
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="dn_slider_link_url"><?php esc_html_e('Link URL', 'dn-slider')?></label>
        </th>
        <td>
            <input 
                type="url" 
                name="dn_slider_link_url" 
                id="dn_slider_link_url" 
                class="regular-text link-url"
                value="<?php echo ( isset( $link_url ) ) ? esc_url( $link_url ) : ''; ?>"
                required
            >
        </td>
    </tr>               
</table>