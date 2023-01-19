
<!-- codigo html para criação do menu opção-->

<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

    <?php 
        $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'main_options';
    ?>
    <!-- codigo html para criação da aba de meu de opção-->
    <h2 class="nav-tab-wrapper">
        <a href="?page=dn_slider_admin&tab=main_options" class="nav-tab <?php echo $active_tab == 'main_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Main Options', 'dn-slider')?></a>
        <a href="?page=dn_slider_admin&tab=additional_options" class="nav-tab <?php echo $active_tab == 'additional_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Additional Options', 'dn-slider')?></a>
    </h2>
    <form action="options.php" method="post">
    <!--funções que irãom salva na db -->
        <?php 
        if( $active_tab == 'main_options' ){
            // funções que irãom salva na db 
            settings_fields( 'dn_slider_group' );

             // funções que cria as seção na pagina
            do_settings_sections( 'dn_slider_page1' );
        }else{
            // funções que irãom salva na db 
            settings_fields( 'dn_slider_group' );
            do_settings_sections( 'dn_slider_page2' );
        }
            // funções que cria o botão na pagina
            submit_button( esc_html__('Save Settings', 'dn-slider') );
        ?>
    </form>
</div>