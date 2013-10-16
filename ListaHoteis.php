<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Citi Hoteis - Listagem dos Hoteis</title>
        <script language="JavaScript" type="text/javascript" src="MascaraValidacao.js"></script> 
		<!-- início dos links -->
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<!-- início dos scripts -->
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
        <script type="text/javascript">
        
        function continuarPasso2(){
            document.getElementById("passo1").style.display="none";
            document.getElementById("passo2").style.display="";
       

        }

        function continuarPasso3(){
            document.getElementById("passo2").style.display="none";
            document.getElementById("passo3").style.display="";
            

        }

        function voltarPasso1(){
            document.getElementById("passo2").style.display="none";
            document.getElementById("passo1").style.display="";   
        }

        function c(id){
        /* *
        * Função transforma as primeiras letras de cada palavra digitada em Maiúscula e o restante em Minúscula
        * @Tiago Araujo Silva
        * @version 1.00 2007/3/3
        */
        var palavras=document.getElementById(id).value;
        palavras=palavras.split("");
        var tmp="";
        for(i=0;i<palavras.length;i++){
            if(palavras[i-1]){
                if(palavras[i-1]==" "){palavras[i]=palavras[i].replace(palavras[i],palavras[i].toUpperCase());}
                else{palavras[i]=palavras[i].replace(palavras[i],palavras[i].toLowerCase());}
            }
            else{palavras[i]=palavras[i].replace(palavras[i],palavras[i].toUpperCase());}
            tmp+=palavras[i];
        }
        document.getElementById(id).value=tmp;
        }

        /* Máscaras ER */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}

function mdocumento(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
    return v;
}

function memail()
{
  var obj = eval("document.forms[0].emailCliente");
  var txt = obj.value;
  if ((txt.length != 0) && ((txt.indexOf("@") < 1) || (txt.indexOf('.') < 7)))
  {
    alert('Por favor, digite um e-mail válido');
    obj.focus();
  }
}

function mdata(v)
{
  v=v.replace(/\D/g,"");
  if(v.value.length=="2"){
    v += "/";
  }
  return v;
}

function ValidaSemPreenchimento(form){
var completo = true;
for (i=0;i<form.length;i++){
var obg = form[i].obrigatorio;
if (obg==1){
if (form[i].value == ""){
var nome = form[i].name
completo = false;
form[i].focus();

}
}
}
if (completo) { document.dois.submit(); } else {  document.dois.submit();alert("Preencha todos os campos!"); }
}

// function nomeOk() {
//   if (document.getElementById("nomeCliente").value != "" && document.getElementById("sobrenomeCliente").value != "") {
//     document.getElementById("documento").disabled=false;
//     document.getElementById("s_documento").disabled=false;
//   } else {
//     document.getElementById("bandeiraCartao").disabled=true;
//     document.getElementById("numeroCartao").disabled=true;
//     document.getElementById("nomeTitularCartao").disabled=true;
//     document.getElementById("dtValidadeCartao").disabled=true;
//     document.getElementById("codSegurancaCartao").disabled=true;
//     document.getElementById("documento").disabled=true;
//     document.getElementById("s_documento").disabled=true;
//     document.getElementById("celularCliente").disabled=true;
//     document.getElementById("ddicelularCliente").disabled=true;
//     document.getElementById("dddcelularCliente").disabled=true;
//     document.getElementById("emailCliente").disabled=true;
//     document.getElementById("agree").disabled=true;
//     document.getElementById("confirmar").disabled=true;
//   }
// }

// function documentoOk() {
//   if (document.getElementById("documento").value != "" && document.getElementById("documento").value.length > 5) {
//     document.getElementById("celularCliente").disabled=false;
//     document.getElementById("ddicelularCliente").disabled=false;
//     document.getElementById("dddcelularCliente").disabled=false;
//   } else {
//     document.getElementById("bandeiraCartao").disabled=true;
//     document.getElementById("numeroCartao").disabled=true;
//     document.getElementById("nomeTitularCartao").disabled=true;
//     document.getElementById("dtValidadeCartao").disabled=true;
//     document.getElementById("codSegurancaCartao").disabled=true;
//     document.getElementById("celularCliente").disabled=true;
//     document.getElementById("ddicelularCliente").disabled=true;
//     document.getElementById("dddcelularCliente").disabled=true;
//     document.getElementById("emailCliente").disabled=true;
//     document.getElementById("agree").disabled=true;
//     document.getElementById("confirmar").disabled=true;
//   }
// }

// function celularOk() {
//   if (document.getElementById("ddicelularCliente").value != "" && document.getElementById("dddcelularCliente").value != "" && document.getElementById("celularCliente").value != "" && document.getElementById("celularCliente").value.length > 7) {
//     document.getElementById("emailCliente").disabled=false;
//   } else {
//     document.getElementById("bandeiraCartao").disabled=true;
//     document.getElementById("numeroCartao").disabled=true;
//     document.getElementById("nomeTitularCartao").disabled=true;
//     document.getElementById("dtValidadeCartao").disabled=true;
//     document.getElementById("codSegurancaCartao").disabled=true;
//     document.getElementById("emailCliente").disabled=true;
//     document.getElementById("agree").disabled=true;
//     document.getElementById("confirmar").disabled=true;
//   }
// }

// function emailOk() {
//   if (document.getElementById("emailCliente").value != "") {
//     document.getElementById("bandeiraCartao").disabled=false;
//   } else {
//     document.getElementById("bandeiraCartao").disabled=true;
//     document.getElementById("numeroCartao").disabled=true;
//     document.getElementById("nomeTitularCartao").disabled=true;
//     document.getElementById("dtValidadeCartao").disabled=true;
//     document.getElementById("codSegurancaCartao").disabled=true;
//     document.getElementById("agree").disabled=true;
//     document.getElementById("confirmar").disabled=true;
//   }
// }

// function bandeiraCartaoOk() {
//   if (document.getElementById("bandeiraCartao").value != "0") {
//     document.getElementById("numeroCartao").disabled=false;
//   } else {
//     document.getElementById("numeroCartao").disabled=true;
//     document.getElementById("nomeTitularCartao").disabled=true;
//     document.getElementById("dtValidadeCartao").disabled=true;
//     document.getElementById("codSegurancaCartao").disabled=true;
//     document.getElementById("agree").disabled=true;
//     document.getElementById("confirmar").disabled=true;
//   }
// }

// function numeroCartaoOk() {
//   if (document.getElementById("emailCliente").value != "") {
//     document.getElementById("nomeTitularCartao").disabled=false;
//   } else {
//     document.getElementById("agree").disabled=true;
//     document.getElementById("confirmar").disabled=true;
//   }
// }

// function nomeTitularCartaoOk() {
//   if (document.getElementById("nomeTitularCartao").value != "") {
//     document.getElementById("dtValidadeCartao").disabled=false;
//   } else {
//     document.getElementById("agree").disabled=true;
//     document.getElementById("confirmar").disabled=true;
//   }
// }

// function dtValidadeCartaoOk() {
//   if (document.getElementById("dtValidadeCartao").value != "") {
//     document.getElementById("codSegurancaCartao").disabled=false;
//   } else {
//     document.getElementById("agree").disabled=true;
//     document.getElementById("confirmar").disabled=true;
//   }
// }

// function codSegurancaCartaoOk() {
//   if (document.getElementById("codSegurancaCartao").value != "") {
//     document.getElementById("agree").disabled=false;
//   } else {
//     document.getElementById("agree").disabled=true;
//     document.getElementById("confirmar").disabled=true;
//   }
// }

// function agreeOk() {
//   if (document.getElementById("agree").checked) {
//     document.getElementById("confirmar").disabled=false;
//   } else {
//     document.getElementById("confirmar").disabled=true;
//   }
// }

</script>
	</head>
	<body>

    <?php
        require_once 'bootstrap.php';

        use Cmnet\ValueObject\Reservation\HotelSearchCriteria;
        use Cmnet\ValueObject\RequestorIdentification;
        use Cmnet\ValueObject\Reservation\GuestCount;
        use Cmnet\ValueObject\Reservation\GuestList;
        use Cmnet\ValueObject\Payment\DirectBill;
        use Cmnet\Service\CmnetAuthHeader;
        use Cmnet\Util\DateTimeInterval;
        use Cmnet\Service\CmnetService;
        use Cmnet\ValueObject\Money;


        $codHotel = (int)$_GET["CodHotel"];

        function data($d){

           $array = explode('/', $d);

           $dia = $array[0];
           $mes = $array[1];
           $ano= $array[2];

           $data ='';
           $data.=$dia;
           $data.='-';
           $data.=$mes;
           $data.='-';
           $data.=$ano;
           
           // $data ='';
           // $data .=$ano;
           // $data.='-';
           // $data.=$mes;
           // $data.='-';
           // $data.=$dia;
           
           return $data;
        }

        $chegada =data($_GET["chegada"]);
        $partida =data($_GET["partida"]);

        $adulto = (int)$_GET["qtdAdultos"];
        $idadeCrianca = (int)$_GET["idadeCrianca"];

        if (isset($_GET['crianca'])) {
          $hospedes = array(new GuestCount(1), new GuestCount(1, 8, $idadeCrianca));
          $qtdHospedes = 2;
          $temCrianca = "true";
          // echo "tem criança. idade= ".$idadeCrianca;
        } else {
          $hospedes = array(new GuestCount($adulto));
          $qtdHospedes = $adulto;
          $temCrianca = "false";
          // echo "nao tem criança";
        }

        try {
            $autenticacao = new CmnetAuthHeader('PACITIH', 'PACITIH', 476283);
            $requestorId = new RequestorIdentification(
                //208244,
                $codHotel,
                RequestorIdentification::PARCEIRO,
                'http://www.citihoteis.com.br'
            );

            // Conectando em produção:
            $service = new CmnetService($autenticacao);

            // Conectando em desenvolvimento:
            //$service = new CmnetService($autenticacao, CmnetService::DESENVOLVIMENTO);

            date_default_timezone_set('America/Sao_Paulo');

            $xml = $service->consultaDisponibilidadeHotel(
                    '1234',
                    $requestorId,
                    new DateTimeInterval(new DateTime($chegada), new DateTime($partida)),
                    new GuestList($hospedes),
                                  // array(new GuestCount(1))),
                    //new HotelSearchCriteria(null, '208245')
                    new HotelSearchCriteria($codHotel,null)
                );

            //var_dump($xml);


        
            //echo $xml->attributes()->Version;
            
            //echo $xml->RoomStays->RoomStay->RoomTypes->RoomType->attributes()->NumberOfUnits;
            //echo $xml->RoomStays->RoomStay->RoomTypes->RoomType->attributes()->RoomTypeCode;

            $warning = $xml->Warnings->Warning;
           
            if($warning!="") {

                echo "<center><h3 style='margin-top: 30px;'>".$warning."</center>";
                $isDisponivel = false;
                }

            else{

               $isDisponivel = true;
               $titulo = $xml->RoomStays->RoomStay->BasicPropertyInfo->attributes()->HotelName;
               $endereco = $xml->RoomStays->RoomStay->BasicPropertyInfo->Address->AddressLine[0];
               $imagem = $xml->RoomStays->RoomStay->BasicPropertyInfo->VendorMessages->VendorMessage->SubSection->Paragraph->URL;
               $apartamento = $xml->RoomStays->RoomStay->RoomTypes->RoomType->RoomDescription->Text;
               $descApartamento = $xml->RoomStays->RoomStay->RoomTypes->RoomType->AdditionalDetails->AdditionalDetail[0]->DetailDescription->Text;
               $codQuarto = $xml->RoomStays->RoomStay->RoomRates->RoomRate->attributes()->RoomTypeCode;
               $valorDiaria = $xml->RoomStays->RoomStay->RoomRates->RoomRate->Rates->Rate[0]->Base->attributes()->AmountBeforeTax;
               $totalDiaria= $xml->RoomStays->RoomStay->RoomRates->RoomRate->Rates->Rate[0]->Total->attributes()->AmountAfterTax;
            };                


        } catch (Exception $error) {
            echo $error;
        }

?>
<?php if ($isDisponivel) {?>

<div class="container" style="height: 700px;">
 <form name="dois"  method="POST" action="finalizar.php" onSubmit="return ValidaSemPreenchimento(this);" $codHotel>
    <!-- Passo 1 -->

    <div id="passo1" style="padding-top: 40px;">
      <div class="row-fluid show-grid">
        <div class="span2"><img src=<?php echo $imagem; ?> alt="imagem-hotel" class="img-polaroid"></div>
        <div class="span4">
          <h2><?php echo $titulo; ?></h2>
          <p><?php echo $endereco; ?></p>
        </div>
      </div>
      <table class="table table-striped table-hover">

            <thead>
              <tr>
                <th class="span10">NOME DO APARTAMENTO</th>
                <th>QUANT. HÓSPEDES</th>
                <th>VALOR DIÁRIA</th>
                <th>VALOR TOTAL</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo $apartamento; echo "<br>"; echo $descApartamento; ?></td>
                <td><?php echo $qtdHospedes ?></td>
                <td>R$ <?php echo $valorDiaria ?></td>
                <td>R$ <?php echo $totalDiaria ?></td>
              </tr>
            </tbody>
            
      </table>
        <button class="btn btn-large btn-success pull-right" type="button" onclick="continuarPasso2();" style="margin-top: 194px;">Continuar a reserva</button>
    </div>

    <?php } ?>


    <!-- Passo 2 -->
  
        <div id="passo2" style="display: none;">
            <h2>02. DADOS DA RESERVA</h2>
            <span>Para concluir a reserva, é necessário preencher alguns dados e aceitar o termo de Políticas e Restições.</p>
                <hr>
            <div class="row-fluid show-grid">
            </div>
            <div class="row-fluid show-grid">
                
                <div >

                    <! -- alteraçao para passagem de valores -->

                    <input type="hidden" name="codHotel" value=<?php echo $codHotel ?> />
                    <input type="hidden" name="partida" value=<?php echo $partida ?> />
                    <input type="hidden" name="chegada" value=<?php echo $chegada ?> />
                    <input type="hidden" name="diaria" value=<?php echo $valorDiaria ?> />
                    <input type="hidden" name="totalDiaria" value=<?php echo $totalDiaria ?> />
                    <input type="hidden" name="codQuarto" value=<?php echo $codQuarto ?> />
                    <input type="hidden" name="temCrianca" value=<?php echo $temCrianca ?> />
                    <input type="hidden" name="idadeCrianca" value=<?php echo $idadeCrianca ?> />
                    <input type="hidden" name="qtdHospedes" value=<?php echo $qtdHospedes ?> />

                    <table style="width: 100%;">
                      <tr><td>

                    <input type="text" name="nomeCliente" id="nomeCliente" class="span3 nome" placeholder="Nome" onkeyup="c('nomeCliente')" onkeydown="nomeOk()" onchange="nomeOk()" required style="width: 150px;">&nbsp;
                    <input type="text" name="sobrenomeCliente" id="sobrenomeCliente" class="span3 sobrenome" placeholder="Sobrenome" onkeyup="c('sobrenomeCliente')" onkeydown="nomeOk()" onchange="nomeOk()" required style="width: 150px;">
                  </td>
                  <td>
                    <input id="documento" type="text" class="span3" placeholder="Documento" onkeyup="mascara( this, mdocumento );" maxlength="11" onkeydown="documentoOk()" onchange="documentoOk()" required  style="width: 140px;">&nbsp;
                    <select name="s_documento" id="s_documento" class="span3"  style="width: 70px;">
                      <option name="documento" value="cpf">CPF</option>
                      <option name="documento" value="rg">RG</option>
                    </select>
                  </td>
                  </tr><tr><td>

                    <!-- <input type="text" name="celularCliente" class="span3" placeholder="Telefone" onkeyup="mascara( this, mtel );" maxlength="14" required>&nbsp; -->
                    <input type="text" name="ddicelularCliente" id="ddicelularCliente" placeholder="DDI" onkeydown="celularOk()" onchange="celularOk()" onkeyup="mascara( this, mdocumento );" maxlength="2"  style="width: 30px;"> 
                    <input type="text" name="dddcelularCliente" id="dddcelularCliente" placeholder="DDD" onkeydown="celularOk()" onchange="celularOk()" onkeyup="mascara( this, mdocumento );" maxlength="2"  style="width: 30px;"> 
                    <input type="text" name="celularCliente" id="celularCliente" class="span3" placeholder="Telefone" onkeydown="celularOk()" onchange="celularOk()" onkeyup="mascara( this, mdocumento );" maxlength="9"  style="width: 100px;">&nbsp;
                    </td><td>
                    <input type="text" name="emailCliente" id="emailCliente" class="span3" placeholder="Email" id="emailCliente" maxlength="40" onBlur="memail();" onkeydown="emailOk()" onchange="emailOk()"  style="width: 200px;">
                    </td></tr><tr><td>&nbsp;</td></tr>
                    <tr><td>
                      <select name="bandeiraCartao" id="bandeiraCartao" class="span3" style="width: 150px;" onchange="bandeiraCartaoOk()" >
                      <option value="0">Cartão</option>
                      <option value="VI">Visa</option>
                      <option value="MC">Master</option>
                    </select>&nbsp;
                    <input type="text" name="numeroCartao" id="numeroCartao" placeholder="Número" onkeydown="numeroCartaoOk()" onchange="numeroCartaoOk()" onkeyup="mascara( this, mdocumento );" maxlength="17" style="width: 150px;" > &nbsp;
                    <input type="text" name="nomeTitularCartao" id="nomeTitularCartao" placeholder="Nome do titular" onkeyup="c('nomeCliente')" onkeydown="nomeTitularCartaoOk()" onchange="nomeTitularCartaoOk()" style="width: 200px;" ><br>
                    <input type="text" name="dtValidadeCartao" id="dtValidadeCartao" placeholder="Data de validade (mm/aa)" onkeyup="mascara( this, mdata );" onkeydown="dtValidadeCartaoOk()" onchange="dtValidadeCartaoOk()" maxlength="5" style="width: 180px;" > &nbsp;
                    <input type="text" name="codSegurancaCartao" id="codSegurancaCartao" placeholder="Código de segurança" onkeydown="codSegurancaCartaoOk()" onchange="codSegurancaCartaoOk()" onkeyup="mascara( this, mdocumento );" maxlength="3" style="width: 140px;" > 
                    </td>


                    <td>
                      Obs.:<br>
                    <input type="text" name="comentarios" id="comentarios" placeholder="Ex: Cama de casal" style="width: 140px;" > 
                    </td>
                  </tr>
                    <tr><td>
                      
                    </td></tr>
                    </td></tr><tr><td>&nbsp;</td></tr>
                    <tr><td colspan="2">
                <textarea name="politica_restricoes" rows="10" readonly="readonly" style="height:100%;width:98%;resize: none;">
                  Políticas de check-in: 14:00

                      Aplicação do Decreto Lei  nº 6.022 de 22/01/2007 e da Normativa - RFB nº 1.052 de Julho/2010. 
                      Devido às exigências legais , para efetuar o check in em nossos hotéis é necessário que o hóspede preencha de forma obrigatória e legível os seguintes dados da ficha de registro de hospedagem do Hotel:

                      - Nome Completo, RG e CPF ( ou Passaporte no caso de estrangeiros), endereço completo, CEP, telefone com DDD e e-mail pessoal ou profissional . 

                  Políticas de check-out: 12:00
                              
                      Idade para criança:
                      01 CRIANÇA ATÉ 06 ANOS FREE
                      Política de Hospedagem de Menores 
                      Por determinação da Lei Federal nº 8.069, de 13/07/1990, não será permitida a hospedagem de menores de 18 (dezoito) anos, salvo se acompanhados por seus pais ou responsável. Caso o menor esteja acompanhado apenas de seu responsável 
                      será necessário apresentar, no momento do check in, documento de autorização da hospedagem do menor feito por escrito e assinado pelos pais, com firmas reconhecidas em cartório. Independente de qualquer outra disposição todos os menores de 18 (dezoito) anos deverão apresentar, no momento do check in, documento com foto que comprove sua identidade e filiação ainda que acompanhados de seus pais.

                  Políticas de Cancelamento:
                      Aceita cancelamento até 72 Horas antes da chegada
                      72 HORAS  ANTES DO CHECK IN VIAE-MAIL

                  Políticas de EarlyCheckin e LateCheckout:
                      Política de Garantia:
                      Reservas com garantia de "No Show" ficam confirmadas até às 14h do dia posterior ao dia da entrada, sendo cobrada em caso de não comparecimento  "No Show"  ( * ) da  seguinte forma : 
                      - Baixa Temporada - Será cobrada multa no valor mínimo de 01 (uma) diária exceto 
                      períodos de feriados  prolongados, onde será cobrado  o período integral da reserva. 
                      - Alta Temporada - Será cobrada multa no valor mínimo de 03 (três) diárias. 
                      Exceto períodos especiais de Natal, Réveillon e Carnaval, onde será cobrado o período integral da reserva. 
                      - O prazo para cancelamento sem cobrança de multa é de 48 ( quarenta  e oito horas ) horas antes da data de entrada do hóspede(*). Após a confirmação do depósito de garantia da reserva , e não ocorrendo o cancelamento , não haverá reembolso.
                </textarea>
              </td></tr><tr><td>&nbsp;</td></tr>
              <tr><td colspan="2">
            <label class="checkbox">&nbsp;* <input id="agree" type="checkbox" value="" onChange="agreeOk()" >Confirmo que li e aceito as condições acima.</label>

            </td></tr><tr><td>&nbsp;</td></tr>
            <tr><td colspan="2">
            <button class="btn btn-large btn-inverse pull-left" type="button" onclick="voltarPasso1();">Voltar</button>

            <button id="confirmar" class="btn btn-large btn-success pull-right" type="button" onclick="onclick= ValidaSemPreenchimento(document.forms[0]);" >Confirmar a reserva</button>
            </td></tr></table>
        </div>
    </div>


    
</div>
	</body>
</html>
