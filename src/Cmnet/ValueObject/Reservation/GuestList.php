<?php
namespace Cmnet\ValueObject\Reservation;

use \InvalidArgumentException;

/**
 * Lista de hóspedes para reserva
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class GuestList
{
    /**
     * Hóspedes
     *
     * @var array
     */
    private $guests;

    /**
     * Quantidade de itens do tipo adulto
     *
     * @var int
     */
    private $nrAdults;

    /**
     * Quantidade de itens do tipo criança
     *
     * @var int
     */
    private $nrChildren;

    /**
     * Inicializa o objeto
     *
     * @param \Cmnet\ValueObject\Reservation\GuestCount[] $guests
     */
    public function __construct(array $guests)
    {
        $this->guests = array();
        $this->nrAdults = 0;
        $this->nrChildren = 0;

        foreach ($guests as $guest) {
            $this->append($guest);
        }
    }

    /**
     * Adiciona um agrupador de hóspedes
     *
     * @param \Cmnet\ValueObject\Reservation\GuestCount $guest
     * @throws \InvalidArgumentException Quando a quantidade de itens por tipo ultrapassa o permitido
     */
    public function append(GuestCount $guest)
    {
        if (!$guest->isChildren() && $this->nrAdults > 0) {
            throw new InvalidArgumentException('Não podem existir 2 listas de adultos');
        } elseif ($guest->isChildren() && $this->nrAdults == 6) {
            throw new InvalidArgumentException('Não podem existir mais de 6 listas de crianças');
        }

        !$guest->isChildren() ? ++$this->nrAdults : ++$this->nrChildren;
        $this->guests[] = $guest;
    }

    /**
     * Cria a tag XML
     *
     * @param boolean $showPerRoom Deve conter o atributo "IsPerRoom"?
     * @return string
     */
    public function createTag($showPerRoom = false)
    {
        $tag = $showPerRoom ? '<GuestCounts IsPerRoom="true">' : '<GuestCounts>';

        foreach ($this->guests as $guest) {
            $tag .= $guest->createTag();
        }

        $tag .= '</GuestCounts>';

        return $tag;
    }
}
