<?php
namespace Cmnet\ValueObject\Payment;

/**
 * Pagamento da reserva através da empresa
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class Voucher implements Payment
{
    /**
     * Tipos de gastos cobertos pela empresa
     *
     * @var string
     */
    private $type;

    /**
     * Inicializa o objeto
     *
     * @param string $type Tipos de gastos cobertos pela empresa
     */
    public function __construct($type)
    {
        $this->setType($type);
    }

    /**
     * Retorna os tipos de gastos cobertos pela empresa
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Configura os tipos de gastos cobertos pela empresa
     *
     * @param string $type
     */
    protected function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @inheritdoc
     * @see \Cmnet\ValueObject\Payment\Payment::createTag()
     */
    public function createTag()
    {
        return
            '<GuaranteesAccepted>
                <GuaranteeAccepted>
                    <Voucher CardCode="' . $this->getIssuer() . '"
                        CardNumber="' . $this->getNumber() . '"
                        ExpireDate="' . $this->getExpireDate() . '"
                        SeriesCode="' . $this->getSecurityCode() . '">
                        <CardHolderName>' . $this->getName() . '</CardHolderName>
                </GuaranteeAccepted>
            </GuaranteesAccepted>';
    }
}
