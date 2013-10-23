<div id="cmnet">
	<div style="min-height:40px;padding-left:20px;padding-right:20px;background-color:#e3511c; color: white; background-image: url(http://www.citihoteis.com.br/wp-content/uploads/2013/09/fundo-cmnet.png); background-repeat:repeat-x;">
		<div class="container">

			<form id="form" action="./wp-content/cmnet/step2.php" method="GET" style="margin-top:10px; margin-bottom:0px;">
				<div class="row-fluid show-grid">

					<select id="codHotel" name="CodHotel" class="span2" style="margin-right:26px;" alt="selecione um hotel" onchange="selectHotel()">
					<option selected="selected" alt="escolha o hotel" value="0">escolha o hotel:</option>
				    	<option value="208245">Citi Hotel Residence</option>
				    	<option value="208244">Hotel Central</option>
				    	<option value="208243">BR Palace</option>
					</select>

					<input name="chegada" id="dtchegada" placeholder="data de chegada" type="text" class="span2" style="margin-right:26px;" OnKeyUp="return mascaraData(this);" maxlength="10" onChange="selectDtChegada()">
					<input name="partida" id="dtpartida" placeholder="data de partida" type="text" class="span2" style="margin-right:26px;" onChange="selectDtPartida()">

					<select name="qtdAdultos" id="adultos" placeholder="quantidade de adultos" style="margin-right:26px; width: 90px;" onChange="selectAdultos()">
					<option value="0">adultos:</option>
				    	<option>01</option>
				    	<option>02</option>
				    	<option>03</option>
					</select>

				    <input type="checkbox" name="crianca" id="crianca" value="true" onChange="temCrianca()" />

					<select id="idadeCrianca" name="idadeCrianca" style="width: 100px;">
						<option selected value="false">idade</option>
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

					<input id="btnenviar" class="btn btn-primary" style="margin: 0px 0px 10px 25px;" alt="pesquisar hoteis" type="submit" value="Pesquisar">

<script type="text/javascript">

$(function() {

    $("#form").submit(function() {

        $form = $(this);

        $.fancybox({
                'href': $form.attr("action") + "?" + $form.serialize(),
                'type': 'iframe',
        });

        return false;

    });


});

</script>

				</div>
			</form>
		</div>
	</div>
</div>