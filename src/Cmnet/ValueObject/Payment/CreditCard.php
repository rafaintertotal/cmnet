<?php
namespace Cmnet\ValueObject\Payment;

use \InvalidArgumentException;

/**
 * Pagamento da reserva através de cartão de crédito
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class CreditCard implements Payment
{
    /**
     * Código da bandeira American Express
     *
     * @var string
     */
    const AMERICAN_EXPRESS = 'AX';

    /**
     * Código da bandeira Bank Card
     *
     * @var string
     */
    const BANK_CARD = 'BC';

    /**
     * Código da bandeira Cate Bleu
     *
     * @var string
     */
    const CARTE_BLEU = 'BL';

    /**
     * Código da bandeira Carte Blanche
     *
     * @var string
     */
    const CARTE_BLANCHE = 'CB';

    /**
     * Código da bandeira Dinners
     *
     * @var string
     */
    const DINERS_CLUB = 'DN';

    /**
     * Código da bandeira Discover Card
     *
     * @var string
     */
    const DISCOVER_CARD = 'DS';

    /**
     * Código da bandeira Eurocard
     *
     * @var string
     */
    const EUROCARD = 'EC';

    /**
     * Código da bandeira JCB Credit Card
     *
     * @var string
     */
    const JCB_CREDIT_CARD = 'JC';

    /**
     * Código da bandeira Mastercard
     *
     * @var string
     */
    const MASTERCARD = 'MC';

    /**
     * Código da bandeira Universal Air Travel Card
     *
     * @var string
     */
    const UNIVERSAL_AIR_TRAVEL_CARD = 'TP';

    /**
     * Código da bandeira VISA
     *
     * @var string
     */
    const VISA = 'VI';

    /**
     * Código da bandeira
     *
     * @var string
     */
    private $issuer;

    /**
     * Número do cartão
     *
     * @var string
     */
    private $number;

    /**
     * Data de expiração (mmYY)
     *
     * @var string
     */
    private $expireDate;

    /**
     * Código de segurança
     *
     * @var int
     */
    private $securityCode;

    /**
     * Nome impresso no cartão
     *
     * @var string
     */
    private $name;

    /**
     * Número de parcelas
     *
     * @var int
     */
    private $installments;

    /**
     * @param string $issuer Código da bandeira
     * @param string $number Número do cartão
     * @param string $expireDate Data de expiração (mmYY)
     * @param int $securityCode Código de segurança
     * @param string $name Nome impresso no cartão
     * @param int $installments Número de parcelas
     */
    public function __construct($issuer, $number, $expireDate, $securityCode, $name, $installments = 1)
    {
        $this->setIssuer($issuer);
        $this->setNumber($number);
        $this->setExpireDate($expireDate);
        $this->setSecurityCode($securityCode);
        $this->setName($name);
        $this->setInstallments($installments);
    }

    /**
     * Retorna o código da bandeira
     *
     * @return string
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * Configura o código da bandeira
     *
     * @param string $issuer
     * @throws \InvalidArgumentException Quando a bandeira for inválida
     */
    protected function setIssuer($issuer)
    {
        if (!in_array($issuer, $this->getValidIssuers())) {
            throw new InvalidArgumentException('Bandeira não permitida');
        }

        $this->issuer = $issuer;
    }

    /**
     * Retorna as bandeiras permitidas
     *
     * @return array
     */
    protected function getValidIssuers()
    {
        return array(
            self::AMERICAN_EXPRESS, self::BANK_CARD,
            self::CARTE_BLANCHE, self::CARTE_BLEU, self::DINERS_CLUB,
            self::DISCOVER_CARD, self::EUROCARD, self::JCB_CREDIT_CARD,
            self::MASTERCARD, self::UNIVERSAL_AIR_TRAVEL_CARD, self::VISA
        );
    }

    /**
     * Retorna o número do cartão
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Configura o número do cartão
     *
     * @param string $number
     */
    protected function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * Retorna a data de expiração
     *
     * @return string
     */
    public function getExpireDate()
    {
        return $this->expireDate;
    }

    /**
     * Configura a data de expiração
     *
     * @param string $expireDate
     */
    protected function setExpireDate($expireDate)
    {
        $this->expireDate = $expireDate;
    }

    /**
     * Retorna o código de segurança
     *
     * @return number
     */
    public function getSecurityCode()
    {
        return $this->securityCode;
    }

    /**
     * Configura o código de segurança
     *
     * @param number $securityCode
     */
    protected function setSecurityCode($securityCode)
    {
        $this->securityCode = $securityCode;
    }

    /**
     * Retorna o nome impresso no cartão
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Configura o nome impresso no cartão
     *
     * @param string $name
     */
    protected function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Retorna o número de parcelas
     *
     * @return int
     */
    public function getInstallments()
    {
        return $this->installments;
    }

    /**
     * Configura o número de parcelas
     *
     * @param int $installments
     */
    protected function setInstallments($installments)
    {
        $this->installments = $installments;
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
                    <PaymentCard CardCode="' . $this->getIssuer() . '"
                        CardNumber="' . $this->getNumber() . '"
                        ExpireDate="' . $this->getExpireDate() . '"
                        SeriesCode="' . $this->getSecurityCode() . '">
                        <CardHolderName>' . $this->getName() . '</CardHolderName>
                    </PaymentCard>
                </GuaranteeAccepted>
            </GuaranteesAccepted>
            <Comments>
                <Comment CommentOriginatorCode="PARCELAS">
                    <Text>' . $this->getInstallments() . '</Text>
                </Comment>
            </Comments>';
    }
}
