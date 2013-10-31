<style type="text/css">
#cmnet {margin: 0 auto; background-image: background-color:#e14710; background-image: linear-gradient(to bottom, #f26101, #e14710); background-repeat: no-repeat;
		}
#form-cmnet {width: 1024px; margin: 0 auto; padding-top: 8px;}
</style>

<script type="text/javascript">
<script type="text/javascript">
function temCrianca() {
  if (document.getElementById("crianca").checked) {
    document.getElementById("idadeCrianca").disabled=false;
    document.getElementById("qtdAdultos").value="1";
    document.getElementById("qtdAdultos").disabled=true;
  } else {
    document.getElementById("idadeCrianca").disabled=true;
    document.getElementById("qtdAdultos").disabled=false;
    document.getElementById("idadeCrianca").value="0";
  }
}

function doisAdultos() {
  if (document.getElementById("qtdAdultos").value > 1) {
  	document.getElementById("crianca").checked = false;
    document.getElementById("crianca").disabled=true;
    document.getElementById("sim").style.color="#999";
    document.getElementById("idadeCrianca").disabled=true;
  } else {
    // document.getElementById("crianca").checked = false;
    document.getElementById("crianca").disabled=false;
    document.getElementById("sim").style.color="#000";
    document.getElementById("idadeCrianca").disabled=false;
  }
}

function enviarForm() {
  if (document.getElementById("nomeCliente").value=="") {alert("Por favor, verifique o campo Nome"); return false;}
  if (document.getElementById("sobrenomeCliente").value=="") {alert("Por favor, verifique o campo Sobrenome"); return false;}
  if (document.getElementById("emailCliente").value=="") {alert("Por favor, verifique o campo E-mail"); return false;}
  if (document.getElementById("ddiCliente").value=="") {alert("Por favor, verifique o campo DDI"); return false;}
  if (document.getElementById("dddCliente").value=="") {alert("Por favor, verifique o campo DDD"); return false;}
  if (document.getElementById("foneCliente").value=="") {alert("Por favor, verifique o campo Telefone"); return false;}
  if (document.getElementById("numeroCartao").value=="") {alert("Por favor, verifique o campo Número do cartão"); return false;}
  if (document.getElementById("nomeTitularCartao").value=="") {alert("Por favor, verifique o campo Nome do titular do cartão"); return false;}
  if (document.getElementById("dtValidadeCartao").value=="") {alert("Por favor, verifique o campo Validade"); return false;}
  if (document.getElementById("codSegurancaCartao").value=="") {alert("Por favor, verifique o campo Código de segurança"); return false;}
  document.getElementById("formFinal").submit();
}
</script>

</script>

<div id="cmnet">

	<form id="form-cmnet" action="./wp-content/cmnet/step2.php" method="GET">

			<select id="codHotel" name="CodHotel" class="span2" style="margin-right:15px;" alt="selecione um hotel" onchange="selectHotel()">
			<option selected="selected" alt="escolha o hotel" value="0">escolha o hotel:</option>
		    	<option value="208245">Citi Hotel Residence</option>
		    	<option value="208244">Hotel Central</option>
		    	<option value="208243">BR Palace</option>
			</select>

			<input name="chegada" id="dtchegada" placeholder="data de chegada" type="text" class="span2" style="width: 120px;margin-right:15px;" OnKeyUp="return mascaraData(this);" maxlength="10" onChange="selectDtChegada()">
			<input name="partida" id="dtpartida" placeholder="data de partida" type="text" class="span2" style="width: 120px;margin-right:15px;" onChange="selectDtPartida()">

			<select name="qtdAdultos" id="adultos" placeholder="quantidade de adultos" style="margin-right:15px; width: 90px;" onChange="selectAdultos()">
			<option value="0">adultos:</option>
		    	<option>01</option>
		    	<option>02</option>
			</select>

			<select id="idadeCrianca" name="qtdCrianca" style="width: 80px; margin-right:15px;">
				<option selected value="false">criança</option>
				<option value="0">0</option>
				<option value="1">1</option>
			</select>

			<select id="idadeCrianca" name="idadeCrianca" style="width: 140px;">
				<option selected value="false">idade da criança</option>
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
			</select>

			<input id="btnenviar" class="btn btn-primary" style="margin: 0px 0px 8px 15px;" alt="pesquisar hoteis" type="submit" value="Pesquisar">

			<script type="text/javascript">

			$(function() {

			    $("#form-cmnet").submit(function() {

			        $form = $(this);

			        $.fancybox({
			                'href': $form.attr("action") + "?" + $form.serialize(),
			                'type': 'iframe',
			        });

			        return false;

			    });


			});

			</script>

	</form>

</div>