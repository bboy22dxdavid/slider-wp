<?php

/**
 * Plugin Name: DN SLIDER
 * Plugin URI: https://www.wordpress.org/mv-slider
 * Description: My plugin's description
 * Version: 1.0
 * Requires at least: 5.6
 * Author: David Nilo
 * Author URI: https://www.codigowp.net
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: dn-slider
 * Domain Path: /languages
 */

 /*
DN SLIDER is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
DN SLIDER is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with DN SLIDER. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

//condição que para a aplicação caso o plugin seja acessado diretamente 
if( ! defined( 'ABSPATH') ){
    exit;
}

//bloco de verificação se a class exist
if( ! class_exists( 'DN_SLIDER' ) ){
    class DN_SLIDER{
         //metodo construtod da class
        function __construct(){
            //chamando metodo construtor
            $this->define_constants();

            $this->load_textdomain();
            
            //gancho para acionar o menu
            add_action( 'admin_menu', array( $this, 'add_menu' ) );

            require_once( DN_SLIDER_PATH . 'post-types/class.dn-slider-cpt.php' );
            $DN_Slider_Post_Type = new DN_Slider_Post_Type();

            //instanciando a class class.dn-slider-settings.php
            require_once( DN_SLIDER_PATH . 'class.dn-slider-settings.php' );
            //instanciando o obj da class class.dn-slider-settings.php
            $DN_Slider_Settings = new DN_Slider_Settings();

            //instanciando a class class.dn-slider-shortcode.php
            require_once( DN_SLIDER_PATH. 'shortcodes/class.dn-slider-shortcode.php' );
            //instanciando o obj da class class.dn-slider-shortcodes.php
            $DN_Slider_Shortcode = new DN_Slider_Shortcode();

            //add o gancho do hook para o script do style
            add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 999 );

            //add o gancho do hook para o script do style no back end
            add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts') );
        }

        //metodo para receber o caminho das constantes
        public function define_constants(){
            //caminha da pasta do plugin
            define( 'DN_SLIDER_PATH', plugin_dir_path( __FILE__ ) );
            //endereço WEB do arq
            define( 'DN_SLIDER_URL', plugin_dir_url( __FILE__ ) );
            //versão do plugin
            define( 'DN_SLIDER_VERSION', '1.0.0' );
        }

        // função que ativa o plugin = register_activation_hook()
        public static function activate(){

            //refazer os links automaticamente
            //flush_reewrit_rules();
            //refazer os links automaticamente, atualiza o valor da tabela na base de dados
            update_option( 'rewrite_rules', '' );
        }

        // função que desativa o plugin = register_deactivation_hook()
        public static function deactivate(){
            flush_rewrite_rules();
            unregister_post_type( 'dn-slider' );
        }

        // função que exclui o plugin = register_unistall_hook()
        public static function uninstall(){

            delete_option( 'dn_slider_options' );

            $posts = get_posts(
                array(
                    'post_type' => 'dn-slider',
                    'number_posts'  => -1,
                    'post_status'   => 'any'
                )
            );

            foreach( $posts as $post ){
                wp_delete_post( $post->ID, true );
            }
        }

        public function load_textdomain(){
            load_plugin_textdomain(
                'dn-slider',
                false,
                dirname( plugin_basename(__FILE__)) . '/languages/'
            );
        }

        // função que cria o menu
        public function add_menu(){
            //para mudar o local do meu basta informa a função onde deseja ex: add_plugins_page() ou   add_theme_page()
            add_menu_page(
                'DN Slider Options',
                'DN Slider',
                'manage_options',
                'dn_slider_admin',
                array( $this, 'dn_slider_settings_page' ),
                'dashicons-images-alt2'
            );

            // metodo que cria o submenu
            add_submenu_page(
                'dn_slider_admin',
                esc_html__('Manage Slides','dn-slider'),
                esc_html__('Manage Slides','dn-slider'),
                'manage_options',
                'edit.php?post_type=dn-slider',
                null,
                null
            );

            add_submenu_page(
                'dn_slider_admin',
                esc_html__('Add New Slide', 'dn-slider'),
                esc_html__('Add New Slide', 'dn-slider'),
                'manage_options',
                'post-new.php?post_type=dn-slider',
                null,
                null
            );
        }

        public function dn_slider_settings_page(){
            //verificação de acesso, iniciando uma condção de garda
            if( ! current_user_can( 'manage_options' ) ){
                return;
            }
            //condição para exibir mensagem de sucesso
            if( isset( $_GET['settings-updated'] ) ){
                add_settings_error( 'dn_slider_options', 'dn_slider_message', esc_html__('Settings Saved', 'dn-slider'),'success' );
            }
            //condição para exibir mensagem de error
            settings_errors( 'dn_slider_options' );
            
            require( DN_SLIDER_PATH . 'views/settings-page.php' );
        }

        //função para chamaro css no front end /wp-content/plugins/DV-SLIDER/assets/img/01.png
        public function register_scripts(){
            // wp_register_script( 'dn-slider-main-jq', DN_SLIDER_URL . 'vendor/flexslider/jquery.flexslider-min.js', array( 'jquery' ), DN_SLIDER_VERSION, true );
            //wp_register_script( 'dn-slider-jquery-jq', DN_SLIDER_URL . 'vendor/jquery.min.js', array( 'jquery' ), DN_SLIDER_VERSION, true );
            wp_register_script( 'dn-slider-options-js', DN_SLIDER_URL . 'vendor/flexslider/flexslider.js', array( 'jquery' ), DN_SLIDER_VERSION, true );
            wp_register_style( 'dn-slider-main-css', DN_SLIDER_URL . 'vendor/flexslider/flexslider.css', array(), DN_SLIDER_VERSION, 'all' );
            wp_register_style( 'dn-slider-style-css', DN_SLIDER_URL . 'assets/css/frontend3.css', array(), DN_SLIDER_VERSION, 'all' );
           // wp_register_script( 'dn-slider-slick-js', DN_SLIDER_URL . 'vendor/slick/slick/slick.min.js', array( 'jquery' ), DN_SLIDER_VERSION, true );

        }

        //funcao para acessar o hook para o script do style no back end
        public function register_admin_scripts(){
            global $typenow;
            if( $typenow == 'dn-slider'){
                wp_enqueue_style( 'dn-slider-admin', DN_SLIDER_URL . 'assets/css/admin.css' );
            }
        }



    }
}

// bloco que instancia a class e executa o plugin
if( class_exists( 'DN_SLIDER' ) ){
    
    //instanciando as funções de ativa, desativa e excluir
    register_activation_hook( __FILE__, array( 'DN_SLIDER', 'activate' ) );
    register_deactivation_hook( __FILE__, array( 'DN_SLIDER', 'deactivate' ) );
    register_uninstall_hook( __FILE__, array( 'DN_SLIDER', 'uninstall' ) );

    $dn_slider = new DN_SLIDER();
} 
