$(document).ready(() => {
    
    $('#documentacao').on('click', () => {
        $('#pagina').load('documentacao.html')
    })

    $('#suporte').on('click', () => {
        $('#pagina').load('suporte.html')
    })
    

    //Ajax
    $('#competencia').on('change', e => {

        let competencia = $(e.target).val()

        $.ajax({
            //método, URL, dados, success ou fail 
            type: 'GET',
                url: 'php/service.php',
                data: `competencia=${competencia}`,
                dataType: 'json',
                success: dados => {
                    $('#numeroVendas').html(dados.numeroVendas)
                },
                error: erro => {console.log(erro)}

        })


    })


})