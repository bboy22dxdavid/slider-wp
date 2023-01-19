<?php 

if( ! class_exists( 'DN_Slider_Settings' )){
    class DN_Slider_Settings{

        public static $options;

        public function __construct(){
            self::$options = get_option( 'dn_slider_options' );
            add_action( 'admin_init', array( $this, 'admin_init') );
        }

        //criando os campos das opções que não serãi salvas na db, apenas de inf 
        public function admin_init(){
            //registrando na bd
            register_setting( 'dn_slider_group', 'dn_slider_options', array( $this, 'dn_slider_validate' )  );

            add_settings_section(
                'dn_slider_main_section',
                esc_html__('How does it work?', 'dn-slider'),
                null,
                'dn_slider_page1'
            );

            //criando os campos das opções que  serão salvas na db
           
            add_settings_section(
                'dn_slider_second_section',
                esc_html__('Other Plugin Options', 'dn-slider'),
                null,
                'dn_slider_page2'
            );

            add_settings_field(
                'dn_slider_shortcode',
                esc_html__('Shortcode', 'dn-slider'),
                array( $this, 'dn_slider_shortcode_callback' ),
                'dn_slider_page1',
                'dn_slider_main_section'
            );

            add_settings_field(
                'dn_slider_title',
                esc_html__('Slider Title', 'dn-slider'),
                array( $this, 'dn_slider_title_callback' ),
                'dn_slider_page2',
                'dn_slider_second_section',
                array(
                    'label_for' => 'dn_slider_title'
                )
            );

            add_settings_field(
                'dn_slider_bullets',
                esc_html__('Display Bullets', 'dn-slider'),
                array( $this, 'dn_slider_bullets_callback' ),
                'dn_slider_page2',
                'dn_slider_second_section',
                array(
                    'label_for' => 'dn_slider_bullets'
                )
            );

            add_settings_field(
                'dn_slider_style',
                esc_html__('Slider Style', 'dn-slider'),
                array( $this, 'dn_slider_style_callback' ),
                'dn_slider_page2',
                'dn_slider_second_section',
                array(
                    'items' => array(
                        'style-1',
                        'style-2'
                    ),
                    'label_for' => 'dn_slider_style'
                )
            );
        }

        public function dn_slider_shortcode_callback(){
            ?>
            <span><?php esc_html_e('Use the shortcode [dn_slider] to display the slider in any page/post/widget', 'dn-slider', ) ?></span>
            <?php
        }

        public function dn_slider_title_callback($args){
            ?>
                <input 
                type="text" 
                name="dn_slider_options[dn_slider_title]" 
                id="dn_slider_title"
                value="<?php echo isset( self::$options['dn_slider_title'] ) ? esc_attr( self::$options['dn_slider_title'] ) : ''; ?>"
                >
            <?php
        }

        //função que ira adicionar ou não  bullets ou pontos no slide 
        public function dn_slider_bullets_callback($args){
            ?>
                <input 
                    type="checkbox"
                    name="dn_slider_options[dn_slider_bullets]"
                    id="dn_slider_bullets"
                    value="1"
                    <?php 
                        if( isset( self::$options['dn_slider_bullets'] ) ){
                            checked( "1", self::$options['dn_slider_bullets'], true );
                        }    
                    ?>
                />
                <label for="dn_slider_bullets"><?php esc_html_e('Whether to display bullets or not', 'dn-slider') ?></label>
                
            <?php
        }


         //função que salva os campos, no banco
        public function dn_slider_style_callback( $args ){
            ?>
            <select 
                id="dn_slider_style" 
                name="dn_slider_options[dn_slider_style]">
                <?php 

                //percorendo o arry 
                foreach( $args['items'] as $item ):
                ?>
                    <option value="<?php echo esc_attr( $item ); ?>" 
                        <?php 
                        isset( self::$options['dn_slider_style'] ) ? selected( $item, self::$options['dn_slider_style'], true ) : ''; 
                        ?>
                    >
                        <?php echo esc_html( ucfirst( $item ) ); ?>
                    </option>                
                <?php endforeach; ?>
            </select>
            <?php
        }


        //metodo de filtro que valida os campos.
        public function dn_slider_validate( $input ){
            $new_input = array();

            //iniciando as verificação
            foreach( $input as $key => $value ){
                switch ($key){
                    case 'dn_slider_title':

                        //verificando se o valor e vazio
                        if( empty( $value )){
                            add_settings_error( 'dn_slider_options', 'dn_slider_message', 'The title field can not be left empty', 'error' );
                            $value = esc_html__('Please, type some text', 'dn-slider');
                        }

                        //formatando o valor da string
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                    default:
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                }
            }

            //retornando a função
            return $new_input;
        }

    }
}