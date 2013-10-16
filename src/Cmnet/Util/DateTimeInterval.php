<?php
namespace Cmnet\Util;

use \DateTime;

/**
 * Período entre duas datas
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class DateTimeInterval
{
    /**
     * Data inicial
     *
     * @var \DateTime
     */
    private $start;

    /**
     * Data final
     *
     * @var \DateTime
     */
    private $end;

    /**
     * Inicializa o objeto
     *
     * @param \DateTime $start Data inicial
     * @param \DateTime $end Data final
     */
    public function __construct(DateTime $start, DateTime $end)
    {
        $this->setStart($start);
        $this->setEnd($end);
    }

    /**
     * Retorna a data inicial
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Configura a data inicial
     *
     * @param \DateTime $start
     */
    public function setStart(DateTime$start)
    {
        $this->start = $start;
    }

    /**
     * Retorna a data final
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Configura a data final
     *
     * @param \DateTime $end
     */
    public function setEnd(DateTime $end)
    {
        $this->end = $end;
    }

    /**
     * Retorna a diferença entre as duas datas
     *
     * @return \DateInterval
     */
    public function getDiff()
    {
        return $this->getStart()->diff($this->getEnd());
    }
}
