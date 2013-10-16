<?php
namespace Cmnet\ValueObject;

/**
 * Valor de pagamento
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class Money
{
    /**
     * Código do Real (Brasil)
     *
     * @var string
     */
    const BRAZILIAN_REAL = 'BRL';

    /**
     * Código do Dólar (Estados Unidos)
     *
     * @var string
     */
    const UNITED_STATES_DOLAR = 'USD';

    /**
     * Código do Dólar (Canadá)
     *
     * @var string
     */
    const CANADIAN_DOLAR = 'CAD';

    /**
     * Código do Euro (Europa)
     *
     * @var string
     */
    const EURO = 'EUR';

    /**
     * Código da Libra Esterlina (Reino Unido)
     *
     * @var string
     */
    const BRITISH_POUND = 'GBP';

    /**
     * Código do Dólar (Austrália)
     *
     * @var string
     */
    const AUSTRALIAN_DOLAR = 'AUD';

    /**
     * Quantidade
     *
     * @var float
     */
    private $ammount;

    /**
     * Código da moeda
     *
     * @var string
     */
    private $currency;

    /**
     * Inicializa o objeto
     *
     * @param float $ammount Quantidade
     * @param string $currency Código da moeda
     */
    public function __construct($ammount, $currency = self::BRAZILIAN_REAL)
    {
        $this->setAmmount($ammount);
        $this->setCurrency($currency);
    }

    /**
     * Retorna a quantidade
     *
     * @return number
     */
    public function getAmmount()
    {
        return $this->ammount;
    }

    /**
     * Configura a quantidade
     *
     * @param number $ammount
     */
    protected function setAmmount($ammount)
    {
        $this->ammount = $ammount;
    }

    /**
     * Retorna a moeda
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Configura a moeda
     *
     * @param string $currency
     */
    protected function setCurrency($currency)
    {
        $this->currency = $currency;
    }
}
