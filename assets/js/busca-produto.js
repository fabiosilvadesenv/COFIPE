function limpa_formulario() {
		//Limpa valores do formulário de cep.
		document.getElementById('codigodetalhe').value=("");
		document.getElementById('codigobarras').value=("");
		document.getElementById('nomeproduto').value=("");
		document.getElementById('grauesferico').value=("");
		document.getElementById('graucilindrico').value=("");
		document.getElementById('eixo').value=("");
		document.getElementById('curvabase').value=("");
		document.getElementById('indexrefracao').value=("");
		document.getElementById('diametro').value=("");
		document.getElementById('cor').value=("");
		document.getElementById('quantidade').value=("");
		document.getElementById('valor').value=("");
		document.getElementById('vencimento').value=("");
		
		$("#codigobarras").focus();
}

function meu_callback(conteudo) {
	
	if (!("erro" in conteudo)) {
		//Atualiza os campos com os valores.
		document.getElementById('codigodetalhe').value=(conteudo.codigodetalhe);
		document.getElementById('codigobarras').value=(conteudo.codigobarras);
		document.getElementById('nomeproduto').value=(conteudo.nomeproduto);
		document.getElementById('grauesferico').value=(conteudo.grauesferico);
		document.getElementById('graucilindrico').value=(conteudo.graucilindrico);
		document.getElementById('eixo').value=(conteudo.eixo);
		document.getElementById('curvabase').value=(conteudo.curvabase);
		document.getElementById('indexrefracao').value=(conteudo.indexrefracao);
		document.getElementById('diametro').value=(conteudo.diametro);
		document.getElementById('cor').value=(conteudo.cor);
		document.getElementById('quantidade').value=("");
		document.getElementById('valor').value=("");
		document.getElementById('vencimento').value=("");
		$("#quantidade").focus();
	} //end if.
	else {
		//produto não Encontrado.
		limpa_formulario();
		$.Notification.autoHideNotify('black', 'top center', 'Fecha em 5 seconds...','Produto não encontrado!');
	}
}
	
function buscarproduto(valor) {
	
	//Verifica se campo cep possui valor informado.
	if (valor != "") {

		//Preenche os campos com "..." enquanto consulta webservice.
		document.getElementById('codigodetalhe').value=("");
		document.getElementById('codigobarras').value="...";
		document.getElementById('nomeproduto').value="...";
		document.getElementById('grauesferico').value="...";
		document.getElementById('graucilindrico').value="...";
		document.getElementById('eixo').value="...";
		document.getElementById('curvabase').value="...";
		document.getElementById('indexrefracao').value="...";
		document.getElementById('diametro').value="...";
		document.getElementById('cor').value="...";
		document.getElementById('quantidade').value=("...");
		document.getElementById('valor').value=("...");
		document.getElementById('vencimento').value=("...");

		//Cria um elemento javascript.
		var script = document.createElement('script');

		//Sincroniza com o callback.
		script.src = 'jsonProdutoDetalhe.php?/ws/callback=meu_callback&prd='+valor;

		//Insere script no documento e carrega o conteúdo.
		document.body.appendChild(script);
		
	} //end if.
	else {
		//cep sem valor, limpa formulário.
		limpa_formulario();
	}

};