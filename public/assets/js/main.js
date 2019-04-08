/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Listen for click on toggle checkbox

function ajax_parametros(url,div, dados, tipo, type, datatype)
{
    //alert(tipo);
    if (type === undefined) {
          datatype = 'get';
    }
    if (type === undefined) {
          datatype = 'html';
    }
    $.ajax({
        url : url,
        type : type,
        data : dados,
        dataType: datatype,
        beforeSend: function()
        {
            $('#carregando').fadeIn();  
        },
        timeout: 5000,    
        success: function(retorno)
        {
          if(tipo === "add")
          {
              //alert(retorno);
              $(div).append(retorno);
          }
          if(tipo === "delete")
          {
              location.reload();
          }
          else
          {   
              $(div).html(retorno);
          }
        },
        error: function(erro)
        {
              $(div).html(erro);
        }       
    });
}
function pesquisa_cliente()
{
   var url="clientes/buscar/tipo/resultado/json/";
   var div="#resultado_busca_cliente";
   var dados = JSON.stringify($('#busca_cliente').serializeArray());
   ajax_parametros(url+dados, div, '', '');
}
function pesquisa_produto()
{
   var url="produtos/buscar/tipo/resultado/json/";
   var div="#resultado_busca_produto";
   var dados = JSON.stringify($('#dados_do_produto').serializeArray());
   ajax_parametros(url+dados, div, '', '');
}
function novo_modal(div_pai,div_filho, largura, altura, index, index_mascara, href)
{	
    var HTML = document.createElement("div");
	HTML.setAttribute("id", "div_"+div_filho);
        HTML.setAttribute("class","window");
        HTML.setAttribute("style","height:"+altura+"px;overflow-y:auto");
        corpo = document.getElementById(div_pai);
        corpo.parentNode.appendChild(HTML, corpo);
        HTML = document.createElement("div");
        HTML.setAttribute("id", "mascara_"+div_filho);
        corpo = document.getElementById(div_pai);
        corpo.parentNode.appendChild(HTML, corpo);	
        var id = '#div_'+div_filho;
        var mascara = '#mascara_'+div_filho;
        var alturaTela = $(document).height();
        var larguraTela = $(window).width();
        $(mascara).css({'width':larguraTela,
                        'height':alturaTela,
                        'position':'absolute',
                        'left':'0',
                        'top':'0',
                        'z-index':index_mascara,
                        'background-color':'#000000',
                        'display':'none'});
        $(mascara).fadeIn(1500);	
        $(mascara).fadeTo("fast",0.8);
        if (largura > ($(window).width() * 0.8))
        {
                largura = $(window).width()* 0.8;
        }
        var left = ($(window).width() /2) - ( largura / 2 );
        var top = ($(window).height() / 2) - ( altura / 2 );
        if (top < 0)
        {
                top=altura*0.1;
        }
        $(id).css({'top':top,
                   'left':left,
                   'width':largura,
                   'z-index':index});
        $(id).load(href);
        $(id).show();
}
function capta_width()
{
	var width = screen.width;
	width = width - 10;
	return width;
}
function captaheight()
{
	var height = screen.height;
	height = height-100;
	return height;
}
function deletar_pedido(id)
{
    if (id)
    {
        confirmar = confirm("Deseja Mesmo deletar o Pedido com o ID = "+id+"?");
        if (confirmar)
	  {
		  ajax_parametros("deletar/"+id, "#detalhes_pedido", "", "delete");
	  }
	  else
	  {
		  return false;
	  }
    }
    else
    {
            alert("Não existe Orcamento selecionado!!");
    }
}
function deletar_orcamento(id)
{
	if (id)
	{
	  confirmar = confirm("Deseja Mesmo deletar o orcamento com o ID = "+id+"?");
	  if (confirmar)
	  {
		  ajax_parametros("deletar/"+id, "#detalhes_orcamento", "", "delete");
	  }
	  else
	  {
		  return false;
	  }
	}
}
function chama_nj(nome_janela, largura, altura)
{
    try{
      oJan2 = window.open('/retensul/retensul/public/'+nome_janela, nome_janela, 'height='+altura+', width='+largura);
    }
    catch (e)
    {
        alert("erro");
    }
}
function exibir_detalhes_pedido(id)
{
    //alert(id);
    //var dados = "id="+id;
    ajax_parametros("detalhes/"+id, "#detalhes_orcamento", "", "");
}
function fechar_janela()
{
	if (confirm("Deseja mesmo fechar esta janela?"))
	{
	  window.close();
	}
	else
	{
		return false;
	}
}
function fechar_div_modal(div)
{
	if(confirm("Deseja mesmo fechar esta Janela?"))
	{
  	  $("#div_"+div).remove();
	  $("#mascara_"+div).remove();
	}
	else
	{
		return false;
	}
}
function preencher_campo_cliente(id, nome, obs, fone, div)
{
    $("#id_cliente").val(id);
    $("#nome_cliente").val(nome);
    $("#obs_cliente").val(obs);
    $("#telefone_cliente").val(fone);
    if (obs !== '')
    {
        $("#obs_cliente").attr("style", "background-color: red" );
    }
    else
    {
        $("#obs_cliente").attr("style", "background-color: #e9ecef");
    }
    $("#"+div).modal('hide');
    $("#contato_cliente").focus(); 
}
function preencher_campo_produto(id, referencia, descricao, marca, preco, unidade, div)
{
    $("#id_produto").val(id);
    $("#referencia_produto").val(referencia);
    $("#descricao_produto").val(descricao);
    $("#marca_produto").val(marca);
    $("#preco_lista_produto").val((preco*1).toFixed(2));
    $("#preco_unit_produto").val((preco*1).toFixed(2));
    $("#un_produto").val(unidade);
    $("#"+div).modal('hide');
    $("#preco_unit_produto").focus();  
    
    
}
function preencher_campo_plano(id, descricao, div)
{
    $("#id_plano_pagamento").val(id);
    $("#descricao_plano_pagamento").val(descricao);
    $("#"+div).modal('hide');
    $("#obs_pedido").focus();
}
function calcula_total()
{
    try
    {
	var preco_lista_produto = $("#preco_lista_produto").val();
	var preco_venda_produto = $("#preco_unit_produto").val();
	    preco_venda_produto = preco_venda_produto.replace(",",".");
    	var qt_produto = $("#qt_produto").val();
	    qt_produto = qt_produto.replace(",",".");
    	var percentual_desconto_produto = $("#percentual_desconto_produto").val();
	    percentual_desconto_produto = percentual_desconto_produto.replace(",",".");
	var valor_desconto_produto = $("#valor_desconto_produto").val();
            valor_desconto_produto = valor_desconto_produto.replace(",",".");
     	var valor_total_produto = $("#valor_total_produto").val();
            valor_total_produto = valor_total_produto.replace(",",".");		
            valor_total_produto = ((qt_produto * preco_venda_produto));
    	if (preco_venda_produto < preco_lista_produto)
	{
            if((percentual_desconto_produto == 0) || (valor_desconto_produto == 0) )
            {
                $("#valor_desconto_produto").val(((preco_lista_produto*qt_produto) - (preco_venda_produto*qt_produto)).toFixed(2));
                $("#percentual_desconto_produto").val(((((preco_venda_produto/preco_lista_produto)-1)*-100)).toFixed(2));
                $("#valor_total_produto").val(valor_total_produto.toFixed(2));			
                $("#preco_unit_produto").val((preco_venda_produto*1).toFixed(2));
                $("#qt_produto").val((qt_produto*1).toFixed(2));
                
            }
            else
            {
                $("#valor_desconto_produto").val((((preco_lista_produto*qt_produto) - (preco_venda_produto*qt_produto))).toFixed(2));
                $("#percentual_desconto_produto").val((((preco_venda_produto/preco_lista_produto)-1)*-100).toFixed(2));			
                $("#valor_total_produto").val(valor_total_produto.toFixed(2));			
                $("#preco_unit_produto").val((preco_venda_produto*1).toFixed(2));
                $("#qt_produto").val((qt_produto*1).toFixed(2));
            }
        }
        else
        {
            $("#valor_desconto_produto").val(0.00);
            $("#percentual_desconto_produto").val(0.00);
            $("#valor_total_produto").val(valor_total_produto.toFixed(2));			
            $("#preco_unit_produto").val((preco_venda_produto*1).toFixed(2));
            $("#qt_produto").val((qt_produto*1).toFixed(2));
        }
    	}
    	catch (e)
	{
            alert("erro: "+e);
    	}
}
function valor_desconto()
{
    try
    {
	var preco_lista_produto = $("#preco_lista_produto").val();
	var preco_venda_produto = $("#preco_unit_produto").val();
	    preco_venda_produto = preco_venda_produto.replace(",",".");
    	var qt_produto = $("#qt_produto").val();
	    qt_produto = qt_produto.replace(",",".");
    	var percentual_desconto_produto = $("#percentual_desconto_produto").val();
	    percentual_desconto_produto = percentual_desconto_produto.replace(",",".");
	var valor_desconto_produto = $("#valor_desconto_produto").val();
            valor_desconto_produto = valor_desconto_produto.replace(",",".");
     	var valor_total_produto = $("#valor_total_produto").val();
            valor_total_produto = valor_total_produto.replace(",",".");
            preco_venda_produto = ((preco_lista_produto*qt_produto)-valor_desconto_produto)/qt_produto;
            $("#preco_unit_produto").val(preco_venda_produto.toFixed(2));
	    percentual_desconto_produto = (valor_desconto_produto/(preco_lista_produto*qt_produto))*100;
            $("#percentual_desconto_produto").val(percentual_desconto_produto.toFixed(2));
            valor_total_produto = preco_venda_produto * qt_produto;
            $("#valor_total_produto").val(valor_total_produto.toFixed(2));
            $("#valor_desconto_produto").val((valor_desconto_produto*1).toFixed(2));
	}
	catch (e)
	{
		alert("erro: "+e);
	}
}
function percentual_desconto()
{
    try
    {
	var preco_lista_produto = $("#preco_lista_produto").val();
	var preco_venda_produto = $("#preco_unit_produto").val();
	    preco_venda_produto = preco_venda_produto.replace(",",".");
    	var qt_produto = $("#qt_produto").val();
            qt_produto = qt_produto.replace(",",".");
    	var percentual_desconto_produto = $("#percentual_desconto_produto").val();
            percentual_desconto_produto = percentual_desconto_produto.replace(",",".");
	var valor_desconto_produto = $("#valor_desconto_produto").val();
            valor_desconto_produto = valor_desconto_produto.replace(",",".");
     	var valor_total_produto = $("#valor_total_produto").val();
            valor_total_produto = valor_total_produto.replace(",",".");
            preco_venda_produto = (preco_lista_produto*((percentual_desconto_produto/100)-1)*-1);
            $("#preco_unit_produto").val(preco_venda_produto.toFixed(2));
            valor_total_produto = preco_venda_produto * qt_produto;
            $("#valor_total_produto").val(valor_total_produto.toFixed(2));
	    valor_desconto_produto = (preco_lista_produto * qt_produto)-(preco_venda_produto*qt_produto);
	    $("#valor_desconto_produto").val(valor_desconto_produto.toFixed(2));    	
            $("#percentual_desconto_produto").val((percentual_desconto_produto*1).toFixed(2));    	
	}
	catch (e)
	{
		alert("erro"+e);
	}
}
function cadastrarItensOrcamentoTr(div, tipo)
{
    if(tipo === 'add')
    {
        var nr_item = $("#tabela_itens_inclusos > tbody > tr").length;
        nr_item = (nr_item*1)+1;
        var HTML = '';
        HTML += "<tr id='id_"+nr_item+"' name='id_"+nr_item+"' style='cursor:pointer'>";
        HTML += "<td nowrap='nowrap'><input type='hidden' id='tipo_produto[]' name='tipo_produto[]' value="+tipo_produto.value+" readonly='readonly' ><input type='hidden' id='item[]' name='item[]' value="+nr_item+" readonly='readonly'>"+nr_item+"</td>";
    }
    else
    {
        $("#tabela_itens_inclusos > tbody > .active").find('input').each(function(index, value) {
                if(index===12){
                    //alert(value.value+" - "+index);
                    //alert(($('#total_orcamento').val()*1)+" - "+(value.value*1));
                    var novo_total_orcamento = (($('#total_orcamento').val()*1)-(value.value*1));
                    $('#total_orcamento').val((novo_total_orcamento*1).toFixed(2));
                }
            });
        $('#tabela_itens_inclusos > tbody > .active > td').remove();
        var HTML = '';
        HTML += "<td nowrap='nowrap'><input type='hidden' id='tipo_produto[]' name='tipo_produto[]' value="+tipo_produto.value+" readonly='readonly' ><input type='hidden' id='item[]' name='item[]' value="+nr_item_produto.value+" readonly='readonly'>"+nr_item_produto.value+"</td>";
    }        
    HTML += "<td nowrap='nowrap'><input type='hidden' id='id_produto[]' name='id_produto[]' value="+id_produto.value+" readonly='readonly'>"+id_produto.value+"</td>";
    HTML += "<td nowrap='nowrap'><input type='hidden' id='referencia_produto[]' name='referencia_produto[]' value='"+referencia_produto.value+"' readonly='readonly'>"+referencia_produto.value+"</td>";
    HTML += "<td nowrap='nowrap'><input type='hidden' id='descricao_produto[]' name='descricao_produto[]' value='"+descricao_produto.value+"' readonly='readonly'>"+descricao_produto.value+"</td>";
    HTML += "<td nowrap='nowrap'><input type='hidden' id='marca_produto[]' name='marca_produto[]' value='"+marca_produto.value+"' readonly='readonly'>"+marca_produto.value+"</td>";
    HTML += "<td nowrap='nowrap'><input type='hidden' id='qt_produto[]' name='qt_produto[]' value="+qt_produto.value+" readonly='readonly'>"+qt_produto.value+"</td>";
    HTML += "<td nowrap='nowrap'><input type='hidden' id='un_produto[]' name='un_produto[]' value="+un_produto.value+" readonly='readonly'>"+un_produto.value+"</td>";
    HTML += "<td nowrap='nowrap'><input type='hidden' id='preco_lista_produto[]' name='preco_lista_produto[]' value="+preco_lista_produto.value+" readonly='readonly' >R$ "+preco_lista_produto.value+"</td>";
    HTML += "<td nowrap='nowrap'><input type='hidden' id='desconto_percentual_produto[]' name='desconto_percentual_produto[]' value="+percentual_desconto_produto.value+" readonly='readonly'>"+percentual_desconto_produto.value+"%</td>";
    HTML += "<td nowrap='nowrap'><input type='hidden' id='desconto_valor_produto[]' name='desconto_valor_produto[]' value="+valor_desconto_produto.value+" readonly='readonly' >R$ "+valor_desconto_produto.value+"</td>";
    HTML += "<td nowrap='nowrap'><input type='hidden' id='preco_unit_produto[]' name='preco_unit_produto[]' value="+preco_unit_produto.value+" readonly='readonly' >R$ "+preco_unit_produto.value+"</td>";
    HTML += "<td nowrap='nowrap'><input type='hidden' id='valor_total_produto[]' name='valor_total_produto[]' value="+valor_total_produto.value+" readonly='readonly' >R$ "+valor_total_produto.value+"</td>";
    if(tipo === 'add')
    {
        HTML += "</tr>";            
        $("#tabela_itens_inclusos > tbody").append(HTML);
    }
    else
    {
        $("#id_"+nr_item_produto.value).append(HTML);
    }
    var total_orcamento = ($('#total_orcamento').val()*1)+(valor_total_produto.value*1);
    $('#total_orcamento').val(total_orcamento.toFixed(2));
    $('#'+div).modal('hide');
    
}
function cadastraItensOrcamento(div)
{
    //alert($("#tabela_itens_inclusos > tbody > tr").length);
    if ($("#tabela_itens_inclusos > thead > tr").length == 0)
    {
        try
        {
            var HTML = '';
            HTML = '<table id="tabela_itens_inclusos" class="table table-striped table-hover table-bordered">';
            HTML += '<thead>';
            HTML += '<tr>';
	    HTML += '<th nowrap="nowrap"> Item</th>';
            HTML += '<th nowrap="nowrap"> ID Produto</th>';
	    HTML += '<th nowrap="nowrap"> Referencia Produto</th>';
            HTML += '<th nowrap="nowrap"> Descricao Produto</th>';
            HTML += '<th nowrap="nowrap"> Marca Produto</th>';
            HTML += '<th nowrap="nowrap"> QT Produto</th>';
            HTML += '<th nowrap="nowrap"> UN Produto</th>';
            HTML += '<th nowrap="nowrap"> Valor Lista</th>';
            HTML += '<th nowrap="nowrap"> Desconto</th>';
            HTML += '<th nowrap="nowrap"> Desconto </th>';
	    HTML += '<th nowrap="nowrap"> Valor Unit.</th>';
            HTML += '<th nowrap="nowrap"> Valor Total</th>';
            HTML += '</tr>';
            HTML += '</thead>';
            HTML += '<tbody>';
            $("#itens_produtos").append(HTML);
            cadastrarItensOrcamentoTr(div, 'add');
        }
	catch (e)
        {
            alert("erro"+e);
        }
    }
    else
    {	
	try
	{
	    cadastrarItensOrcamentoTr(div, 'add');
	}
        catch (e)
        {
            alert("erro"+e);
        }
    }
}
function cadastrar_produto()
{
    try
    {
        if($("#percentual_desconto_produto").val() > 30)
        {
            decisao = confirm("Voce utilizou um percentual maior que 30% ("+$("#percentual_desconto_produto").val()+"%), deseja confirmar?");
            if (decisao)
            {
                    cadastraItensOrcamento($("#div").val());
            }
            else 
            {
                    return false;
            }
        }
        else
        {
            cadastraItensOrcamento($("#div").val());
        }	
  }
  catch (e)
  {
	alert("erro"+e);
  }
}
function atualizar_produto()
{
    try
    {
        if($("#percentual_desconto_produto").val() > 30)
        {
            decisao = confirm("Voce utilizou um percentual maior que 30% ("+$("#percentual_desconto_produto").val()+"%), deseja confirmar?");
            if (decisao)
            {
                    cadastrarItensOrcamentoTr($("#div").val(), 'update');
            }
            else 
            {
                    return false;
            }
        }
        else
        {
            cadastrarItensOrcamentoTr($("#div").val(), 'update');
        }	
  }
  catch (e)
  {
	alert("erro"+e);
  }
}
function mudaTipoProduto(tipo)
{
    if($("#tipo_produto").val() == 2)
    {
        $("#id_produto").attr("disabled", true);
        $("#id_produto").addClass("disabled");
        $("#busca_produto_id").attr("disabled", true);
        $("#busca_produto_id").addClass("disabled");
        $("#busca_produto_id").removeClass("btn-primary");
        $("#busca_produto_id").addClass("btn-danger");
        $("#referencia_produto").attr("disabled", true);
        $("#referencia_produto").addClass("disabled");
        $("#busca_produto_referencia").attr("disabled", true);
        $("#busca_produto_referencia").addClass("disabled");
        $("#busca_produto_referencia").removeClass("btn-primary");
        $("#busca_produto_referencia").addClass("btn-danger");
        $("#descricao_produto").removeClass("disabled");
        $("#descricao_produto").attr("disabled", false);
        $("#descricao_produto").attr("readonly", false);        
        $("#marca_produto").removeClass("disabled");
        $("#marca_produto").attr("disabled", false);
        $("#marca_produto").attr("readonly", false);        
        $("#un_produto").removeClass("disabled");
        $("#un_produto").attr("disabled", false);
        $("#un_produto").attr("readonly", false);
        $("#preco_lista_produto").val('0.00'); 
        $("#descricao_produto").focus();
        if(tipo === 'cadastro')
        {
            $("#referencia_produto").val('');
            $("#id_produto").val('');
            $("#descricao_produto").val('');
            $("#marca_produto").val('');
            $("#un_produto").val('PC');
        }
    }
    else
    {
        $("#id_produto").attr("disabled", false);
        $("#id_produto").removeClass("disabled");
        $("#id_produto").val('');
        $("#busca_produto_id").attr("disabled", false);
        $("#busca_produto_id").removeClass("disabled");
        $("#busca_produto_id").addClass("btn-primary");
        $("#busca_produto_id").removeClass("btn-danger");
        $("#referencia_produto").attr("disabled", false);
        $("#referencia_produto").removeClass("disabled");
        $("#referencia_produto").val('');
        $("#busca_produto_referencia").attr("disabled", false);
        $("#busca_produto_referencia").removeClass("disabled");
        $("#busca_produto_referencia").addClass("btn-primary");
        $("#busca_produto_referencia").removeClass("btn-danger");
        $("#descricao_produto").addClass("disabled");
        $("#descricao_produto").attr("disabled", true);
        $("#descricao_produto").attr("readonly", true);
        $("#descricao_produto").val('');
        $("#marca_produto").addClass("disabled");
        $("#marca_produto").attr("disabled", true);
        $("#marca_produto").attr("readonly", true);
        $("#marca_produto").val('');
        $("#un_produto").addClass("disabled");
        $("#un_produto").attr("disabled", true);
        $("#un_produto").attr("readonly", true);
        $("#un_produto").val('');
        $("#preco_lista_produto").val('0.00');        
        $("#id_produto").focus();        
    }
}
$(document).on('click', '#grid_resultado_orcamento > tbody > tr', function () {
        $('.active').removeClass('active');
        $(this).addClass("active");
        $(this).find('td').each(function(index, value) {
           if(index==2){
               exibir_detalhes_pedido(value.innerHTML);
           }
        });
});
$(document).on('click', '#deletar_orcamento', function () {
    var verifica = false;
    $(".active").find('td').each(function(index, value) {
           if(index===2){
               deletar_orcamento(value.innerHTML);
               verifica=true;
           }
        });
    
    if (verifica===false)
    {
            alert("Não existe Orcamento selecionado!!");
    }
});
$(document).on('click', '#imprimir_orcamento', function () {
    var verifica = false;
    $(".active").find('td').each(function(index, value) {
           if(index===2){
               chama_nj('orcamento/imprimir/'+value.innerHTML,capta_width(),captaheight());
               //(value.innerHTML)
               verifica=true;
           }
        });
    
    if (verifica===false)
    {
            alert("Não existe Orcamento selecionado!!");
    }
});
$(document).on('click', '#incluir_orcamento', function () {
    chama_nj('orcamento/incluir',capta_width(),captaheight());
});
$(document).on('click', '#ver_categoria', function () {
    chama_nj('MeliCategories',capta_width(),captaheight());
});
/*$(document).on('click', '#incluir_produto_orcamento', function () {
    novo_modal('corpo','incluir_produto','900','600', '9100', '9000', 'produtos/buscar/tipo/janela/div/incluir_produto');
});*/
$(document).on('click', '#incluir_produto_orcamento', function () {
    //novo_modal('corpo','incluir_produto','900','600', '9100', '9000', 'produtos/buscar/tipo/janela/div/incluir_produto');
    ajax_parametros('produtos/buscar/tipo/janela/div/incluir_produto','#corpo', '', '', 'get', 'html');
});
$(document).on('click', '#editar_produto_orcamento', function () {
    var inputs = JSON.stringify(jQuery('#tabela_itens_inclusos > tbody > .active').find('input').serializeArray());
    //novo_modal('corpo','editar_produto','900','600', '9100', '9000', 'produtos/buscar/tipo/janela/div/modal');
    //alert(inputs);
    ajax_parametros('produtos/buscar/tipo/janela/div/editar_produto/json/'+inputs, '#corpo', '', '', 'get', 'html');
});
$(document).on('click', '#busca_cliente_orcamento', function (){
    //novo_modal('corpo','buscar_cliente','1600','600', '9100', '9000', 'clientes/buscar/tipo/pesquisa/div/buscar_cliente');
    ajax_parametros('clientes/buscar/tipo/pesquisa/div/buscar_cliente','#corpo', '', '', 'get', 'html');
});
$(document).on('change', '#id_cliente', function () {
    var url="clientes/buscar/tipo/blur/json/";
    var div="#retorno_cliente_blur";
    var dados = $("#id_cliente").val();
    ajax_parametros(url+dados, div, '', '');
    $("#contato_cliente").focus();
});
$(document).on('click', '#busca_plano', function (){
    //novo_modal('corpo','buscar_plano','1600','600', '9100', '9000', 'planos/buscar/tipo/pesquisa/div/buscar_plano');
    ajax_parametros('planos/buscar/tipo/pesquisa/div/buscar_plano','#corpo', '', '', 'get', 'html');
});
$(document).on('change', '#id_plano_pagamento', function () {
    var url="planos/buscar/tipo/blur/json/";
    var div="#retorno_plano_blur";
    var dados = $("#id_plano_pagamento").val();
    ajax_parametros(url+dados, div, '', '');  
    $("#obs_pedido").focus();
});
$(document).on('change', '#tipo_produto', function () {
    mudaTipoProduto('cadastro');
});
$(document).on('click', '#busca_produto_id', function (){
    ajax_parametros('produtos/buscar/tipo/pesquisa/div/buscar_produto','#busca_modal', '', '', 'get', 'html');
});
$(document).on('click', '#busca_produto_referencia', function (){
    ajax_parametros('produtos/buscar/tipo/pesquisa/div/buscar_produto','#busca_modal', '', '', 'get', 'html');
});

$(document).on('change', '#id_produto', function () {
    var url="produtos/buscar/tipo/blur/json/";
    var div="#retorno_produto_blur";
    var dados = $("#id_produto").val();
    ajax_parametros(url+dados, div, '', '');
    $("#preco_unit_produto").focus();
});
$(document).on('change', '#referencia_produto',function () {
    var url="produtos/buscar/tipo/blurref/json/";
    var div="#retorno_produto_blur";
    var dados = $("#referencia_produto").val();
    ajax_parametros(url+dados, div, '', '');  
    $("#preco_unit_produto").focus();
});
$(document).on('change', '#preco_unit_produto', function(){
    calcula_total();
});
$(document).on('change', '#qt_produto',function(){
    calcula_total();
});
$(document).on('change', '#percentual_desconto_produto', function(){
    percentual_desconto();
});
$(document).on('change', '#valor_desconto_produto', function(){
    valor_desconto();
});
$(document).on("click", "#tabela_itens_inclusos > tbody > tr", function () {
        $('#tabela_itens_inclusos > tbody > .active').removeClass('active');
        $(this).addClass("active");
        $('#excluir_produto_orcamento').removeClass('disabled');
        $('#editar_produto_orcamento').removeClass('disabled');
        $('#excluir_produto_orcamento').attr("disabled", false);
        $('#editar_produto_orcamento').attr("disabled", false);
        $(this).find('td').each(function(index, value) {
        });
});
$(document).on("click", "#excluir_produto_orcamento", function () {
    if($('#tabela_itens_inclusos > tbody > .active > td').length != 0)
    {
        decisao = confirm("Deseja Mesmo excluir este item?");
        if (decisao)
        {
            $("#tabela_itens_inclusos > tbody > .active").find('input').each(function(index, value) {
                if(index===12){
                    //alert(value.value+" - "+index);
                    //alert(($('#total_orcamento').val()*1)+" - "+(value.value*1));
                    var novo_total_orcamento = (($('#total_orcamento').val()*1)-(value.value*1));
                    $('#total_orcamento').val((novo_total_orcamento*1).toFixed(2));
                }
            });           
            $('#tabela_itens_inclusos > tbody > .active > td').remove();
            $('#tabela_itens_inclusos > tbody > tr').removeClass('active');
            $('#excluir_produto_orcamento').addClass('disabled');
            $('#editar_produto_orcamento').addClass('disabled');
            $('#excluir_produto_orcamento').attr("disabled", true);
            $('#editar_produto_orcamento').attr("disabled", true);
        }
        else 
        {
                return false;
        } 
    }
    
});
$(document).on("click", "#fechar_modal", function(){
   var divmodal = ($(this).attr("modal")); 
   $("#"+divmodal).modal('hide');
});
$('#buscar_cliente').on('show', function () {
   $('input:text:visible:first').focus();
});

$('body').on('shown.bs.modal', '#buscar_cliente', function () {
    $('#nome_cliente_div', this).focus();
});
$('body').on('shown.bs.modal', '#incluir_produto', function () {
    $('#id_produto', this).focus();
});
$('#busca_modal').on('shown.bs.modal', '#buscar_produto', function () {
    $('#referencia', this).focus();
});
$('body').on('shown.bs.modal', '#editar_produto', function () {
    $('#qt_produto', this).focus();
});
$('body').on('shown.bs.modal', '#incluir_produto_resposta', function () {
    $('#id_produto_resposta', this).focus();
});
$(document).on("click", "#gravar_orcamento", function () {
    $("#data_orcamento").removeClass("disabled");
    $("#data_orcamento").attr("disabled", false);
    $("#data_orcamento").attr("readonly", false);
    var produtos = false;
    if($("#tabela_itens_inclusos > tbody > tr > td").length == 0)
    {
        alert("Não há produtos cadastrados!");
    }
    else
    {
        $("#gravar_orcamento").attr("type","submit");
    }
    //$("#gravar_orcamento").attr("type","submit");
    //$("#form_orcamento").validate();
    //$("#form_orcamento").submit();
});
$(document).on('click', '#editar_orcamento', function () {
    $(".active").find('td').each(function(index, value) {
           if(index===2){
               chama_nj('orcamento/editar/'+value.innerHTML,capta_width(),captaheight());
           }
        });
});
$(document).on('click', '#responder_orcamento', function () {
    $(".active").find('td').each(function(index, value) {
           if(index===2){
               chama_nj('responder/'+value.innerHTML,capta_width(),captaheight());
           }
        });
});
$(document).on('click', '#incluir_resposta_produto', function () {
    var inputs = JSON.stringify(jQuery('#tabela_itens_inclusos > tbody > .active').find('input').serializeArray());
    ajax_parametros('produtos/buscar/tipo/janela/div/incluir_produto_resposta/json/'+inputs, '#corpo', '', '', 'get', 'html');
});
$(document).on('click', '#duplicar_dados', function () {
    $("#id_produto_resposta").val($("#id_produto").val());
    $("#referencia_produto_resposta").val($("#referencia_produto").val());
    $("#descricao_produto_resposta").val($("#descricao_produto").val());
    $("#marca_produto_resposta").val($("#marca_produto").val());
    $("#qt_produto_resposta").val($("#qt_produto").val());
    $("#un_produto_resposta").val($("#un_produto").val());
    $("#preco_lista_produto_resposta").focus();
    
    
});
$(document).on('click', '#cadastrar_categorias', function () {
    var checkbox = $('input:checkbox[name^=checkbox_categorie]:checked');
    //alert("oi"+checkbox.length);
    if(checkbox.length==0)
    {
        alert("Nenhuma categoria selecionada"); //Ver no console
    }
    else
    {
        $(':checkbox').each(function() {
            if(this.checked == true)
            {
                $("#id_categorie_"+this.value).attr("disabled", false);
                $("#descricao_categorie_"+this.value).attr("disabled", false);
                //alert("#descricao_categorie_"+this.value);
            };                        
        });
        $("#cadastrar_categorias").attr("type","submit");
        $("#cadastrar_categorias").validate();
        $("#cadastrar_categorias").submit();
    }
});

$(document).on('click', '#cadastrar_sub_categorias', function () {
    var nivel = $(this).attr('nivel');
    var checkbox = $('input:checkbox[name^=checkbox_categorie]:checked');
    if(checkbox.length==0)
    {
        alert("Nenhuma categoria selecionada"); //Ver no console
    }
    else
    {
        $(':checkbox').each(function() 
        {
            if(this.checked == true)
            {
                //alert("oi - "+checkbox.length);
                //alert("#id_categorie_"+nivel);
                $("#id_categorie_"+this.value).attr("disabled", false);
                $("#descricao_categorie_"+this.value).attr("disabled", false);
                //alert("#descricao_categorie_"+this.value);
            };                        
        });
        $("#cadastrar_sub_categorias").attr("type","submit");
        $("#cadastrar_sub_categorias").validate();
        $("#cadastrar_sub_categorias").submit();
    }
});

$(document).on('click', '.verificar_categoria', function () {
    var nivel = $(this).attr('nivel');
    //alert(nivel);
    var newnivel = (nivel*1)+1;
    
    if(($("#div_nivel"+newnivel).length) > 0)
    {
        for(var i=newnivel;i<15;i++)
        {
            $("#div_nivel"+i).remove();
        }
        $("#categorias").append("<div id='div_nivel"+newnivel+"' name='div_nivel"+newnivel+"' class='col-sm-3' ></div>");
    }
    else(($("#div_nivel"+newnivel).length) == 0)
    {
        for(var i=newnivel;i<15;i++)
        {
            $("#div_nivel"+i).remove();
        }
        $("#categorias").append("<div id='div_nivel"+newnivel+"' name='div_nivel"+newnivel+"' class='col-sm-3' ></div>");
    }
    ajax_parametros('MeliCategories/'+this.id+'/nivel/'+nivel,"#div_nivel"+newnivel, '', 'add', 'get', 'html');

});

$(document).on('click', '.verificar_categoria_sistema', function () {
    var nivel = $(this).attr('nivel');
    //alert(nivel);
    var newnivel = (nivel*1)+1;
    
    if(($("#div_nivel"+newnivel).length) > 0)
    {
        for(var i=newnivel;i<15;i++)
        {
            $("#div_nivel"+i).remove();
        }
        $("#categorias_sistema").append("<div id='div_nivel"+newnivel+"' name='div_nivel"+newnivel+"' class='col-sm-3' ></div>");
    }
    else(($("#div_nivel"+newnivel).length) == 0)
    {
        for(var i=newnivel;i<15;i++)
        {
            $("#div_nivel"+i).remove();
        }
        $("#categorias_sistema").append("<div id='div_nivel"+newnivel+"' name='div_nivel"+newnivel+"' class='col-sm-3' ></div>");
    }
    ajax_parametros('MeliCategories/sistema/'+this.id+'/nivel/'+nivel,"#div_nivel"+newnivel, '', 'add', 'get', 'html');

});

$(document).on('click', '.exibir_arvore', function () {
    var nivel = $(this).attr('nivel');
    //alert(nivel);
    var newnivel = (nivel*1)+1;
    
    if(($("#div_nivel"+newnivel).length) > 0)
    {
        for(var i=newnivel;i<15;i++)
        {
            $("#div_nivel"+i).remove();
        }
        $("#categorias_arvore").append("<div id='div_nivel"+newnivel+"' name='div_nivel"+newnivel+"' class='col-sm-3' ></div>");
    }
    else(($("#div_nivel"+newnivel).length) == 0)
    {
        for(var i=newnivel;i<15;i++)
        {
            $("#div_nivel"+i).remove();
        }
        $("#categorias_arvore").append("<div id='div_nivel"+newnivel+"' name='div_nivel"+newnivel+"' class='col-sm-3' ></div>");
    }
    ajax_parametros('MeliCategories/arvore/'+this.id+'/nivel/'+nivel,"#div_nivel"+newnivel, '', 'add', 'get', 'html');

});

$(document).on('click', '.close', function () {
    $( "div" ).remove( ".alert" ); 
});



