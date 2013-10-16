<?php
namespace Cmnet\ValueObject\Payment;

/**
 * Representa os tipos de pagamento aceitos
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
interface Payment
{
    /**
     * Cria o XML
     *
     * @return string
     */
    public function createTag();
}
