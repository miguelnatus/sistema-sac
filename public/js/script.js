$(document).ready(function() {

	previewSolicitacao();
	previewFotos();
	jumpMenus(".botao-notificacoes", ".notificacoes", "#lista-notificacoes");
	jumpMenus(".nome-usuario", ".menu-usuarios", "#opcoes-menu-usuarios");
	solicitacoesAjustaLink();
	addItem();
	productImageUpload();
	removeItem();
	inputMask();
	changeStatus();
	productImageUploadPerfil();
	inputFile();
	messageNotification();
	boxSelected();
	

});

var count = 1;

function previewSolicitacao(){
	$(".solicitacoes th > span").on("click", function(){
	$(this).parents("tr").next("tr").toggle();

	});
}

function inputFile(){
	$(document).on('change', ':file', function() {
		var	fotos = $(this).val().replace(/C:\\fakepath\\/i, '');
		$('span.anexo').append(fotos);
	});	
}

function previewFotos(){
	$(".preview-fotos a")
		.on("mouseenter", function(){
			$(this).append("<span class='foto-zoom'><img src='"+$(this).find("img").attr("src")+"'></span>");
		})
		.on("mouseleave", function(){
			$(this).find(".foto-zoom").remove();
		})
		.on("click", function(event){
			envent.preventDefault();
		});
}

function jumpMenus(elementoEnter, elementoLeave, menuID){
	var timeoutId=0;
	$(elementoEnter)
		.on("mouseenter", function(){
			$(menuID).slideDown("fast");
		})
		.on("click", function(event){
			envent.preventDefault();
		});
	$(elementoLeave)
		.on("mouseleave", function(){
			timeoutId = setTimeout(function(){ $(menuID).slideUp("fast"); }, 500);
		})
		.on("mouseenter", function(){
			clearTimeout(timeoutId);
		});
}

function changeUserStatus(){

	var checkbox = $("input[type='checkbox']");
	
	checkbox.on("change",function(){
		var status = $(this).val();

		$.ajax({
			url: url + "admin/changeuserstatus",
			method: "POST",
			data: status,
			dataType: "html",

			beforeSend: function () {
				
			},

			success: function(result){

			}
		});

	});

}

function changeStatus(){
	
	var checkbox = $("input[type='checkbox']");

	
	checkbox.on("change",function(){

		var status = $(this).is(":checked") ? 1 : 0;
		var id = $(this).data("id");
		var element = $(this);

		$.ajax({
			url: url + "admin/changeuserstatus",
			type: "POST",
			data: {"status" : status, "id" : id},
			dataType: "text",

			beforeSend: function () {
				element.after("<div class='loader'><img class='ajax-loader' src='"+url+"public/imgs/estrutura/ajax-loading.gif'></div>");
			},

			success: function(result){
				element.siblings("div").remove();
			}
		});

	});

}

function solicitacoesAjustaLink(){
	$(".solicitacoes tbody > tr:not(.preview-solicitacao)").on("click", function(){
		$(this).find("th a")[0].click();
	});
}

function addItem(){

	$("button#adicionar-item").on("click",function(){
		// Pega o primeiro item da lista de itens (item de indice 0).
		var item = $(this).parent().siblings().children().first();

		// Pega o conteúdo HTML do primeirp item e substitui todas as ocorrências de 'itens[0]' e substitui por itens['contador de itens']. Também substitui as ocorrências de '<span class="item-numero">1</span>' por '<span class="item-numero">'contador de itens + 1'</span>'
		var item_atualizado = item.html().replace(/itens\[0]/g,"itens["+count+"]").replace(/-0/g,"-"+count).replace('<span class="item-numero">1</span>','<span class="item-numero">'+Number(count + 1)+'</span>');
		
		// Cria um novo elemento 'LI'
		var novo_item = document.createElement("li");

		// Insere o conteudo HTML atualizado dentro da LI que foi criada
		novo_item.innerHTML = item_atualizado;

		// Pega todas as tags 'img' do novo item
		var images_novo_item = novo_item.querySelectorAll("img");
		
		// Percorre todas as imagens do novo item e reseta o atributo 'src'
		for (let i = 0; i < images_novo_item.length; i++) {
			images_novo_item[i].src = "";
		}
		
		// Cria um novo elemento 'A'
		var remove_item = document.createElement("a");
		remove_item.href = "#";
		remove_item.textContent = "\u00D7";
		remove_item.className = "remove-item";

		// Insere botão para remover item
		novo_item.append(remove_item); 

		// Insere o novo item ao final da lista de itens
		$(".listagem-itens ul").append(novo_item);

		count ++;
		inputMask();
	});

}

function productImageUpload(){

	$("body").on("change",".input-files input[type='file']",function(){

		var id = $(this).attr("id");
		$(".logo-empresa").show();
		var reader = new FileReader();
		var image = $(this).parent().siblings(".input-files-mascara").children("label[for='"+id+"']").children("img");

		reader.onloadend = function() {
			
			$(image).show().attr('src', reader.result);
		}
		
		reader.readAsDataURL(this.files[0]);

	});

}

function productImageUploadPerfil(){
	$("body").on("change",".custom-file input[type='file']",function(){
	
		var reader = new FileReader();
		var image = $(this).parent().parent().siblings(".logo-empresa").children("img");
		
		reader.onloadend = function() {
			$(image).show().attr('src', reader.result);
		}
				
		reader.readAsDataURL(this.files[0]);

	});

}

function removeItem(){

	$("body").on("click",".remove-item",function(e){
		e.preventDefault();
		$(this).parent().remove();
		count --;
	});

}

function inputMask(){
	if($('input[name="cnpj"]') != null){
	$('input[name="cnpj"]').mask('00.000.000/0000-00');
	}
	if($('input[name="telefone"]') != null){
		$('input[name="telefone"]').mask('(00) 0000-0000');
	}
		
	if($('input.form-control.refe') != null){
		// var item = $(this).parent().siblings().children().first();
		// console.log(item);
		$('input.form-control.refe').mask('000.00/000');
		
	}

}

function messageNotification(){
	
}

function boxClose(){
	$(".modal.relatorio").hide();
}

function boxSelected(){
	var option_value = document.getElementById("relatorioSelected").value;
    if (option_value == "lojista") {
		$(".modal.relatorio").show(listarLojista());
	
    }
}

 function listarLojista(){
	$.ajax({
		url: url + "relatorios/listLojista",
		type: "POST",
		dataType: "json",

		beforeSend: function () {
			console.log('running');
		},

		success: function(result){
			var list = result;
			console.log(result);
			if(!$('.modal-body.relatorio tbody tr').length){
				for (var key in result) {
					// var obj = result[key];																																						
					
						 $(".modal-body.relatorio tbody").append('<tr class="'+ result[key].id + 'lojista'+ '" > <th scope="row">' + result[key].razao_social + '</th><th scope="row">' + result[key].cnpj + '</th><th scope="row"><div class="form-check" ><input class="form-check-input" form="formrelatorio" type="checkbox" name="lojistas[]" value="' + result[key].id + '" id="checkLojista"></div></th></tr>');
					   
					}	
			}
			
		}			
		
	});
}

function checkAll(button){
	var checkboxes = document.querySelectorAll('input[type="checkbox"]#checkLojista');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != button)
            checkboxes[i].checked = button.checked;
    }
}


