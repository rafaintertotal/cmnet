<?php
namespace Cmnet\Service;

use \SoapHeader;
use \stdClass;
use \SoapVar;

/**
 * Cabeçalhos de autenticação do webservice
 *
 * 
 */
class CmnetAuthHeader
{
    /**
     * Usuário
     *
     * @var string
     */
    private $username;

    /**
     * Senha
     *
     * @var string
     */
    private $password;

    /**
     * Código do parceiro no CMNet
     *
     * @var int
     */
    private $parceiroId;

    /**
     * Inicializa o objeto de autenticação
     *
     * @param string $username Usuário
     * @param string $password Senha
     * @param int $idParceiro Código do parceiro no CMNet
     */
    public function __construct($username, $password, $idParceiro)
    {
        $this->username = $username;
        $this->password = $password;
        $this->parceiroId = $idParceiro;
    }

    /**
     * Retorna o cabeçalho SOAP no padrão do webservice
     *
     * @return \SoapHeader
     */
    public function getSoapHeader()
    {
        $auth =
            '<PayloadInfo
                Username="' . $this->username . '"
                Password="' . $this->password . '"
                IDParceiro="' . $this->parceiroId . '"
                xmlns="http://www.cmnet/xmlwebservices2/" />';

        $authData = new SoapVar($auth, XSD_ANYXML, null, null, null);
        $header =  new SoapHeader('http://www.cmnet/xmlwebservices2/', 'PayloadInfo', $authData, false);

        return $header;
    }
}
