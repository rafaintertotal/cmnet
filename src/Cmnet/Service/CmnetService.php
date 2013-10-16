<?php
namespace Cmnet\Service;

use \Cmnet\Service\Requests\ConsultaDisponibilidadeHotelRequest;
use \Cmnet\Service\Requests\RevisaoAcomodacoesReservaRequest;
use \Cmnet\Service\Requests\BuscaCartoesAceitosHotelRequest;
use \Cmnet\Service\Requests\ConsultaPontoReferenciaRequest;
use \Cmnet\Service\Requests\ConsultaPoliticaProdutoRequest;
use \Cmnet\Service\Requests\IncluiOuAlteraReservaRequest;
use \Cmnet\Service\Requests\BuscaInformacaoHotelRequest;
use \Cmnet\Service\Requests\AutenticaFuncionarioRequest;
use \Cmnet\ValueObject\Reservation\HotelSearchCriteria;
use \Cmnet\Service\Requests\ConsultaAgenciaRequest;
use \Cmnet\Service\Requests\CancelaReservaRequest;
use \Cmnet\ValueObject\RequestorIdentification;
use \Cmnet\ValueObject\Reservation\GuestList;
use \Cmnet\Service\Requests\CmnetRequest;
use \Cmnet\ValueObject\Payment\Payment;
use \Cmnet\Util\DateTimeInterval;
use \InvalidArgumentException;
use \Cmnet\ValueObject\Money;
use \SimpleXMLElement;
use \SoapClient;
use \DateTime;

/**
 * 
 */
class CmnetService
{
    /**
     * @var string
     */
    const WSDL_LOCATION = 'https://webservices3.cmnet.com.br:440/v3/ota/reservas/OTA_Reservas.asmx?WSDL';

    /**
     * @var string
     */
    const DESENVOLVIMENTO = 'Test';

    /**
     * @var string
     */
    const PRODUCAO = 'Production';

    /**
     * @var string
     */
    const PORTUGUES_BRASIL = 'pt-BR';

    /**
     * @var string
     */
    const PORTUGUES_PORTUGAL = 'pt-PT';

    /**
     * @var string
     */
    const ESPANHOL = 'es-ES';

    /**
     * @var string
     */
    const INGLES = 'en-US';

    /**
     * @var string
     */
    const FRANCES = 'fr-FR';

    /**
     * @var string
     */
    const ITALIANO = 'it-IT';

    /**
     * @var string
     */
    const ALEMAO = 'de-DE';

    /**
     * @var \SoapClient
     */
    public $service;

    /**
     * @var string
     */
    private $ambiente;

    /**
     * @var string
     */
    private $idioma;

    /**
     * @param \Cmnet\Service\CmnetAuthHeader $autenticacao
     * @param string $ambiente
     */
    public function __construct(
        CmnetAuthHeader $autenticacao,
        $ambiente = self::PRODUCAO,
        $idioma = self::PORTUGUES_BRASIL
    ) {
        $this->service = new SoapClient(self::WSDL_LOCATION);
        $this->service->__setSoapHeaders($autenticacao->getSoapHeader());
        $this->ambiente = $ambiente;
        $this->idioma = $idioma;
    }

    /**
     * Autenticação de funcionário
     *
     * O objetivo deste método é autenticar os funcionários de agências de
     * viagens, operadoras ou empresas com acesso ao sistema CMNet, visando permitir a
     * venda para o mercado B2B, com suas respectivas tarifas acordo.
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param string $username Login do usuário
     * @param string $password Senha do usuário
     * @param string $companyCode Código da agência de viagens ou operadora
     * @return \SimpleXMLElement
     */
    public function autenticaFuncionario(
        $token,
        $username,
        $password,
        $companyCode
    ) {
        return $this->createResponse(
            new AutenticaFuncionarioRequest(
                $token,
                $username,
                $password,
                $companyCode
            )
        );
    }

    /**
     * Consulta do cadastro de uma agência ou empresa
     *
     * O objetivo deste método é trazer as informações cadastrais de uma
     * agência de viagens ou empresa no CMNet.
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param \Cmnet\ValueObject\RequestorIdentification $identificacao Identificação do parceiro/empresa no CMNet
     * @param int $agenciaId ID a ser localizado
     * @return \SimpleXMLElement
     */
    public function consultaAgenciaOuEmpresa(
        $token,
        RequestorIdentification $identificacao,
        $agenciaId
    ) {
        return $this->createResponse(
            new ConsultaAgenciaRequest(
                $token,
                $identificacao,
                $agenciaId
            )
        );
    }

    /**
     * Cancelamento de reservas
     *
     * O objetivo deste método é efetuar o cancelamento de reservas
     * (uma reserva por requisição).
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param \Cmnet\ValueObject\RequestorIdentification $identificacao Identificação do parceiro/empresa no CMNet
     * @param int $reservaId Número da reserva
     * @param string $celularHospede Número do celular para o envio do SMS com o cancelamento da reserva
     * @return \SimpleXMLElement
     */
    public function cancelaReserva(
        $token,
        RequestorIdentification $identificacao,
        $reservaId,
        $celularHospede
    ) {
        return $this->createResponse(
            new CancelaReservaRequest(
                $token,
                $identificacao,
                $reservaId,
                $celularHospede
            )
        );
    }

    /**
     * Cartões aceitos pelo hotel
     *
     * O objetivo deste método é trazer os cartões de crédito aceitos por
     * um hotel específico.
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param \Cmnet\ValueObject\RequestorIdentification $identificacao Identificação do parceiro/empresa no CMNet
     * @param int $hotelId Identificação do hotel no CMNet
     * @return \SimpleXMLElement
     */
    public function buscaCartoesAceitosPeloHotel(
        $token,
        RequestorIdentification $identificacao,
        $hotelId
    ) {
        return $this->createResponse(
            new BuscaCartoesAceitosHotelRequest(
                $token,
                $identificacao,
                $hotelId
            )
        );
    }

    /**
     * Verifica a disponiblidade do hotel
     *
     * O objetivo deste método é disponibilizar uma lista com acomodações
     * disponíveis e suas respectivas tarifas, de acordo com os critérios
     * informados pelo cliente.
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param \Cmnet\ValueObject\RequestorIdentification $identificacao Identificação do parceiro/empresa no CMNet
     * @param \Cmnet\Util\DateTimeInterval $periodoConsulta Período de disponibilidade
     * @param \Cmnet\ValueObject\Reservation\GuestList $guestList Informações sobre os hóspedes
     * @param \Cmnet\ValueObject\Reservation\HotelSearchCriteria $dadosConsulta Parâmetros sobre o hotel
     * @param int $reservaId Número da reserva
     * @return \SimpleXMLElement
     */
    public function consultaDisponibilidadeHotel(
        $token,
        RequestorIdentification $identificacao,
        DateTimeInterval $periodoConsulta,
        GuestList $guestList,
        HotelSearchCriteria $dadosConsulta,
        $reservaId = null
    ) {
        return $this->createResponse(
            new ConsultaDisponibilidadeHotelRequest(
                $token,
                $identificacao,
                $periodoConsulta,
                $guestList,
                $dadosConsulta,
                $reservaId
            )
        );
    }

    /**
     * Consultar as políticas de um produt
     *
     * O objetivo deste método é consultar as políticas de cancelamento,
     * no-show e modificação de um produto específico.
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param \Cmnet\ValueObject\RequestorIdentification $identificacao Identificação do parceiro/empresa no CMNet
     * @param int $hotelId Identificação do hotel no CMNet
     * @param string $tipoQuartoId Código da acomodação
     * @param \DateTime $checkIn Data da chegada
     * @return \SimpleXMLElement
     */
    public function consultaPoliticaProduto(
        $token,
        RequestorIdentification $identificacao,
        $hotelId,
        $tipoQuartoId,
        DateTime $checkIn
    ) {
        return $this->createResponse(
            new ConsultaPoliticaProdutoRequest(
                $token,
                $identificacao,
                $hotelId,
                $tipoQuartoId,
                $checkIn
            )
        );
    }

    /**
     * Consulta de pontos de interesse
     *
     * O objetivo deste método é disponibilizar uma lista de posições
     * (latitude e longitude) dos pontos de interesse disponíveis no CMNet,
     * de acordo com os critérios informados pelo cliente. A posição de um
     * ponto de interesse pode ser utilizada na consulta de disponibilidade de
     * hotéis
     *
     * @param string $token
     * @param string $referencia
     * @param string $cidadeId
     * @param int $cadeiaId
     * @return \SimpleXMLElement
     */
    public function consultaPontoReferencia(
        $token,
        $referencia,
        $cidadeId = null,
        $cadeiaId = null
    ) {
        return $this->createResponse(
            new ConsultaPontoReferenciaRequest(
                $token,
                $referencia,
                $cidadeId,
                $cadeiaId
            )
        );
    }

    /**
     * Consulta de informações de hotéis
     *
     * O objetivo deste método é consultar as informações dos hotéis
     * cadastrados na base de dados do CMNet.
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param int $hotelId Identificação do hotel no CMNet
     * @param string $mostraEndereco Deve mostrar endereço ('true'/'false')
     * @param string $mostraInfoPropriedade Deve mostrar informações sobre a propriedade ('true'/'false')
     * @param string $mostraServicosOferecidos Deve mostrar os serviços oferecidos ('true'/'false')
     * @param string $mostraSalasReuniao Deve mostrar informações sobre as salas de reuniões ('true'/'false')
     * @param string $mostraRestaurantes Deve mostrar informações sobre os restaurantes ('true'/'false')
     * @param string $mostraPoliticas Deve mostrar informações sobre as políticas ('true'/'false')
     * @param string $mostraPontosReferencia Deve mostrar informações sobre pontos de referências ('true'/'false')
     * @param string $mostraDadosTransportes Deve mostrar informações sobre transporte ('true'/'false')
     * @param string $mostraDirecoes Deve mostrar informações sobre percursos até o hotel ('true'/'false')
     * @param string $mostraSistemasDistribuicoes Deve mostrar informações sobre os sistemas de distribuição do hotel ('true'/'false')
     * @param string $mostraMarcasAfiliadas Deve mostrar informações sobre as marcas afiliadas ao hotel ('true'/'false')
     * @param string $mostraFidelidade Deve mostrar informações sobre os programas de fidelidade ('true'/'false')
     * @param string $mostraPremios Deve mostrar informações sobre os prêmios que o hotel ganhou ('true'/'false')
     * @param string $mostraFotos Deve mostrar retornar imagens ('true'/'false')
     * @return \SimpleXMLElement
     */
    public function buscaInformacaoHotel(
        $token,
        $hotelId,
        $mostraEndereco = 'false',
        $mostraInfoPropriedade = 'false',
        $mostraServicosOferecidos = 'false',
        $mostraSalasReuniao = 'false',
        $mostraRestaurantes = 'false',
        $mostraPoliticas = 'false',
        $mostraPontosReferencia = 'false',
        $mostraDadosTransportes = 'false',
        $mostraDirecoes = 'false',
        $mostraSistemasDistribuicoes = 'false',
        $mostraMarcasAfiliadas = 'false',
        $mostraFidelidade = 'false',
        $mostraPremios = 'false',
        $mostraFotos = 'false'
    ) {
        return $this->createResponse(
            new BuscaInformacaoHotelRequest(
                $token,
                $hotelId,
                $mostraEndereco,
                $mostraInfoPropriedade,
                $mostraServicosOferecidos,
                $mostraSalasReuniao,
                $mostraRestaurantes,
                $mostraPoliticas,
                $mostraPontosReferencia,
                $mostraDadosTransportes,
                $mostraDirecoes,
                $mostraSistemasDistribuicoes,
                $mostraMarcasAfiliadas,
                $mostraFidelidade,
                $mostraPremios,
                $mostraFotos
            )
        );
    }

    /**
     * Inclusão ou alteração de reservas
     *
     * O objetivo deste método é efetuar a inclusão ou alteração de uma reserva.
     * Lembrando que no caso de alteração deve ser informado na requisição o
     * número da reserva a ser alterada.
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param \Cmnet\ValueObject\RequestorIdentification $identificacao Identificação do parceiro/empresa no CMNet
     * @param int $hotelId Identificação do hotel no CMNet
     * @param string $tipoQuartoId Código da acomodação
     * @param \Cmnet\ValueObject\Money $valor Valor de custo da acomodação
     * @param \Cmnet\ValueObject\Reservation\GuestList $guests Informações sobre os hóspedes
     * @param \Cmnet\Util\DateTimeInterval $periodo Período da reserva
     * @param \Cmnet\ValueObject\Payment\Payment $formaPagamento Forma de pagamento
     * @param string $nome Nome do responsável pela reserva
     * @param string $sobrenome Sobrenome do responsável pela reserva
     * @param string $email Email do responsável pela reserva
     * @param string $celular Celular do responsável pela reserva (envio de SMS de confirmação)
     * @param string $comentarios Comentários gerais sobre a reserva
     * @param string $codigoPromocao Cupom de promoção
     * @param int $reservaId Número da reserva (para alteração)
     * @return \SimpleXMLElement
     */
    public function incluiOuAlteraReserva(
        $token,
        RequestorIdentification $identificacao,
        $hotelId,
        $tipoQuartoId,
        Money $valor,
        GuestList $guests,
        DateTimeInterval $periodo,
        Payment $formaPagamento,
        $nome,
        $sobrenome,
        $email = null,
        $celular = null,
        $comentarios = null,
        $codigoPromocao = null,
        $reservaId = null
    ) {
        return $this->createResponse(
            new IncluiOuAlteraReservaRequest(
                $token,
                $identificacao,
                $hotelId,
                $tipoQuartoId,
                $valor,
                $guests,
                $periodo,
                $formaPagamento,
                $nome,
                $sobrenome,
                $email,
                $celular,
                $comentarios,
                $codigoPromocao,
                $reservaId
            )
        );
    }

    /**
     * Revisão da reserva
     *
     * O objetivo deste método é retornar informações completas sobre a
     * acomodação selecionada pelo cliente para
     * reservar, tais como políticas e restrições, formas de pagamento e valores
     * de taxas e tarifas.
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param \Cmnet\ValueObject\RequestorIdentification $identificacao Identificação do parceiro/empresa no CMNet
     * @param int $hotelId Identificação do hotel no CMNet
     * @param string $tipoQuartoId Código da acomodação
     * @param \Cmnet\ValueObject\Reservation\GuestList $guests Informações sobre os hóspedes
     * @param \Cmnet\Util\DateTimeInterval $periodo Período de disponibilidade solicitado
     * @param string $codigoPromocao Cupom de desconto para a reserva
     * @param int $reservaId Número da reserva
     * @return \SimpleXMLElement
     */
    public function verificaAcomodacoesReserva(
        $token,
        RequestorIdentification $identificacao,
        $hotelId,
        $tipoQuartoId,
        GuestList $guests,
        DateTimeInterval $periodo,
        $codigoPromocao = null,
        $reservaId = null
    ) {
        return $this->createResponse(
            new RevisaoAcomodacoesReservaRequest(
                $token,
                $identificacao,
                $hotelId,
                $tipoQuartoId,
                $guests,
                $periodo,
                $codigoPromocao,
                $reservaId
            )
        );
    }

    /**
     * Cria a resposta da requisição
     *
     * Cria um objeto SimpleXMLElement a partir do XML
     * retornado pelo método
     *
     * @param \Cmnet\Service\Requests\CmnetRequest $request Requisição
     * @return \SimpleXMLElement
     */
    protected function createResponse(CmnetRequest $request)
    {
        $string = '<?xml version="1.0" encoding="utf-8"?>';
        $string .= $request->call(
            $this->service,
            $this->getCurrentTimestamp(),
            $this->ambiente,
            $this->idioma
        );

        return new SimpleXMLElement($string);
    }

    /**
     * Retorna o timestamp atual
     *
     * @return string
     */
    protected function getCurrentTimestamp()
    {
        $now = new DateTime();

        return $now->format(DateTime::ATOM);
    }
}
