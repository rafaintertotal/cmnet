<?php
namespace Cmnet\ValueObject\Payment;

/**
 * Pagamento da reserva diretamente no hotel
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class DirectBill implements Payment
{
    /**
     * @inheritdoc
     * @see \Cmnet\ValueObject\Payment\Payment::createTag()
     */
    public function createTag()
    {
        return
            '<GuaranteesAccepted>
                <GuaranteeAccepted>
                    <DirectBill />
                </GuaranteeAccepted>
            </GuaranteesAccepted>';
    }
}
