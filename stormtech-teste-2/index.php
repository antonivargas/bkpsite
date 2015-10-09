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
		  	<input id="texto" type="text" class="form-control" placeholder="Digite a string de teste" aria-describedby="sizing-addon1">
		</div>
		<div>
			<button id="analisar" class="btn btn-default form-control" type="button">ANALISAR STRING</button>
		</div>
	</form>
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
	$('#analisar').click(function(){

	  	var texto    = $('#texto').val();
  		var dados_form = {texto:texto};
  		$.ajax({
	    	type: 'POST',
	    	url:  'processa.php',
			data: {'dados_form' : dados_form},
			success: function(response){
				var mensagem = 'O primeiro caractere de ocorrência única é a'+response;
		        $('#alertaSuccess').show();
    			$("#msgBackEnd").text(mensagem);
				$('#texto').val('');
	        },
	    	error: function(){
	    		$('#alertaError').show();
		        var mensagem = 'Erro ao analisar a string';
    			$("#msgError").text(mensagem);
			}
		});

	});
</script>
</body>
</html>