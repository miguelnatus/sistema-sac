$(document).ready(function() {

    showDeleteButton();
    deleteMessage();
	
	

});

function showDeleteButton(){
		
    $( ".texto-mensagem" ).mouseover(function(e) {
        $('.botao_excluir').remove();

        elementoClicado = $(this);
        var largura = $(this).width();
        var idMensagem = $(this).attr('id')
        if($(this).width() > 850){
            var larguraMenor = largura - 40;
            $(this).css("width", larguraMenor);
        }
        
        $(this).parent().before("<div class='botao_excluir'>	<img src='" + url + "public/imgs/estrutura/icones/trash.svg' </div>");
        $('.botao_excluir').attr('id', idMensagem);
        var element = $(this);
        var altura = element.height();
        var altura = altura + 20;
        $(".botao_excluir").css("height", altura);	
       
        if($(this).parent().attr('class') == 'msg giulia-domna'){
            $(".botao_excluir").css("float", "right");
            $(".botao_excluir").css("margin-left", "0px");
            $(".botao_excluir").css("margin-right", "10px");
        }
      });
      $( ".texto-mensagem" ).parent().parent().mouseleave(function(e) { 			  
            $('.botao_excluir').remove();
            $('.texto-mensagem').css('width', 'auto');

      }); 
}

function deleteMessage(){


$("body").on("click", ".botao_excluir",function(){

    
    
    var element = $(this);
    var id = element.attr('id')

    $("div#" +id+ ".texto-mensagem").parent().remove();
    

$.ajax({
    url: url + "admin/deleteMessage",
    type: "POST",
    data: {"id" : id},
    
    beforeSend: function () {
        console.log('Excluding');
    },

    success: function(result){
        
        console.log('success');
        
    }
    
});
});

}