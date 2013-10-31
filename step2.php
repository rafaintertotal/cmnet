<html>
<!DOCTYPE html>
<!--[if IE 7 ]> <html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<title>Dados da Reserva</title>
<link rel="stylesheet" media="screen" href="style.css" />

<!-- This is for mobile devices -->
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>

<!-- This makes HTML5 elements work in IE 6-8 -->
<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<!-- início dos links -->
<!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.css"> -->

<!-- Início do CSS -->
<style type="text/css">
@media only screen and (min-device-width: 600px) {
body {height: 670px;}
}
</style>

<!-- Início dos Scripts -->
<script type="text/javascript">
function continuarPasso3(){
  document.getElementById("container-passo2").style.display="none";
  document.getElementById("container-passo3").style.display="";
}

function voltarPasso2(){
  document.getElementById("container-passo3").style.display="none";
  document.getElementById("container-passo2").style.display="";
}

// function submitForm() {
  // if () {
  //   document.getElementById("container-passo2").style.display="none";  
    // document.getElementById("form").submit();
  // }
  // else {document.getElementById("warning").style.display="";}
// }

// function goBack() {
//   alert("oioi");
//   window.history.go(-1);
// }
</script>
</head>
<body>
<?php

//-----------------------------------------------------------------------------------------------------
//-----Importar biblioteca
//-----------------------------------------------------------------------------------------------------

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

//-----------------------------------------------------------------------------------------------------
//-----Receber os parâmetros
//-----------------------------------------------------------------------------------------------------

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
   
   return $data;
}

$chegada =data($_GET["chegada"]);
$partida =data($_GET["partida"]);

$adulto = (int)$_GET["qtdAdultos"];
$idadeCrianca = (int)$_GET["idadeCrianca"];

//-----------------------------------------------------------------------------------------------------
//-----Verificar se há criança
//-----------------------------------------------------------------------------------------------------

if (isset($_GET['crianca'])) {
  $hospedes = array(new GuestCount(1), new GuestCount(1, 8, $idadeCrianca));
  $qtdHospedes = 2;
  $temCrianca = "true";
} else {
  $hospedes = array(new GuestCount($adulto));
  $qtdHospedes = $adulto;
  $temCrianca = "false";
}

// $adulto = 2;
// $qtdHospedes = 3;
// $temCrianca = "true";
// $hospedes = array(new GuestCount(2, ), new GuestCount(1, 8, 1));

//-----------------------------------------------------------------------------------------------------
//-----Definir timezone
//-----------------------------------------------------------------------------------------------------

date_default_timezone_set('America/Sao_Paulo');

//-----------------------------------------------------------------------------------------------------
//-----Iniciar serviço
//-----------------------------------------------------------------------------------------------------

try {

    $autenticacao = new CmnetAuthHeader('PACITIH', 'PACITIH', 476283);
    $requestorId = new RequestorIdentification(
        $codHotel,
        RequestorIdentification::PARCEIRO,
        'http://www.citihoteis.com.br'
    );

    $service = new CmnetService($autenticacao);

//-----------------------------------------------------------------------------------------------------
//-----Gerar XML
//-----------------------------------------------------------------------------------------------------

    // var_dump(

      $xml = $service->consultaDisponibilidadeHotel(
          '1234',
          $requestorId,
          new DateTimeInterval(new DateTime($chegada), new DateTime($partida)),
          new GuestList($hospedes),
          new HotelSearchCriteria($codHotel,null)
      );

    // );

    $warning = $xml->Warnings->Warning;
    $erro = $xml->Errors->Error;
   
    if($erro!="" || $warning!="") {
      echo "<center><h1 style='margin-top: 30px;'>Não foi possível completar a operação</h1><br>".$erro.$warning."</center>";
      break;
      $isDisponivel = false;
    } else {
      // echo "<center><h3 style='margin-top: 30px;'>chegou aqui</center>";
      $isDisponivel = true;
      $titulo = $xml->RoomStays->RoomStay->BasicPropertyInfo->attributes()->HotelName;
      $endereco = $xml->RoomStays->RoomStay->BasicPropertyInfo->Address->AddressLine[0];
      $imagem = $xml->RoomStays->RoomStay->BasicPropertyInfo->VendorMessages->VendorMessage->SubSection->Paragraph->URL;
      $apartamento = $xml->RoomStays->RoomStay->RoomTypes->RoomType->RoomDescription->Text;
      $descApartamento = $xml->RoomStays->RoomStay->RoomTypes->RoomType->AdditionalDetails->AdditionalDetail[0]->DetailDescription->Text;
      $codQuarto = $xml->RoomStays->RoomStay->RoomRates->RoomRate->attributes()->RoomTypeCode;
      $valorDiaria = $xml->RoomStays->RoomStay->RoomRates->RoomRate->Rates->Rate[0]->Base->attributes()->AmountBeforeTax;
      $valorTotal= $xml->RoomStays->RoomStay->RoomRates->RoomRate->Rates->Rate[0]->Total->attributes()->AmountAfterTax;
    };                


} catch (Exception $error) {
  echo "<center><h1 style='margin-top: 30px;'>Não foi possível completar a operação</h1><br>".$error->getMessage()."</center>";
  break;
}

//-----------------------------------------------------------------------------------------------------
//-----Verifica se tem quarto disponível
//-----------------------------------------------------------------------------------------------------
if ($isDisponivel) { 
?>

<!--//////////////////////////////////////////////////////////////////////////////////////////////-->
<!--/////////Passo 1//////////////////////////////////////////////////////////////////////////////-->
<!--//////////////////////////////////////////////////////////////////////////////////////////////-->

<style type="text/css">
#container-passo2, #container-passo3 {width: 100%; overflow: auto;}
#passo-titulo {width: 100%; margin-bottom: 20px; padding-bottom: 10px; border-bottom: solid 1px #074289; color: #074289; font-size: 24px; font-weight: bold;}
#container-passo2 #hotel-header {width: 98%; display: inline-block; margin: 10 0;}
#container-passo2 #hotel-header div {float: left; max-width: 340px;}
#container-passo2 #hotel-header #imagem {width: 240px;}
#container-passo2 #hotel-header #imagem img {max-width: 240px;}
#container-passo2 #hotel-header #titulo p.titulo {padding: 0 20px; font-size: 36px; font-weight: bold;}
#container-passo2 #hotel-header #titulo p.endereco {padding: 0 20px;}
#container-passo2 #hotel-info .titulo {margin: 10 0; font-size: 16px; font-weight: bold; background-color: #def; padding: 10px;}
#container-passo2 #hotel-info .desc {width: 96%; padding: 0; text-indent: 10;}
#container-botoes {width: 100%; display: inline-block; margin: 10 0;}
#container-botoes #finalizar {float: right;}
#container-botoes #anterior {float: left;}
#container-botoes #proximo {float: right;}

@media only screen and (max-device-width: 600px) {

#container-passo2 #hotel-header #titulo p.titulo {padding: 0; font-size: 36px; font-weight: bold; margin: 10 0;}
#container-passo2 #hotel-header #titulo p.endereco {padding: 0; margin-bottom: 0;}

}
</style>

<div id="container-passo2" >
  <div id="passo-titulo">01. Dados do hotel</div>
  <div id="hotel-header">
    <div id="imagem"><img src=<?php echo $imagem; ?> alt=<?php echo $titulo; ?> class="img-polaroid"></div>
    <div id="titulo">
      <p class="titulo"><?php echo $titulo; ?></p>
      <p class="endereco"><?php echo $endereco; ?></p>
    </div>
  </div>
  <div id="hotel-info">
    <p class="titulo">Apartamento</p>
    <p class="desc"><b><?php echo $apartamento; ?></b> - <?php echo $descApartamento; ?></p>
    <p class="titulo">Qtd. hóspedes</p>
    <p class="desc"><?php echo $qtdHospedes ?></p>
    <p class="titulo">Valor da diária</p>
    <p class="desc">R$ <?php echo $valorDiaria ?></p>
    <p class="titulo">Valor total</p>
    <p class="desc">R$ <?php echo $valorTotal ?></p>
  </div>
  <div id="container-botoes">
    <div id="anterior"><a href="index.html" class="btn">Voltar</a></div>
    <div id="proximo"><a href="#" class="btn btn-primary" onclick="continuarPasso3();">Continuar a reserva</a></div>
  </div>
</div>

<!--//////////////////////////////////////////////////////////////////////////////////////////////-->
<!--/////////Passo 2//////////////////////////////////////////////////////////////////////////////-->
<!--//////////////////////////////////////////////////////////////////////////////////////////////-->

<style type="text/css">

@media only screen and (min-device-width: 800px) {

#container-passo3 p {padding: 0 10;}
#container-passo3 p.nome {float: left;}
#container-passo3 p.sobrenome {}
#container-passo3 p.email {float: left;}
#container-passo3 p.fone {}
#container-passo3 p.fone .ddd {width: 45px; margin-right: 5px;}
#container-passo3 p.fone .fone {}
#container-passo3 p.titulo-cartao {font-size: 18px; font-weight: bold; margin-top: 20; border-bottom: 1px dotted #000;}
#container-passo3 div#cartao {float: left;}
#container-passo3 .styled {margin: 0 10;}
#container-passo3 p.numero {}
#container-passo3 p.titular input {width: 300px;}
#container-passo3 p.validade input {width: 140px; float: left; margin-right: 10px;}
#container-passo3 p.codigo input {width: 150px;}

}

@media only screen and (max-device-width: 800px) {

#container-passo3 p.fone .ddd {width: 45px; margin-right: 5px; float: left;}
#container-passo3 p.fone .fone {width: 155px;}
#container-passo3 p.titulo-cartao {font-size: 18px; font-weight: bold; margin-top: 40; border-bottom: 1px dotted #000;}
#container-passo3 div#cartao {width: 99%; margin-bottom: 20px;}
#container-passo3 p.validade input {width: 123px; float: left; margin-right: 10px;}
#container-passo3 p.codigo input {width: 123px;}

}
</style>
<script type="text/javascript">
function submitFormFinal() {
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

<div id="container-passo3" style="display: none;">
  <div id="passo-titulo">02. Dados da reserva</div>
  <form id="formFinal" action="step3.php" method="post">
    <!-- Passar valores do XML pelo formulário -->
    <input type="hidden" name="codHotel" value=<?php echo $codHotel ?> />
    <input type="hidden" name="partida" value=<?php echo $partida ?> />
    <input type="hidden" name="chegada" value=<?php echo $chegada ?> />
    <input type="hidden" name="valorDiaria" value=<?php echo $valorDiaria ?> />
    <input type="hidden" name="valorTotal" value=<?php echo $valorTotal ?> />
    <input type="hidden" name="codQuarto" value=<?php echo $codQuarto ?> />
    <input type="hidden" name="temCrianca" value=<?php echo $temCrianca ?> />
    <input type="hidden" name="idadeCrianca" value=<?php echo $idadeCrianca ?> />
    <input type="hidden" name="qtdHospedes" value=<?php echo $qtdHospedes ?> />
    <!-- Capturar valores do usuário -->
    <p class="nome"><input type="text" name="nomeCliente" id="nomeCliente" placeholder="Nome"></p>
    <p class="sobrenome"><input type="text" name="sobrenomeCliente" id="sobrenomeCliente" placeholder="Sobrenome"></p>
    <p class="email"><input type="text" name="emailCliente" id="emailCliente" placeholder="E-mail"></p>
    <p class="fone"><input type="text" name="ddiCliente" id="ddiCliente" placeholder="DDI" size="1" maxlength="2" class="ddd">
                    <input type="text" name="dddCliente" id="dddCliente" placeholder="DDD" size="1" maxlength="2"  class="ddd">
                    <input type="text" name="foneCliente" id="foneCliente" placeholder="Telefone" class="fone"></p>
    <p class="titulo-cartao">Dados do cartão</p>
    <div id="cartao" class="styled">
      <select name="bandeiraCartao" id="bandeiraCartao" class="span3">
        <option value="VI">Visa</option>
        <option value="MC">Master</option>
      </select>
    </div>
    <p class="numero"><input type="text" name="numeroCartao" id="numeroCartao" placeholder="Número"></p>
    <p class="titular"><input type="text" name="nomeTitularCartao" id="nomeTitularCartao" placeholder="Nome do titular como está no cartão"></p>
    <p class="validade"><input type="text" name="dtValidadeCartao" id="dtValidadeCartao" placeholder="Validade"></p>
    <p class="codigo"><input type="text" name="codSegurancaCartao" id="codSegurancaCartao" placeholder="Código de segurança"></p>
    <p>
      <textarea name="politica_restricoes" rows="10" readonly="readonly"><?php include 'politica-citi-hoteis.html'; ?></textarea>
    </p>
    <div id="container-botoes">
      <div id="anterior"><a href="#" class="btn" onclick="voltarPasso2();">Voltar</a></div>
      <div id="finalizar"><a href="#" class="btn btn-success" onclick="submitFormFinal();">Confirmar</a></div>
    </div>
  </form>
</div>
<?php 
} else {
  echo "<center><h1 style='margin-top: 30px;'>Não foi possível completar a operação</h1><br>Por favor, tente novamente novamente mais tarde.</center>";
}
?>
</body>
</html>