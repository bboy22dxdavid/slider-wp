<?php 

//bloco de verificação se a class exist
if( !class_exists( 'DN_Slider_Post_Type') ){
    class DN_Slider_Post_Type{

        //metodo construtod da class
        function __construct(){
            //cancho para iniciar
            add_action( 'init', array( $this, 'create_post_type' ) );

            //cancho para add o metabox
            add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

            //cancho para sava o post na base
            add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );

            //cancho para  filtro
            add_filter( 'manage_dn-slider_posts_columns', array( $this, 'dn_slider_cpt_columns' ) );

            //cancho para add as info no filtro
            add_action( 'manage_dn-slider_posts_custom_column', array( $this, 'dn_slider_custom_columns'), 10, 2 );
            
            //cancho para  filtro
            add_filter( 'manage_edit-dn-slider_sortable_columns', array( $this, 'dn_slider_sortable_columns' ) );
        }

        //metodo de criação de post
        public function create_post_type(){
            register_post_type(
                'dn-slider',
                array(
                    'label' => esc_html__('Slider', 'dn-slider'),
                    'description'   => esc_html__('Sliders', 'dn-slider'),
                    'labels' => array(
                        'name'  => esc_html__('Sliders', 'dn-slider'),
                        'singular_name' => esc_html__('Slider', 'dn-slider'),
                    ),
                    'public'    => true,
                    'supports'  => array( 'title', 'editor', 'thumbnail' ),
                    'hierarchical'  => false,
                    'show_ui'   => true,
                    'show_in_menu'  => false,
                    'menu_position' => 5,
                    'show_in_admin_bar' => true,
                    'show_in_nav_menus' => true,
                    'can_export'    => true,
                    'has_archive'   => false,
                    'exclude_from_search'   => false,
                    'publicly_queryable'    => true,
                    'show_in_rest'  => true,
                    'menu_icon' => 'dashicons-images-alt2'
                    //forma secundaria de chamar a metabox
                    //'register_meta_box_cb' => array($this, 'add_meta_boxes')
                )
            );
        }

        //funçao para filtra os meta boxes
        public function dn_slider_cpt_columns( $columns ){
            $columns['dn_slider_link_text'] = esc_html__( 'Link Text', 'dn-slider' );
            $columns['dn_slider_link_url'] = esc_html__( 'Link URL', 'dn-slider' );
            return $columns;
        }

        //funçao para add no info no filtra 
        public function dn_slider_custom_columns( $column, $post_id ){
            switch( $column ){
                case 'dn_slider_link_text':
                    echo esc_html( get_post_meta( $post_id, 'dn_slider_link_text', true ) );
                break;
                case 'dn_slider_link_url':
                    echo esc_url( get_post_meta( $post_id, 'dn_slider_link_url', true ) );
                break;                
            }
        }

        //funçao para ordenar
        public function dn_slider_sortable_columns( $columns ){
            $columns['dn_slider_link_text'] = 'dn_slider_link_text';
            return $columns;
        }

        //funçao para criar o meta boxes
        public function add_meta_boxes(){
            add_meta_box(
                'dn_slider_meta_box',
                esc_html__('Link Options', 'dn-slider'),
                array( $this, 'add_inner_meta_boxes' ),
                'dn-slider',
                'normal',
                'high'
            );
        }

         //funçao para iniciar a meta boxes,
         public function add_inner_meta_boxes( $post ){
            //criando campos da meta boxes
            require_once( DN_SLIDER_PATH . 'views/dn-slider_metabox.php' );

         }

        //metodo para salvar a meta boxes do post
         public function save_post( $post_id ){
            //verificação do nonce
            if( isset( $_POST['dn_slider_nonce'] ) ){
                if( ! wp_verify_nonce( $_POST['dn_slider_nonce'], 'dn_slider_nonce' ) ){
                    return;
                }
            }
            
            //verificando se o wp não esta fazendo auto save do post
            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
                return;
            }

            //verificando se esta na tela do cpt correto
            if( isset( $_POST['post_type'] ) && $_POST['post_type'] === 'dn-slider' ){
                if( ! current_user_can( 'edit_page', $post_id ) ){
                    return;
                }elseif( ! current_user_can( 'edit_post', $post_id ) ){
                    return;
                }
            }


            //validação dos dados add
            if( isset( $_POST['action'] ) && $_POST['action'] == 'editpost' ){
                $old_link_text = get_post_meta( $post_id, 'dn_slider_link_text', true );
                $new_link_text = $_POST['dn_slider_link_text'];
                $old_link_url = get_post_meta( $post_id, 'dn_slider_link_url', true );
                $new_link_url = $_POST['dn_slider_link_url'];

                //validando as informaçõs
                if( empty( $new_link_text )){
                    update_post_meta( $post_id, 'dn_slider_link_text', esc_html__('Add some text', 'dn-slider')  );
                }else{
                    update_post_meta( $post_id, 'dn_slider_link_text', sanitize_text_field( $new_link_text ), $old_link_text );
                }

                if( empty( $new_link_url )){
                    update_post_meta( $post_id, 'dn_slider_link_url', '#' );
                }else{
                    update_post_meta( $post_id, 'dn_slider_link_url', sanitize_text_field( $new_link_url ), $old_link_url );
                }
            }
        }

    }
}
