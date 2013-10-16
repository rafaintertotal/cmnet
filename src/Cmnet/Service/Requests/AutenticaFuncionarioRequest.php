<?php
namespace Cmnet\Service\Requests;

use \SoapClient;
use \stdClass;
use \SoapVar;

/**
 * Requisição de autenticação de funcionários
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class AutenticaFuncionarioRequest implements CmnetRequest
{
    /**
     * Identificação para a requisição enviada pelo cliente
     *
     * @var string
     */
    private $token;

    /**
     * Login do usuário
     *
     * @var string
     */
    private $username;

    /**
     * Senha do usuário
     *
     * @var string
     */
    private $password;

    /**
     * Código da agência de viagens ou operadora
     *
     * @var string
     */
    private $companyCode;

    /**
     * Inicializa o objeto
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param string $username Login do usuário
     * @param string $password Senha do usuário
     * @param string $companyCode Código da agência de viagens ou operadora
     */
    public function __construct($token, $username, $password, $companyCode)
    {
        $this->token = $token;
        $this->username = $username;
        $this->password = $password;
        $this->companyCode = $companyCode;
    }

    /**
    * @inheritdoc
    * @see \Cmnet\Service\Requests\CmnetRequest::toXml()
    */
    public function toXml($timestamp, $environment, $language)
    {
        return
            '<Xml xmlns="http://www.cmnet/xmlwebservices2/">
                <CMNET_AutenticaFuncionarioRQ Version="1.0" EchoToken="' . $this->token . '"
                    Target="' .$environment . '" TimeStamp="' . $timestamp . '"
                    PrimaryLangID="' .$language . '"
                    xmlns="http://www.cmnet/xmlwebservices2/"
                    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                    <SecurityInfo Username="' . $this->username . '"
                        Password="' . $this->password . '"
                        CompanyCode="' . $this->companyCode . '" />
                </CMNET_AutenticaFuncionarioRQ>
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

        return $service->xmlAutenticaFuncionario($request)
                       ->xmlAutenticaFuncionarioResult
                       ->any;
    }
}
