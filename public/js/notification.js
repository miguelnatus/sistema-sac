$(document).ready(function() {

	listenNotification();

});

function listenNotification(){

    // A cada 4 minutos

    $.ajax({
        url: url + "Dashboard/listen",
        type: "POST",
        
        beforeSend: function () {
            console.log('Monitorando');
        },
    
        success: function(result){
            // Adicionar result na view
            console.log('Monitorado');
            
        }
        
    });

}