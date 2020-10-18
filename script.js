$(document).ready(() => {

    //Competencia
    let competencia = function(){
        $('#competencia').on('change', e => {
            let competencia = $(e.target).val()
    
            $.ajax({
                //método, URL, dados, success ou fail 
                type: 'GET',
                url: 'php/service.php',
                data: `competencia=${competencia}`,
                dataType: 'json',
                success: dados => {
                    $('#numeroVendas').html(dados.numeroVendas) //Número Vendas
                    $('#totalDespesas').html(dados.totalDespesas) //Total Despesas
                    $('#clientInativos').html(dados.clientInativos) //Clientes Inativos
                    $('#clientAtivos').html(dados.clientAtivos) //Clientes Ativos
                    $('#totalVendas').html(dados.totalVendas) //Total Vendas
                    $('#totalElogios').html(dados.clientInativos) //Total Elogios
                    $('#totalReclamacao').html(dados.totalReclamacao) //Total Reclamação
                    $('#totalSugestao').html(dados.totalSugestao) //Total Sugestão
                },
                error: erro => {console.log(erro)}
            })
        })
    }
    
    //Ajax
    $('#documentacao').on('click', () => {
        $('#pagina').load('documentacao.html')
    })

    $('#suporte').on('click', () => {
        $('#pagina').load('suporte.html')
    })

    $('#dashboard').on('click', () => {
        $('#pagina').load('dashboard.html', () => {
            competencia()
        })  
    })

    //Load
    $('#pagina').load('dashboard.html', () => {
        competencia()
    })

    
        


})