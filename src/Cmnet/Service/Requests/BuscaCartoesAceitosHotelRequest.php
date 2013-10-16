<?php
namespace Cmnet\Service\Requests;

use \Cmnet\ValueObject\RequestorIdentification;
use \SoapClient;
use \stdClass;
use \SoapVar;

/**
 * Requisição de busca de cartões aceitos pelo hotel
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class BuscaCartoesAceitosHotelRequest implements CmnetRequest
{
    /**
     * Identificação para a requisição enviada pelo cliente
     *
     * @var string
     */
    private $token;

    /**
     * Identificação do parceiro/empresa no CMNet
     *
     * @var \Cmnet\ValueObject\RequestorIdentification
     */
    private $identification;

    /**
     * Identificação do hotel no CMNet
     *
     * @var int
     */
    private $hotelId;

    /**
     * Inicializa o objeto
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param \Cmnet\ValueObject\RequestorIdentification $identification Identificação do parceiro/empresa no CMNet
     * @param int $hotelId Identificação do hotel no CMNet
     */
    public function __construct(
        $token,
        RequestorIdentification $identification,
        $hotelId
    ) {
        $this->token = $token;
        $this->identification = $identification;
        $this->hotelId = $hotelId;
    }

    /**
     * @inheritdoc
     * @see \Cmnet\Service\Requests\CmnetRequest::toXml()
     */
    public function toXml($timestamp, $environment, $language)
    {
        return
            '<Xml xmlns="http://www.cmnet/xmlwebservices2/">
                <OTA_HotelDescriptiveInfoRQ xmlns="http://www.opentravel.org/OTA/2003/05"
                  Version="1.0"
                  EchoToken="' . $this->token . '"
                  TimeStamp="' . $timestamp . '"
                  Target="' . $environment . '"
                  PrimaryLangID="' . $language . '">
                    <POS>
                      <Source>
                          <RequestorID Type="' . $this->identification->getType() . '"
                              ID="' . $this->identification->getId() . '"
                              URL="' . $this->identification->getUrl() . '"/>
                      </Source>
                  </POS>
                    <HotelDescriptiveInfos>
                      <HotelDescriptiveInfo HotelCode="' . $this->hotelId . '">
                          <Policies SendPolicies="true"/>
                      </HotelDescriptiveInfo>
                  </HotelDescriptiveInfos>
              </OTA_HotelDescriptiveInfoRQ>
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

        return $service->xmlCartoesAceitosHotel($request)
                       ->xmlCartoesAceitosHotelResult
                       ->any;
    }
}
