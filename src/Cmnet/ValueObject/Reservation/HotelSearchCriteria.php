<?php
namespace Cmnet\ValueObject\Reservation;

use \InvalidArgumentException;

/**
 * Parâmetros de busca de hotéis
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class HotelSearchCriteria
{
    /**
     * Código do hotel
     *
     * @var int
     */
    private $id;

    /**
     * Cidade do hotel
     *
     * @var string
     */
    private $cityId;

    /**
     * Código da cadeia de hotéis
     *
     * @var int
     */
    private $chainId;

    /**
     * Nome do hotel
     *
     * @var string
     */
    private $name;

    /**
     * Localização geográfica
     *
     * @var \Cmnet\ValueObject\Reservation\Position
     */
    private $position;

    /**
     * Inicializa o objeto
     *
     * @param int $id Código do hotel
     * @param string $cityId Cidade do hotel
     * @param int $chainId Código da cadeia de hotéis
     * @param string $name Nome do hotel
     * @param \RecantoDoCampeche\Util\Position $position Localização geográfica
     * @throws \InvalidArgumentException Quando não for enviado nem o código do hotel nem a cidade
     */
    public function __construct($id = null, $cityId = null, $chainId = null, $name = null, Position $position = null)
    {
        if ($id === null && $cityId === null) {
            throw new InvalidArgumentException('Você deve informar o ID do hotel ou da cidade do hotel');
        }

        $this->setId($id);
        $this->setCityId($cityId);
        $this->setChainId($chainId);
        $this->setName($name);
        $this->setPosition($position);
    }

    /**
     * Retorna o código do hotel
     *
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Configura o código do hotel
     *
     * @param number $id
     */
    protected function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Retorna a cidade do hotel
     *
     * @return string
     */
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * Configura a cidade do hotel
     *
     * @param string $cityId
     */
    protected function setCityId($cityId)
    {
        $this->cityId = $cityId;
    }

    /**
     * Retorna o código da cadeia de hotéis
     *
     * @return number
     */
    public function getChainId()
    {
        return $this->chainId;
    }

    /**
     * Configura o código da cadeia de hotéis
     *
     * @param number $chainId
     */
    protected function setChainId($chainId)
    {
        $this->chainId = $chainId;
    }

    /**
     * Retorna o nome do hotel
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Configura o nome do hotel
     *
     * @param string $name
     */
    protected function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Retorna a posição geográfica
     *
     * @return \Cmnet\ValueObject\Reservation\Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Configura a posição geográfica
     *
     * @param \Cmnet\ValueObject\Reservation\Position $position
     */
    protected function setPosition(Position $position = null)
    {
        $this->position = $position;
    }

    /**
     * Cria o XML
     *
     * @return string
     */
    public function createTag()
    {
        $tag = '<HotelSearchCriteria><Criterion>';

        if ($this->getPosition()) {
            $tag .=
            '<Position Latitude="' . $this->getPosition()->getLatitude() . '"
            Longitude="' . $this->getPosition()->getLongitude() . '" />';
        }

        $tag .= '<HotelRef';

        if ($this->getId()) {
            $tag .= ' HotelCode="' . $this->getId() . '"';
        }

        if ($this->getCityId()) {
            $tag .= ' HotelCityCode="' . $this->getCityId() . '"';
        }

        if ($this->getChainId()) {
            $tag .= ' ChainCode="' . $this->getChainId() . '"';
        }

        if ($this->getName()) {
            $tag .= ' HotelName="' . $this->getName() . '"';
        }

        $tag .= ' /></Criterion></HotelSearchCriteria>';

        return $tag;
    }
}
