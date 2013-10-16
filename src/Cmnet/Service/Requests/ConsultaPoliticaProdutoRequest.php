<?php
namespace Cmnet\Service\Requests;

use \Cmnet\ValueObject\RequestorIdentification;
use \SoapClient;
use \stdClass;
use \DateTime;
use \SoapVar;

/**
 * Requisição para consulta das políticas de um produto
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class ConsultaPoliticaProdutoRequest implements CmnetRequest
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
     * Código da acomodação
     *
     * @var string
     */
    private $roomType;

    /**
     * Data da chegada
     *
     * @var \DateTime
     */
    private $checkInAt;

    /**
     * Inicializa o objeto
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param \Cmnet\ValueObject\RequestorIdentification $identification Identificação do parceiro/empresa no CMNet
     * @param int $hotelId Identificação do hotel no CMNet
     * @param string $roomType Código da acomodação
     * @param \DateTime $checkInAt Data da chegada
     */
    public function __construct(
        $token,
        RequestorIdentification $identification,
        $hotelId,
        $roomType,
        DateTime $checkInAt
    ) {
        $this->token = $token;
        $this->identification = $identification;
        $this->hotelId = $hotelId;
        $this->roomType = $roomType;
        $this->checkInAt = $checkInAt;
    }

    /**
     * @inheritdoc
     * @see \Cmnet\Service\Requests\CmnetRequest::toXml()
     */
    public function toXml($timestamp, $environment, $language)
    {
        return
            '<Xml xmlns="http://www.cmnet/xmlwebservices2/">
              <CMNET_HotelPoliciesRQ xmlns="http://www.cmnet/xmlwebservices2/"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
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
                  <HotelPolity HotelCode="' . $this->hotelId . '">
                      <RoomType RoomTypeCode="' . $this->roomType . '"
                          CheckIn="' . $this->checkInAt->format('Y-m-d') . '"/>
                  </HotelPolity>
              </CMNET_HotelPoliciesRQ>
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

        return $service->xmlConsultaPoliticasProduto($request)
                       ->xmlConsultaPoliticasProdutoResult
                       ->any;
    }
}
