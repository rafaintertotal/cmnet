<html>
<!DOCTYPE html>
<!--[if IE 7 ]> <html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<title>Passo 2</title>
<link rel="stylesheet" media="screen" href="style.css" />

<!-- This is for mobile devices -->
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>

<!-- This makes HTML5 elements work in IE 6-8 -->
<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<!-- início dos links -->
<!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.css"> -->
<!-- início dos scripts -->
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

try {

//-----------------------------------------------------------------------------------------------------
//-----Iniciar serviço
//-----------------------------------------------------------------------------------------------------

    $autenticacao = new CmnetAuthHeader('PACITIH', 'PACITIH', 476283);
    $requestorId = new RequestorIdentification(
        $codHotel,
        RequestorIdentification::PARCEIRO,
        'http://www.citihoteis.com.br'
    );

    $service = new CmnetService($autenticacao);

//-----------------------------------------------------------------------------------------------------
//-----Definir timezone
//-----------------------------------------------------------------------------------------------------

    date_default_timezone_set('America/Sao_Paulo');

//-----------------------------------------------------------------------------------------------------
//-----Gerar XML
//-----------------------------------------------------------------------------------------------------

    var_dump($xml = $service->consultaDisponibilidadeHotel(
            '1234',
            $requestorId,
            new DateTimeInterval(new DateTime($chegada), new DateTime($partida)),
            new GuestList($hospedes),
            new HotelSearchCriteria($codHotel,null)
        ));

    // $warning = $xml->Warnings->Warning;
    // $erro = $xml->Error;
   
    // if($warning!="") {

    //     echo "<center><h3 style='margin-top: 30px;'>".$warning."</center>";
    //     $isDisponivel = false;
    //     }

    // else{

       $isDisponivel = true;
       $titulo = $xml->RoomStays->RoomStay->BasicPropertyInfo->attributes()->HotelName;
       $endereco = $xml->RoomStays->RoomStay->BasicPropertyInfo->Address->AddressLine[0];
       $imagem = $xml->RoomStays->RoomStay->BasicPropertyInfo->VendorMessages->VendorMessage->SubSection->Paragraph->URL;
       $apartamento = $xml->RoomStays->RoomStay->RoomTypes->RoomType->RoomDescription->Text;
       $descApartamento = $xml->RoomStays->RoomStay->RoomTypes->RoomType->AdditionalDetails->AdditionalDetail[0]->DetailDescription->Text;
       $codQuarto = $xml->RoomStays->RoomStay->RoomRates->RoomRate->attributes()->RoomTypeCode;
       $valorDiaria = $xml->RoomStays->RoomStay->RoomRates->RoomRate->Rates->Rate[0]->Base->attributes()->AmountBeforeTax;
       $totalDiaria= $xml->RoomStays->RoomStay->RoomRates->RoomRate->Rates->Rate[0]->Total->attributes()->AmountAfterTax;
    // };                


} catch (Exception $error) {
    echo $error;
}

//-----------------------------------------------------------------------------------------------------
//-----Verifica se tem quarto disponível
//-----------------------------------------------------------------------------------------------------
if ($isDisponivel) { ?>
<div>
	<div><?php echo $titulo; ?></div>
	<div><img src=<?php echo $imagem; ?> alt="imagem-hotel" class="img-polaroid"></div>
	<div><?php echo $endereco; ?></div>
	<div><?php echo $apartamento; ?></div>
	<div><?php echo $descApartamento; ?></div>
	<div><?php echo $qtdHospedes ?></div>
	<div>R$ <?php echo $valorDiaria ?></div>
	<div>R$ <?php echo $totalDiaria ?></div>
</div>
<?php } ?>
</body>
</html>