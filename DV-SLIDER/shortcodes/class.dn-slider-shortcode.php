<?php 
//class do responsavel pelo shortcode

if( ! class_exists('DN_Slider_Shortcode')){
    class DN_Slider_Shortcode{
        //metodo construtor
        public function __construct(){
            //forma de add o shortcode
            add_shortcode( 'dn_slider', array( $this, 'add_shortcode' ) );
        }

        //metodo de add o
        public function add_shortcode( $atts = array(), $content = null, $tag = '' ){

            $atts = array_change_key_case( (array) $atts, CASE_LOWER );

            extract( shortcode_atts(
                array(
                    'id' => '',
                    'orderby' => 'date'
                ),
                $atts,
                $tag
            ));

            // condição que veriuficara se a variavel e vazia e criar o arry 
            if( !empty( $id ) ){
                $id = array_map( 'absint', explode( ',', $id ) );
            }

            //colocando o obj do shortcode em um bulff
            ob_start();

            //instanciando a class class.dn-slider-shortcode.php
            require( DN_SLIDER_PATH . 'views/dn-slider_shortcodes.php' );
        
           // wp_enqueue_script( 'dn-slider-main-jq' );
            wp_enqueue_script( 'dn-slider-options-js' );
            //wp_enqueue_script( 'dn-slider-jquery-jq' );
            wp_enqueue_style( 'dn-slider-main-css' );
            wp_enqueue_style( 'dn-slider-style-css' );
            //wp_enqueue_script( 'dn-slider-slick-js' );

            //devolvendo o obj do shortcode em uma função clean 
            return ob_get_clean();
        }
    }
}