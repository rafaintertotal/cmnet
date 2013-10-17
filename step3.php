<html>
<!DOCTYPE html>
<!--[if IE 7 ]> <html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<title>Confirmação</title>
<link rel="stylesheet" media="screen" href="style.css" />

<!-- This is for mobile devices -->
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>

<!-- This makes HTML5 elements work in IE 6-8 -->
<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
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
use Cmnet\ValueObject\Payment\CreditCard;
use Cmnet\Service\CmnetAuthHeader;
use Cmnet\Util\DateTimeInterval;
use Cmnet\Service\CmnetService;
use Cmnet\ValueObject\Money;

// date_default_timezone_set('America/Sao_Paulo');

//-----------------------------------------------------------------------------------------------------
//-----Receber os parâmetros
//-----------------------------------------------------------------------------------------------------

function dataCartao($d){

   $array = explode('/', $d);


   $mes = $array[0];
   $ano= $array[1];

   $data ='';
   $data.=$mes;
   $data .=$ano;
      
   return $data;
}

$codHotel = (int)$_POST["codHotel"];
$chegada =$_POST["chegada"];
$partida =$_POST["partida"];
$codQuarto =$_POST["codQuarto"];

$totalDiaria =(int)$_POST["valorTotal"];

$nome =$_POST["nomeCliente"];
$sobrenome =$_POST["sobrenomeCliente"];
$email = $_POST["emailCliente"];
$celular = $_POST["ddiCliente"].$_POST["dddCliente"].$_POST["foneCliente"];

$bandeiraCartao = $_POST["bandeiraCartao"];
$numeroCartao = $_POST["numeroCartao"];
$nomeTitularCartao = $_POST["nomeTitularCartao"];
$dtValidadeCartao = dataCartao($_POST["dtValidadeCartao"]);
$codSegurancaCartao = $_POST["codSegurancaCartao"];

$comentarios =$_POST["comentarios"];

$temCrianca = $_POST["codSegurancaCartao"];
$idadeCrianca = $_POST["idadeCrianca"];
$qtdHospedes = $_POST["qtdHospedes"];

//-----------------------------------------------------------------------------------------------------
//-----Verificar se há criança
//-----------------------------------------------------------------------------------------------------

if ($temCrianca) {
  $hospedes = array(new GuestCount(1), new GuestCount(1, 8, $idadeCrianca));
} else {
  $hospedes = array(new GuestCount($adulto));
}

//-----------------------------------------------------------------------------------------------------
//-----Definir timezone
//-----------------------------------------------------------------------------------------------------

date_default_timezone_set('America/Sao_Paulo');

//-----------------------------------------------------------------------------------------------------
//-----Iniciar serviço
//-----------------------------------------------------------------------------------------------------

// try {

    // $autenticacao = new CmnetAuthHeader('PACITIH', 'PACITIH', 476283);
    // $requestorId = new RequestorIdentification(
    //     $codHotel,
    //     RequestorIdentification::PARCEIRO,
    //     'http://www.citihoteis.com.br'
    // );

    // $service = new CmnetService($autenticacao);

//-----------------------------------------------------------------------------------------------------
//-----Gerar XML
//-----------------------------------------------------------------------------------------------------

//     var_dump(
//         $xml=  $service->incluiOuAlteraReserva(
//             '1234',
//             $requestorId,
//             $codHotel,
//             $codQuarto,
//             new Money($valorTotal),
//             new GuestList($hospedes),
//             new DateTimeInterval(new DateTime($chegada), new DateTime($partida)),
//             new CreditCard($bandeiraCartao, $numeroCartao, $dtValidadeCartao, $codSegurancaCartao, $nomeTitularCartao, 1),
//             $nome,
//             $sobrenome,
//             $email,
//             $celular,
//             $comentarios
//         )
//         );

// } catch (Exception $error) {
//     echo $error;
// }
?>
<div class="container" style="height: 620px;">

                    <h2>04. RESUMO DA COMPRA</h2>
                    <span>Veja as informações referentes à sua reserva e efetue a confirmação </p>
                        <hr>
                    <div class="row-fluid show-grid">
                        <div class="span4"></div>
                        <div class="span4"></div>
                    </div>
                    <div class="row-fluid show-grid">
                        <div class="span4"></div>
                        <div class="span8"><span><strong>Titular da reserva:</strong>&nbsp;<?php echo $nome; echo " "; echo $sobrenome; ?></span><p></p>
                            <span>Data de chegada: <strong><?php echo $chegada ?> </strong></span>&nbsp;&nbsp;
                            <span>Data de saída: <strong><?php echo $partida ?></strong></span>&nbsp;&nbsp;
                                <p></p>
                            <span>Total: <strong><?php echo $valorTotal ?></strong></span>&nbsp;&nbsp;
                            <p></p>
                            <span>Obs.: <strong><?php echo $comentarios ?></strong></span>&nbsp;&nbsp;
                            <p></p>
                            <span>Telefone: <strong><?php echo $celular ?></strong></span>&nbsp;&nbsp;
                            <span>Email: <strong><?php echo $email ?></strong></span>&nbsp;&nbsp;
                                <p></p>
                            <span>Cartão: <strong><?php echo $bandeiraCartao ?></strong></span>&nbsp;&nbsp;
                            <?php echo $numeroCartao ?></strong></span>&nbsp;&nbsp;
                        </div>
                    </div>


        </div>
</body>
</html>