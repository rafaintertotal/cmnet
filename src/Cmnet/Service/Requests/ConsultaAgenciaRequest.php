<?php
namespace Cmnet\Service\Requests;

use \Cmnet\ValueObject\RequestorIdentification;
use \SoapClient;
use \stdClass;
use \SoapVar;

/**
 * Requisição de consulta do cadastro de uma agência ou empresa
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class ConsultaAgenciaRequest implements CmnetRequest
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
     * ID a ser localizado
     *
     * @var int
     */
    private $searchId;

    /**
     * Inicializa o objeto
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param \Cmnet\ValueObject\RequestorIdentification $identification Identificação do parceiro/empresa no CMNet
     * @param int $searchId ID a ser localizado
     */
    public function __construct($token, RequestorIdentification $identification, $searchId)
    {
        $this->token = $token;
        $this->identification = $identification;
        $this->searchId = $searchId;
    }

    /**
     * @inheritdoc
     * @see \Cmnet\Service\Requests\CmnetRequest::toXml()
     */
    public function toXml($timestamp, $environment, $language)
    {
        return
            '<Xml xmlns="http://www.cmnet/xmlwebservices2/">
                <OTA_ReadRQ xmlns="http://www.opentravel.org/OTA/2003/05"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05 http://www.opentravel.org/2004B/OTA_ReadRQ.xsd"
                  Version="1.003"
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
                  <UniqueID Type="21" ID="' . $this->searchId . '" ID_Context="CNPJ"/>
              </OTA_ReadRQ>
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

        return $service->xmlCadastroAgEmp($request)
                       ->xmlCadastroAgEmpResult
                       ->any;
    }
}
