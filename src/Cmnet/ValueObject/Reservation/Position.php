<?php
namespace Cmnet\ValueObject\Reservation;

/**
 * Posição geográfica
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class Position
{
    /**
     * Latitude (distância de um ponto ao equador)
     *
     * @var number
     */
    private $latitude;

    /**
     * Longitude (distância de um ponto da terra ao meridiano geral)
     *
     * @var number
     */
    private $longitude;

    /**
     * Inicializa o objeto
     *
     * @param number $latitude Latitude do ponto
     * @param number $longitude Longitude do ponto
     */
    public function __construct($latitude, $longitude)
    {
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
    }

    /**
     * Retorna a latitude
     *
     * @return number
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Configura a latitude
     *
     * @param number $latitude
     */
    protected function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Retorna a longitude
     *
     * @return number
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Configura a longitude
     *
     * @param number $longitude
     */
    protected function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }
}
