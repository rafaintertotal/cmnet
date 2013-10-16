<?php
namespace Cmnet\ValueObject;

use \InvalidArgumentException;

/**
 * Identificação do parceiro/empresa que realiza as requisições
 *
 * 
 */
class RequestorIdentification
{
    /**
     * Código do tipo parceiro
     *
     * @var int
     */
    const PARCEIRO = 4;

    /**
     * Código do tipo agência de viagens
     *
     * @var int
     */
    const AGENCIA_VIAGEM = 5;

    /**
     * Código
     *
     * @var int
     */
    private $id;

    /**
     * Tipo
     *
     * @var int
     */
    private $type;

    /**
     * URL do site
     *
     * @var string
     */
    private $url;

    /**
     * Inicializa o objeto
     *
     * @param int $id Código
     * @param int $type Tipo
     * @param string $url URL do site
     */
    public function __construct($id, $type, $url)
    {
        $this->setId($id);
        $this->setType($type);
        $this->setUrl($url);
    }

    /**
     * Retorna o código
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Configura o código
     *
     * @param int $id
     */
    protected function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Retorna o tipo
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Configura o tipo
     *
     * @param int $type
     * @throws \InvalidArgumentException Quando o tipo é inválido
     */
    protected function setType($type)
    {
        if (!in_array($type, array(self::PARCEIRO, self::AGENCIA_VIAGEM))) {
            throw new InvalidArgumentException('O tipo pode ser apenas 4 ou 5');
        }

        $this->type = $type;
    }

    /**
     * Retorna a URL
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Configura a URL
     *
     * @param string $url
     */
    protected function setUrl($url)
    {
        $this->url = $url;
    }
}
