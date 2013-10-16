<?php
namespace Cmnet\ValueObject\Reservation;

use \InvalidArgumentException;

/**
 * Quantidade de hóspedes por tipo e idade (para crianças)
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class GuestCount
{
    /**
     * Código do tipo adulto
     *
     * @var int
     */
    const ADULTO = 10;

    /**
     * Código do tipo criança
     *
     * @var int
     */
    const CRIANCA = 8;

    /**
     * Tipo de hóspede
     *
     * @var int
     */
    private $type;

    /**
     * Quantidade
     *
     * @var int
     */
    private $count;

    /**
     * Idade dos hóspedes (apenas crianças)
     *
     * @var int
     */
    private $age;

    /**
     * Inicializa o objeto
     *
     * @param int $count Quantidade
     * @param int $type Tipo de hóspede
     * @param int $age Idade dos hóspedes (apenas crianças)
     * @throws \InvalidArgumentException Quando não enviar a idade para crianças
     */
    public function __construct($count, $type = self::ADULTO, $age = null)
    {
        if ($type == self::CRIANCA && $age === null) {
            throw new InvalidArgumentException('Você deve definir a idade para crianças');
        }

        $this->setCount($count);
        $this->setType($type);
        $this->setAge($age);
    }

    /**
     * Retorna o tipo
     *
     * @return number
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Configura o tipo
     *
     * @param number $type
     * @throws \InvalidArgumentException Quando o tipo for inválido
     */
    protected function setType($type)
    {
        if (!in_array($type, array(self::CRIANCA, self::ADULTO))) {
            throw new InvalidArgumentException('Tipo de hóspede inválido');
        }

        $this->type = $type;
    }

    /**
     * Verifica se o tipo é criança
     *
     * @return boolean
     */
    public function isChildren()
    {
        return $this->getType() == self::CRIANCA;
    }

    /**
     * Retorna a quantidade de hóspedes
     *
     * @return number
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Configura a quantidade de hóspedes
     *
     * @param number $count
     */
    protected function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * Retorna a idade
     *
     * @return number
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Configura a idade
     *
     * @param number $age
     */
    protected function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * Monta a tag XML
     *
     * @return string
     */
    public function createTag()
    {
        $age = null;

        if ($this->isChildren()) {
            $age = ' Age="' . $this->getAge() . '"';
        }

        return
            '<GuestCount' . $age . '
                AgeQualifyingCode="' . $this->getType() . '"
                Count="' . $this->getCount() . '" />';
    }
}
