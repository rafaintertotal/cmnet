<?php
namespace Cmnet\Service\Requests;

use \Cmnet\ValueObject\RequestorIdentification;
use \SoapClient;
use \stdClass;
use \SoapVar;

/**
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class CancelaReservaRequest implements CmnetRequest
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
     * Número da reserva
     *
     * @var int
     */
    private $reservationId;

    /**
     * Número do celular do hóspede para o envio do SMS com a confirmação de cancelamento da reserva
     *
     * @var string
     */
    private $cellphone;

    /**
     * Inicializa o objeto
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param \Cmnet\ValueObject\RequestorIdentification $identification Identificação do parceiro/empresa no CMNet
     * @param int $reservationId Número da reserva
     * @param int $cellphone Número do celular do hóspede para o envio do SMS com o cancelamento da reserva
     */
    public function __construct(
        $token,
        RequestorIdentification $identification,
        $reservationId,
        $cellphone
    ) {
        $this->token = $token;
        $this->identification = $identification;
        $this->reservationId = $reservationId;
        $this->cellphone = $cellphone;
    }

    /**
     * @inheritdoc
     * @see \Cmnet\Service\Requests\CmnetRequest::toXml()
     */
    public function toXml($timestamp, $environment, $language)
    {
        return
            '<Xml xmlns="http://www.cmnet/xmlwebservices2/">
                <OTA_CancelRQ xmlns="http://www.opentravel.org/OTA/2003/05"
                  Version="1.0"
                  CancelType="Initiate"
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
                    <UniqueID Type="14" ID="' . $this->reservationId . '"/>
                  <TPA_Extensions>
                      <WrittenConfInst Telephone="' . $this->cellphone . '" />
                  </TPA_Extensions>
              </OTA_CancelRQ>
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

        return $service->xmlCancelaReservaHotel($request)
                       ->xmlCancelaReservaHotelResult
                       ->any;
    }
}
