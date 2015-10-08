<!DOCTYPE html>
<html>
<head>
	<title>Teste Stormtech</title>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<link href="http://bootswatch.com/flatly/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="jumbotron">
  <div class="container">
    <form method="post" action="">
		<div class="input-group input-group-lg">
		  	<span class="input-group-addon" id="sizing-addon1">1</span>
		  	<input id="primeiroNumero" type="text" class="form-control" placeholder="Primeiro Número" aria-describedby="sizing-addon1">
		</div>
		<div class="input-group input-group-lg">
		  	<span class="input-group-addon" id="sizing-addon2">2</span>
		  	<input id="segundoNumero" type="text" class="form-control" placeholder="Segundo Número" aria-describedby="sizing-addon2">
		</div>
		<div>
			<button id="calcular" class="btn btn-default form-control" type="button">Calcular</button>
		</div>
	</form>
	<br>
	<div id="alertaWarning" style="display: none;" class="alert alert-warning" role="alert">
		<p id="mensagem"></p>
	</div>
	<br>
	<div id="alertaSuccess" style="display: none;" class="alert alert-success" role="alert">
		<p id="msgBackEnd"></p>
	</div>
	<br>
	<div id="alertaError" style="display: none;" class="alert alert-error" role="alert">
		<p id="msgBackEnd"></p>
	</div>
  </div>
</div>
<script type="text/javascript">
	$('#calcular').click(function(){

	  	var primeiroNumero    = $('#primeiroNumero').val();
	  	var segundoNumero     = $('#segundoNumero').val();
	  	if(segundoNumero == 0){
	  	var mensagem = 'O segundo número deve ser maior que 0';
	  	$('#alertaWarning').show();
	    $("#mensagem").text(mensagem);
	  	}else{
	  		var dados_form = {primeiroNumero:primeiroNumero,segundoNumero:segundoNumero};
	  		$.ajax({
		    	type: 'POST',
		    	url:  'processa.php',
				data: {'dados_form' : dados_form},
				success: function(r){
					var mensagem = 'O resultado é '+r;
					var limpaMsg = '';
					$("#mensagem").text(limpaMsg);
					$("#alertaWarning").css("display", "none");
			        $('#alertaSuccess').show();
	    			$("#msgBackEnd").text(mensagem);
					$('#primeiroNumero').val('');
			        $('#segundoNumero').val('');
		        },
		    	error: function(){
		    		$('#alertaError').show();
			        var mensagem = 'Erro ao processar o resultado';
	    			$("#msgError").text(mensagem);
				}
			});
	    }
	});
</script>
</body>
</html>