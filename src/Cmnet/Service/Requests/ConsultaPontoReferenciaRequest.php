<?php
namespace Cmnet\Service\Requests;

use \SoapClient;
use \stdClass;
use \SoapVar;

/**
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class ConsultaPontoReferenciaRequest implements CmnetRequest
{
    /**
     * Identificação para a requisição enviada pelo cliente
     *
     * @var string
     */
    private $token;

    /**
     * Descrição do ponto de referencia
     *
     * @var string
     */
    private $query;

    /**
     * Código ISO da cidade
     *
     * @var string
     */
    private $cityCode;

    /**
     * Código da cadeia de hotéis
     *
     * @var int
     */
    private $chainId;

    /**
     * Inicializa o objeto
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param string $query Descrição do ponto de referencia
     * @param string $cityId Código ISO da cidade
     * @param int $chainId Código da cadeia de hotéis
     */
    public function __construct(
        $token,
        $query,
        $cityCode = null,
        $chainId = null
    ) {
        $this->token = $token;
        $this->query = $query;
        $this->cityCode = $cityCode;
        $this->chainId = $chainId;
    }

    /**
     * @inheritdoc
     * @see \Cmnet\Service\Requests\CmnetRequest::toXml()
     */
    public function toXml($timestamp, $environment, $language)
    {
        $optional = '';

        if ($this->cityCode !== null) {
            $optional .= ' CityCode="' . $this->cityCode . '"';
        }

        if ($this->chainId !== null) {
            $optional .= ' ChainCode="' . $this->chainId . '"';
        }

        return
            '<Xml xmlns="http://www.cmnet/xmlwebservices2/">
              <CMNET_RefPointRQ xmlns="http://www.cmnet/xmlwebservices2/"
                  Version="1.0"
                  EchoToken="' . $this->token . '"
                  TimeStamp="' . $timestamp . '"
                  Target="' . $environment . '"
                  PrimaryLangID="' . $language . '">
                  <Criteria>
                      <Criterion>
                          <RefPoint' . $optional . '>' . $this->query . '</RefPoint>
                      </Criterion>
                  </Criteria>
              </CMNET_RefPointRQ>
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

        return $service->xmlConsultaRefPoints($request)
                       ->xmlConsultaRefPointsResult
                       ->any;
    }
}
