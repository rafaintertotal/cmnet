<?php
namespace Cmnet\Service\Requests;

use \SoapClient;
use \stdClass;
use \SoapVar;

/**
 * Requisição de busca de informações sobre um hotel
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class BuscaInformacaoHotelRequest implements CmnetRequest
{
    /**
     * Identificação para a requisição enviada pelo cliente
     *
     * @var string
     */
    private $token;

    /**
     * Identificação do hotel no CMNet
     *
     * @var string
     */
    private $hotelId;

    /**
     * Deve mostrar endereço
     *
     * @var string
     */
    private $showAddress;

    /**
     * Deve mostrar informações sobre a propriedade
     *
     * @var string
     */
    private $showPropertyInformation;

    /**
     * Deve mostrar os serviços oferecidos
     *
     * @var string
     */
    private $showOfferedServices;

    /**
     * Deve mostrar informações sobre as salas de reuniões
     *
     * @var string
     */
    private $showMeetingRooms;

    /**
     * Deve mostrar informações sobre os restaurantes
     *
     * @var string
     */
    private $showRestaurants;

    /**
     * Deve mostrar informações sobre as políticas
     *
     * @var string
     */
    private $showRules;

    /**
     * Deve mostrar informações sobre pontos de referências
     *
     * @var string
     */
    private $showReferencePoints;

    /**
     * Deve mostrar informações sobre transporte
     *
     * @var string
     */
    private $showTransportInformation;

    /**
     * Deve mostrar informações sobre percursos de certos pontos até o hotel
     *
     * @var string
     */
    private $showDirections;

    /**
     * Deve mostrar informações sobre os sistemas de distruição do hotel
     *
     * @var string
     */
    private $showDistributionSystem;

    /**
     * Deve mostrar informações sobre as marcas afiliadas ao hotel
     *
     * @var string
     */
    private $mostraMarcasAfiliadas;

    /**
     * Deve mostrar informações sobre os programas de fidelidade
     *
     * @var string
     */
    private $showLoyalty;

    /**
     * Deve mostrar informações sobre os prêmios que o hotel ganhou
     *
     * @var string
     */
    private $showPrizes;

    /**
     * Deve mostrar retornar imagens
     *
     * @var string
     */
    private $showPictures;

    /**
     * Inicializa o objeto
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param int $hotelId Identificação do hotel no CMNet
     * @param string $showAddress Deve mostrar endereço ('true'/'false')
     * @param string $showPropertyInformation Deve mostrar informações sobre a propriedade ('true'/'false')
     * @param string $showOfferedServices Deve mostrar os serviços oferecidos ('true'/'false')
     * @param string $showMeetingRooms Deve mostrar informações sobre as salas de reuniões ('true'/'false')
     * @param string $showRestaurants Deve mostrar informações sobre os restaurantes ('true'/'false')
     * @param string $showRules Deve mostrar informações sobre as políticas ('true'/'false')
     * @param string $showReferencePoints Deve mostrar informações sobre pontos de referências ('true'/'false')
     * @param string $showTransportInformation Deve mostrar informações sobre transporte ('true'/'false')
     * @param string $showDirections Deve mostrar informações sobre percursos até o hotel ('true'/'false')
     * @param string $showDistributionSystem Deve mostrar informações sobre os sistemas de distribuição do hotel ('true'/'false')
     * @param string $showBrands Deve mostrar informações sobre as marcas afiliadas ao hotel ('true'/'false')
     * @param string $showLoyalty Deve mostrar informações sobre os programas de fidelidade ('true'/'false')
     * @param string $showPrizes Deve mostrar informações sobre os prêmios que o hotel ganhou ('true'/'false')
     * @param string $showPictures Deve mostrar retornar imagens ('true'/'false')
     */
    public function __construct(
        $token,
        $hotelId,
        $showAddress = 'false',
        $showPropertyInformation = 'false',
        $showOfferedServices = 'false',
        $showMeetingRooms = 'false',
        $showRestaurants = 'false',
        $showRules = 'false',
        $showReferencePoints = 'false',
        $showTransportInformation = 'false',
        $showDirections = 'false',
        $showDistributionSystem = 'false',
        $showBrands = 'false',
        $showLoyalty = 'false',
        $showPrizes = 'false',
        $showPictures = 'false'
    ) {
        $this->token = $token;
        $this->hotelId = $hotelId;
        $this->showAddress = $showAddress;
        $this->showPropertyInformation = $showPropertyInformation;
        $this->showOfferedServices = $showOfferedServices;
        $this->showMeetingRooms = $showMeetingRooms;
        $this->showRestaurants = $showRestaurants;
        $this->showRules = $showRules;
        $this->showReferencePoints = $showReferencePoints;
        $this->showTransportInformation = $showTransportInformation;
        $this->showDirections = $showDirections;
        $this->showDistributionSystem = $showDistributionSystem;
        $this->mostraMarcasAfiliadas = $showBrands;
        $this->showLoyalty = $showLoyalty;
        $this->showPrizes = $showPrizes;
        $this->showPictures = $showPictures;
    }

    /**
     * @inheritdoc
     * @see \Cmnet\Service\Requests\CmnetRequest::toXml()
     */
    public function toXml($timestamp, $environment, $language)
    {
        return
            '<Xml xmlns="http://www.cmnet/xmlwebservices2/">
              <CMNET_HotelInfoRQ xmlns="http://www.cmnet/xmlwebservices2/"
                    Version="1.0"
                  EchoToken="' . $this->token . '"
                  TimeStamp="' . $timestamp . '"
                  Target="' . $environment . '"
                  PrimaryLangID="' . $language . '">
                  <HotelInfos>
                      <HotelInfo HotelCodeID="' . $this->hotelId . '">
                          <InfoHotel SendEndereco="' . $this->showAddress . '"
                              SendInfoPropriedade="' . $this->showPropertyInformation . '"
                              SendServicos="' . $this->showOfferedServices . '"/>
                          <InfoFacilidades SendSalaReuniao="' . $this->showMeetingRooms . '"
                              SendRestaurantes="' . $this->showRestaurants . '"/>
                          <InfoPoliticas SendPoliticas="' . $this->showRules . '"/>
                          <InfoAreas SendPontosProximos="' . $this->showReferencePoints . '"
                              SendTransportes="' . $this->showTransportInformation . '"
                              SendDirecoesCaminhos="' . $this->showDirections . '"/>
                          <InfoAfiliacoes SendSistemaDistribuicao="' . $this->showDistributionSystem . '"
                              SendMarcasAfiliadas="' . $this->mostraMarcasAfiliadas . '"
                              SendProgramaFidelidade="' . $this->showLoyalty . '"
                              SendPremios="' . $this->showPrizes . '"/>
                          <InfoMultimidia SendGaleriaFotos="' . $this->showPictures . '"/>
                      </HotelInfo>
                  </HotelInfos>
              </CMNET_HotelInfoRQ>
          </Xml>';
    }

    /**
     * @inheritdoc
     * @see \Cmnet\Service\Requests\CmnetRequest::call()
     */
    public function call(SoapClient $service, $timestamp, $environment, $language)
    {
        $request = new stdClass();
        $request->Xml = new SoapVar(
            $this->toXml($timestamp, $environment, $language),
            XSD_ANYXML
        );

        return $service->xmlRetornaInfoHotel($request)
                       ->xmlRetornaInfoHotelResult
                       ->any;
    }
}
