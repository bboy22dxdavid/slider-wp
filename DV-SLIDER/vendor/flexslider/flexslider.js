$(function(){

  function atualizar_informacoes() {
/* =================================================
      PASSA PARA A VARIAVEL ATRIBUTOS A TAG IMG
  ================================================= */ 
    var atributo = document.querySelectorAll('.slick-center img');

    //ADD A VARIAVEL O CONTEUDO DO ATRIBUTO DATA- PARA A VARIAVEL
    //console.log(atributo.item(0).getAttribute('data-price'));
    //console.log(atributo.item(0).getAttribute('data-name'));
    //console.log(atributo.item(0))
  
    $("#watch-titulo").text( atributo.item(0).getAttribute('data-titulo') );
    $("#watch-subtitulo").text( atributo.item(0).getAttribute('data-subtitulo') );
    $("#watch-paragrafo").text(atributo.item(0).getAttribute('data-paragrafo'));
    $("#watch-descricao").text(atributo.item(0).getAttribute('data-discricao').replace(/[<p></p>]/g, ''));
    $("#watch-button").text(atributo.item(0).getAttribute('data-button'));

    //variavel do tipo DOUBLE APENAS NUMEROS
    //var watchPrice = parseFloat(atributo.item(0).getAttribute('data-price')).toLocaleString("pt-BR", {style:"currency", currency: "BRL", minimumFractionDigits: 2});
    //$("#watch-price").text( watchPrice);
  }

  $(".watch-slider").on('init', function(){
    atualizar_informacoes();
    
  });

  $(".watch-slider").slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: true,
    centerMode: true,
    prevArrow: $("#arrow-prev"),
    nextArrow: $("#arrow-next"),
    responsive: [
      {
      
       breakpoint: 600,
       settings: {
           slidesToShow: 2,
           slidesToScroll: 1,
           dots: true
       } ,
       breakpoint: 480,
       settings: {
           slidesToShow: 1,
           slidesToScroll: 1,
           dots: true
       }
      }
   ]

  });

  $(".watch-slider").on('afterChange', function(){
    atualizar_informacoes();
  });

})
