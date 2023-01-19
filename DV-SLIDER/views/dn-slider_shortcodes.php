<!--CABEÇALIO DA PAGINA -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link rel="stylesheet" href="/wp-content/plugins/DV-SLIDER/vendor/slick/slick/slick.css">
    <link rel="stylesheet" href="/wp-content/plugins/DV-SLIDER/vendor/slick/slick/slick-theme.css">
</head>


<!--================
<script src="/wp-content/plugins/DV-SLIDER/vendor/jquery.min.js"></script>
-->

<div class="global-page-container <?php echo ( isset( DN_Slider_Settings::$options['dn_slider_style'] ) ) ? esc_attr( DN_Slider_Settings::$options['dn_slider_style'] ) : 'style-1'; ?>"><!-- CONTAINER GLOBAL-->

    <div class="watch-slider"><!--CONTAINER DO SLIDE-->

    <!--=====================================-->
            <!--INICIO DO  PHP-->
    <!--=====================================-->
    <?php 
        $args = array(
            'post_type' => 'dn-slider',
            'post_status'   => 'publish',
            'post__in'  => $id,
            'orderby' => $orderby
        );

        $my_query = new WP_Query( $args );

        if( $my_query->have_posts() ):
            while( $my_query->have_posts() ) : $my_query->the_post();

        $button_text = get_post_meta( get_the_ID(), 'dn_slider_link_text', true );
        $button_url = get_post_meta( get_the_ID(), 'dn_slider_link_url', true );
    ?>
      <!--IMAGEM, TITULO, SUBTITULO, DO SLIDE-->
        
         
            <img data-titulo="<?php the_title(); ?>"  data-subtitulo="sub-titulo" data-paragrafo="segundo titulo" data-discricao="<?php the_content(); ?>" data-button="<?php echo esc_html( $button_text ); ?>" class="slide" <?php 
            if(has_post_thumbnail()){
                the_post_thumbnail();
            } else{
                echo "<img src='" .DN_SLIDER_URL."assets/images/default.jpg' />";
                //echo dn_slider_get_placeholder_image();
            }
            ?>>
       
            <!--FIM DO WHILE PHP-->        
    <?php
        endwhile; 
        wp_reset_postdata();
        endif; 
    ?>
    </div>

    <div id="arrow-prev" class="arrow"></div><!--DIV DO BOTÃO VOLTAR-->
    <div id="arrow-next" class="arrow"></div><!--DIV DO BOTÃO AVANÇAR-->
    <div class="linha"></div>
    <div class="linha-botton"></div>
    <div id="watch-titulo" class="textos"></div><!--DIV DO TITULO DO SLIDE-->
    <div id="watch-subtitulo"></div><!--DIV DO SUBTITULO DO SLIDE-->
    <div id="watch-paragrafo"></div><!--DIV DO 1 PARAGRAFO DO SLIDE-->
    <div id="watch-descricao"></div><!--DIV DO DESCRIÇAO DO SLIDE-->
    <div id="watch-button"></div><!--DIV DO BOTÃO DO SLIDE-->

    


</div>



    <!--======SCRIPTS==========-->
    <script src="/wp-content/plugins/DV-SLIDER/vendor/jquery.min.js"></script>
    <script src="/wp-content/plugins/DV-SLIDER/vendor/slick/slick/slick.js"></script>

 

