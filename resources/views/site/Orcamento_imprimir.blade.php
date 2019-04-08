<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Orcamentos</title>
<link href="stilo.css" rel="stylesheet" type="text/css">
<link href="menu_stile.css" rel="stylesheet" type="text/css">
<script src="script.js" type="text/javascript"></script>
<script src="jquery-1.6.2.min.js" type="text/javascript"></script>
<script src="scriptsorcamento.js" type="text/javascript"></script>
<link href="stilo_impressao.css" rel="stylesheet" type="text/css">
</head>
<body>
    @if(isset($orcamentoResposta->tb_orcamento_id_cliente))
    <table border='0' align='center'>
        <tr>
           <td colspan='10' align='center'><font class='cabecalho'>DOCUMENTO AUXILIAR DE VENDA ORCAMENTO Nº {{$orcamento->tb_orcamento_id}}</font></td>
        </tr>
        <tr>
           <td colspan='10' align='center'><font class='cabecalho'>NÃO É DOCUMENTO FISCAL</font></td>
        </tr>
        <tr>
           <td colspan='10' align='center'><font class='cabecalho'>NÃO É VALIDO COMO RECIBO E COMO GARANTIA DE MERCADORIA - NAO COMPROVA PAGAMENTO</font></td>
        </tr>
        <tr>
           <td class='com_borda' colspan='10' align='center'><font class='cabecalho'>{{implode("/",array_reverse(explode("-",$orcamento->tb_orcamento_data)))}}</font></td>
        </tr>
	<tr>
           <td colspan='10' align='center'></td>
        </tr>
	<tr>
           <td align='left' colspan='2' width='60'><font class='dados_cliente'><b>Nome:</b></font></td>
           <td align='left' colspan='4'width='500'><font class='dados_cliente'>{{utf8_encode($cliente[0]->Nome)}}</font></td>
           <td align='left' colspan='2' width='30'><font class='dados_cliente'><b>ID:</b></font></td>
           <td align='left' colspan='2'><font class='dados_cliente'>{{$orcamento->tb_orcamento_id_cliente}}</font></td>
        </tr>
	<tr>
           <td align='left' colspan='2' width='60' ><font class='dados_cliente'><b>Contato:</b></font></td>
           <td align='left' colspan='4'><font class='dados_cliente'>{{$orcamento->tb_orcamento_contato}}</font></td>
           <td align='left' colspan='2' width='30'><font class='dados_cliente'><b>Telefone:</b></font></td>
           <td align='left' colspan='2'><font class='dados_cliente'>{{$orcamento->tb_orcamento_telefone}}</font></td>
        </tr>
	<tr>
           <td class='com_borda' align='left' colspan='2' width='60'><font class='dados_cliente'><b>Endereco:</b></font></td>
           <td class='com_borda' align='left' colspan='2' width='200'><font class='dados_cliente'>{{utf8_encode($cliente[0]->Endereco)}}, {{$cliente[0]->Numero}}</font></td>
           <td class='com_borda' align='left' colspan='1' width='50'><font class='dados_cliente'><b>Bairro:</b></font></td>
           <td class='com_borda' align='left' colspan='1' width='100'><font class='dados_cliente'>{{utf8_encode($cliente[0]->Bairro)}}</font></td>
           <td class='com_borda' align='left' colspan='2'><font class='dados_cliente'><b>Cidade:</b></font></td>
           <td class='com_borda' align='left' colspan='2'><font class='dados_cliente'>{{utf8_encode($cliente[0]->Cidade)}} - {{$cliente[0]->UF}}</font></td>
        </tr>
	<tr>
           <td colspan='10' align='center'><font class='cabecalho_produtos'><b>PRODUTOS</b></font></td>
        </tr>
        <tr>
            <td colspan='10'>
            <fieldset>
                @php $contador=0; @endphp
                @foreach($orcamentoItens as $Item)
                @php $contador++; @endphp
                <legend>Item No {{$contador}}</legend>
                <table align='center' border='0' width='100%'>
                    <tr>
                        <td class='com_borda' align='left' colspan='2' width='70' ><font class='cabecalho_produtos2'><b>REF.</b></font></td>
                        <td class='com_borda' align='left' colspan='3' width='150'><font class='cabecalho_produtos2'><b>DESCRICAO</b></font></td>
                        <td class='com_borda' align='left' colspan='1' width='90'><font class='cabecalho_produtos2'><b>MARCA</b></font></td>
                        <td class='com_borda' align='left' colspan='1' width='40'><font class='cabecalho_produtos2'><b>QT</b></font></td>
                        <td class='com_borda' align='center' colspan='1' width='40'><font class='cabecalho_produtos2'><b>UN</b></font></td>
                        <td class='com_borda' align='left' colspan='1' width='80'><font class='cabecalho_produtos2'><b>UNIT</b></font></td>
                        <td class='com_borda' align='left' colspan='1' width='80'><font class='cabecalho_produtos2'><b>TOTAL</b></font></td>
                        <td class='com_borda' align='left' colspan='1' width='80'><font class='cabecalho_produtos2'><b>PRAZO DE <br>ENTREGA</b></font></td>
                    </tr>
                    <tr>
                        <td align='left' colspan='2' ><font class='dados_produtos'>{{$Item->tb_orcamento_itens_referencia_produto}}</font></td>
                        <td align='left' colspan='3' width='180'><font class='dados_produtos'>{{$Item->tb_orcamento_itens_descricao_produto}}</font></td>
                        <td align='left' colspan='1' width='50'><font class='dados_produtos'>{{$Item->tb_orcamento_itens_marca_produto}}</font></td>
                        <td align='left' colspan='1'><font class='dados_produtos'>{{$Item->tb_orcamento_itens_qt_produto}}</font></td>
                        <td align='center' colspan='1'><font class='dados_produtos'>{{$Item->tb_orcamento_itens_un}}</font></td>
                        <td>&nbsp;</td><td>&nbsp;</td>
                        <td align='left' colspan='1'><font class='dados_produtos'>R$ {{number_format($Item->tb_orcamento_itens_valor_unit_produto,2,",",".")}}</font></td>
                        <td align='left' colspan='1'><font class='dados_produtos'>R$ {{number_format(($Item->tb_orcamento_itens_valor_unit_produto*$Item->tb_orcamento_itens_qt_produto),2,",",".")}}</font></td>
                    </tr>
                    <tr>
                        <td colspan='2' ><sup>||</sup>==></td>
                        <td align='left' colspan='3' width='180'><font class='dados_produtos'>$descricao_resposta</font></td>
                        <td align='left' colspan='1' width='50'><font class='dados_produtos'>$marca_resposta</font></td>
                        <td align='left' colspan='1'><font class='dados_produtos'>$qt_resposta</font></td>
                        <td align='center' colspan='1'><font class='dados_produtos'>PC</font></td>
                        <td align='left' colspan='1'><font class='dados_produtos'>R$ ".number_format($valor_unit_resposta,2,",",".")."</font></td>
                        <td align='left' colspan='1'><font class='dados_produtos'>R$ ".number_format(($valor_total_resposta_produto),2,",",".")."</font></td>
			<td align='center' colspan='1'><font class='dados_produtos'>$prazo_entrega</font></td>
                    </tr>
                </table>
                @endforeach
            </fieldset>
	       </td>
	     </tr>
	     <tr>
           <td class='com_borda' colspan='10' align='center'></td>
         </tr>
	     <tr>
           <td colspan='2' align='left'><font class='rodape_produtos'><b>VENDEDOR:</b></font></td>
	       <td colspan='2' align='left'><font class='rodape_produtos'>$id_vendedor - $nome_vendedor</font></td>
	       <td colspan='1' align='left'><font class='rodape_produtos'>&nbsp;</font></td>
	       <td colspan='3' align='right'><font class='rodape_produtos'><b>Total liquido:</b></font></td>
	       <td colspan='2' align='center'><font class='rodape_produtos'><b>R$ ".number_format($valor_total_resposta,2,",",".")."<b></font></td>
         </tr>
	     <tr>
           <td class='com_borda' colspan='10' align='left'><font class='rodape_produtos'><b>Validade: 15 dias</b></font></td>
         </tr>
	     <tr>
           <td colspan='2' align='left'><font class='rodape_produtos'><b>Obs.:</b></font></td>
	       <td colspan='8' align='left'><font class='rodape_produtos'>Itens sujeitos a disponibilidade de estoque. <br>$obs $obs_resposta</font></td>
         </tr>	
	     <tr>
           <td colspan='10' align='center'><font class='cabecalho_produtos'><b>PARCELAMENTO</b></font></td>
         </tr> 
	     <tr>
           <td colspan='3' align='left'><font class='cabecalho_produtos'><b>Condicao de pagamento:</b></font></td>
	       <td colspan='2' align='left'><font class='dados_produtos'>$plano_descricao</font></td>
         </tr>
	     <tr>
           <td colspan='2' align='left'>&nbsp;</td>
	       <td colspan='1' align='right'><font class='cabecalho_produtos'><b>Parcela</b></font></td>
	       <td colspan='1' align='center'><font class='cabecalho_produtos'><b>Dias</b></font></td>
	       <td colspan='2' align='left'><font class='cabecalho_produtos'><b>Vencimento</b></font></td>
	       <td colspan='1' align='left'><font class='cabecalho_produtos'><b>Valor</b></font></td>
	     </tr>
		       <td colspan='2' align='left'>&nbsp;</td>
	           <td colspan='1' align='right'><font class='dados_cliente'>$nr_parcela</font></td>
    	       <td colspan='1' align='center'><font class='dados_cliente'>$prazo</font></td>
	           <td colspan='2' align='left'><font class='dados_cliente'>$data_pagamento</font></td>		   
	           <td colspan='3' align='left'><font class='dados_cliente'><b>R$ ".number_format(($valor_total_resposta/$plano_numero_parcelas),2,",",".")."</b></font></td>
	         </tr>
	   }
	     <tr>
	       <td colspan='10' align='left'>&nbsp;</td>
         </tr>
	     <tr>
	       <td colspan='10' align='left'>&nbsp;</td>
         </tr>
	     <tr>
           <td colspan='4' align='left'>&nbsp;</td>
	       <td class=' com_borda' colspan='6' align='left'></td>
         </tr>
	     <tr>
           <td colspan='4' align='left'>&nbsp;</td>
	       <td colspan='6' align='center'><font class='dados_cliente'> $nome_cliente</font></td>
         </tr>
       </table>
    @else
    <table border='0' align='center'>
       <tr>
           <td colspan='10' align='center'><font class='cabecalho'>DOCUMENTO AUXILIAR DE VENDA ORCAMENTO Nº {{$orcamento->tb_orcamento_id}}</font></td>
        </tr>
        <tr>
           <td colspan='10' align='center'><font class='cabecalho'>NÃO É DOCUMENTO FISCAL</font></td>
        </tr>
        <tr>
           <td colspan='10' align='center'><font class='cabecalho'>NÃO É VALIDO COMO RECIBO E COMO GARANTIA DE MERCADORIA - NAO COMPROVA PAGAMENTO</font></td>
        </tr>
        <tr>
           <td class='com_borda' colspan='10' align='center'><font class='cabecalho'>{{implode("/",array_reverse(explode("-",$orcamento->tb_orcamento_data)))}}</font></td>
        </tr>
	<tr>
           <td colspan='10' align='center'></td>
        </tr>
	<tr>
           <td align='left' colspan='2' width='60'><font class='dados_cliente'><b>Nome:</b></font></td>
           <td align='left' colspan='4'width='500'><font class='dados_cliente'>{{utf8_encode($cliente[0]->Nome)}}</font></td>
           <td align='left' colspan='2' width='30'><font class='dados_cliente'><b>ID:</b></font></td>
           <td align='left' colspan='2'><font class='dados_cliente'>{{$orcamento->tb_orcamento_id_cliente}}</font></td>
        </tr>
	<tr>
           <td align='left' colspan='2' width='60' ><font class='dados_cliente'><b>Contato:</b></font></td>
           <td align='left' colspan='4'><font class='dados_cliente'>{{$orcamento->tb_orcamento_contato}}</font></td>
           <td align='left' colspan='2' width='30'><font class='dados_cliente'><b>Telefone:</b></font></td>
           <td align='left' colspan='2'><font class='dados_cliente'>{{$orcamento->tb_orcamento_telefone}}</font></td>
        </tr>
	<tr>
           <td class='com_borda' align='left' colspan='2' width='60'><font class='dados_cliente'><b>Endereco:</b></font></td>
           <td class='com_borda' align='left' colspan='2' width='200'><font class='dados_cliente'>{{utf8_encode($cliente[0]->Endereco)}}, {{$cliente[0]->Numero}}</font></td>
           <td class='com_borda' align='left' colspan='1' width='50'><font class='dados_cliente'><b>Bairro:</b></font></td>
           <td class='com_borda' align='left' colspan='1' width='100'><font class='dados_cliente'>{{utf8_encode($cliente[0]->Bairro)}}</font></td>
           <td class='com_borda' align='left' colspan='2'><font class='dados_cliente'><b>Cidade:</b></font></td>
           <td class='com_borda' align='left' colspan='2'><font class='dados_cliente'>{{utf8_encode($cliente[0]->Cidade)}} - {{$cliente[0]->UF}}</font></td>
        </tr>
	<tr>
           <td colspan='10' align='center'><font class='cabecalho_produtos'><b>PRODUTOS</b></font></td>
        </tr>
        <tr>
            <td colspan='10'>
                @php $contador=0; @endphp
                @foreach($orcamentoItens as $Item)
                @php $contador++; @endphp
                <table align='center' border='0' width='100%'>
                    <tr>
                        <td class='com_borda' align='left' colspan='2' width='70' ><font class='cabecalho_produtos2'><b>REF.</b></font></td>
                        <td class='com_borda' align='left' colspan='3' width='150'><font class='cabecalho_produtos2'><b>DESCRICAO</b></font></td>
                        <td class='com_borda' align='left' colspan='1' width='90'><font class='cabecalho_produtos2'><b>MARCA</b></font></td>
                        <td class='com_borda' align='left' colspan='1' width='40'><font class='cabecalho_produtos2'><b>QT</b></font></td>
                        <td class='com_borda' align='center' colspan='1' width='40'><font class='cabecalho_produtos2'><b>UN</b></font></td>
                        <td class='com_borda' align='left' colspan='1' width='80'><font class='cabecalho_produtos2'><b>UNIT</b></font></td>
                        <td class='com_borda' align='left' colspan='1' width='80'><font class='cabecalho_produtos2'><b>TOTAL</b></font></td>
                        <td class='com_borda' align='left' colspan='1' width='80'><font class='cabecalho_produtos2'><b>PRAZO DE <br>ENTREGA</b></font></td>
                    </tr>
                    <tr>
                        <td align='left' colspan='2' ><font class='dados_produtos'>{{$Item->tb_orcamento_itens_referencia_produto}}</font></td>
                        <td align='left' colspan='3' width='180'><font class='dados_produtos'>{{$Item->tb_orcamento_itens_descricao_produto}}</font></td>
                        <td align='left' colspan='1' width='50'><font class='dados_produtos'>{{$Item->tb_orcamento_itens_marca_produto}}</font></td>
                        <td align='left' colspan='1'><font class='dados_produtos'>{{$Item->tb_orcamento_itens_qt_produto}}</font></td>
                        <td align='center' colspan='1'><font class='dados_produtos'>{{$Item->tb_orcamento_itens_un}}</font></td>
                        <td>&nbsp;</td><td>&nbsp;</td>
                        <td align='left' colspan='1'><font class='dados_produtos'>R$ {{number_format($Item->tb_orcamento_itens_valor_unit_produto,2,",",".")}}</font></td>
                        <td align='left' colspan='1'><font class='dados_produtos'>R$ {{number_format(($Item->tb_orcamento_itens_valor_unit_produto*$Item->tb_orcamento_itens_qt_produto),2,",",".")}}</font></td>
                    </tr>
                </table>
                @endforeach
	       </td>
	     </tr>
	     <tr>
           <td class='com_borda' colspan='10' align='center'></td>
        </tr>
	<tr>
            <td colspan='2' align='left'><font class='rodape_produtos'><b>VENDEDOR:</b></font></td>
	    <td colspan='2' align='left'><font class='rodape_produtos'>{{$vendedores[0]->ID}} - {{$vendedores[0]->Nome}}</font></td>
	    <td colspan='1' align='left'><font class='rodape_produtos'>&nbsp;</font></td>
	    <td colspan='3' align='right'><font class='rodape_produtos'><b>Total liquido:</b></font></td>
	    <td colspan='2' align='center'><font class='rodape_produtos'><b>R$ {{number_format($orcamento->tb_orcamento_total_orcamento,2,",",".")}}<b></font></td>
        </tr>
	<tr>
            <td class='com_borda' colspan='10' align='left'><font class='rodape_produtos'><b>Validade: 15 dias</b></font></td>
        </tr>
	<tr>
            <td colspan='2' align='left'><font class='rodape_produtos'><b>Obs.:</b></font></td>
	    <td colspan='8' align='left'><font class='rodape_produtos'>Itens sujeitos a disponibilidade de estoque. <br>$obs</font></td>
        </tr>	
	<tr>
           <td colspan='10' align='center'><font class='cabecalho_produtos'><b>PARCELAMENTO</b></font></td>
        </tr> 
	<tr>
            <td colspan='3' align='left'><font class='cabecalho_produtos'><b>Condicao de pagamento:</b></font></td>
	    <td colspan='2' align='left'><font class='dados_produtos'>$plano_descricao</font></td>
        </tr>
	<tr>
            <td colspan='2' align='left'>&nbsp;</td>
	    <td colspan='1' align='right'><font class='cabecalho_produtos'><b>Parcela</b></font></td>
	    <td colspan='1' align='center'><font class='cabecalho_produtos'><b>Dias</b></font></td>
	    <td colspan='2' align='left'><font class='cabecalho_produtos'><b>Vencimento</b></font></td>
	    <td colspan='1' align='left'><font class='cabecalho_produtos'><b>Valor</b></font></td>
	</tr>
	<tr>
	    <td colspan='2' align='left'>&nbsp;</td>
	    <td colspan='1' align='right'><font class='dados_cliente'>$nr_parcela</font></td>
    	    <td colspan='1' align='center'><font class='dados_cliente'>$prazo</font></td>
	    <td colspan='2' align='left'><font class='dados_cliente'>$data_pagamento</font></td>		   
	    <td colspan='3' align='left'><font class='dados_cliente'><b>R$ ".number_format(($valor_total_resposta/$plano_numero_parcelas),2,",",".")."</b></font></td>
	</tr>
	<tr>
	    <td colspan='10' align='left'>&nbsp;</td>
        </tr>
	<tr>
	    <td colspan='10' align='left'>&nbsp;</td>
        </tr>
	<tr>
            <td colspan='4' align='left'>&nbsp;</td>
	    <td class=' com_borda' colspan='6' align='left'></td>
        </tr>
	<tr>
            <td colspan='4' align='left'>&nbsp;</td>
	    <td colspan='6' align='center'><font class='dados_cliente'> $nome_cliente</font></td>
        </tr>
    </table>
    @endif
</body>
</html>