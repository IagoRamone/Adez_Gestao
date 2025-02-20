
(function ($) {
    "use strict";

    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    
    

})(jQuery);


document.addEventListener("DOMContentLoaded", function() {
    fetch('/backend/query/verifica_contratos.php')
    .then(response => response.json())
    .then(data => {
        if (data.length > 0) {
            let notificacoes = document.getElementById("notificacoes");
            notificacoes.innerHTML = "<h3>Contratos Próximos do Vencimento</h3>";

            data.forEach(contrato => {
                let alerta = document.createElement("div");
                alerta.classList.add("alerta");
                alerta.innerHTML = `<strong>${contrato.razao_social}</strong>: vence em ${contrato.data_vencimento}`;
                notificacoes.appendChild(alerta);
            });

            notificacoes.style.display = "block";
        }
    })
    .catch(error => console.error("Erro ao buscar notificações:", error));
});
