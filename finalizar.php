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
  
    </head>
    <?php
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

        date_default_timezone_set('America/Sao_Paulo');


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
       
        $totalDiaria =(int)$_POST["totalDiaria"];

        $nome =$_POST["nomeCliente"];
        $sobrenome =$_POST["sobrenomeCliente"];
        $email = $_POST["emailCliente"];
        $celular = $_POST["ddicelularCliente"].$_POST["dddcelularCliente"].$_POST["celularCliente"];



        $bandeiraCartao = $_POST["bandeiraCartao"];
        $numeroCartao = $_POST["numeroCartao"];
        $nomeTitularCartao = $_POST["nomeTitularCartao"];
        $dtValidadeCartao = dataCartao($_POST["dtValidadeCartao"]);
        $codSegurancaCartao = $_POST["codSegurancaCartao"];

        // $dtValidadeCartaoArray = split($dtValidadeCartao, "/");
        // $dtValidadeCartao = $dtValidadeCartaoArray[0].$dtValidadeCartaoArray[2];


        // echo $dtValidadeCartao;


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
        
           // echo "teste";

            // var_dump(
                $xml=  $service->incluiOuAlteraReserva(
                    '1234',
                    $requestorId,
                    $codHotel,
                    $codQuarto,
                    new Money($totalDiaria),
                    new GuestList(array(new GuestCount(1))),
                    new DateTimeInterval(new DateTime($chegada), new DateTime($partida)),
                    //new DirectBill(),
                    //new CreditCard('VI','4831660534239312','0712','128','TESTE Intertotal', 12),
                    new CreditCard($bandeiraCartao, $numeroCartao, $dtValidadeCartao, $codSegurancaCartao, $nomeTitularCartao, 1),
                    $nome,
                    $sobrenome,
                    $email,
                    $celular
                // )
                );

             


        } catch (Exception $error) {
            echo $error;
        }




?>

    <body>
        <div class="container" style="height: 620px;">

                    <h2>03. RESUMO DA COMPRA</h2>
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


