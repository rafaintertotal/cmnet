<?php
namespace Cmnet\Service\Requests;

use \Cmnet\ValueObject\RequestorIdentification;
use \Cmnet\ValueObject\Reservation\GuestList;
use \Cmnet\ValueObject\Payment\Payment;
use \Cmnet\Util\DateTimeInterval;
use \Cmnet\ValueObject\Money;
use \SoapClient;
use \stdClass;
use \SoapVar;

/**
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class IncluiOuAlteraReservaRequest implements CmnetRequest
{
    /**
     * Identificação para a requisição enviada pelo cliente
     *
     * @var string
     */
    private $token;

    /**
     * Identificação do parceiro/empresa no CMNet
     *
     * @var \Cmnet\ValueObject\RequestorIdentification
     */
    private $identification;

    /**
     * Identificação do hotel no CMNet
     *
     * @var int
     */
    private $hotelId;

    /**
     * Código da acomodação
     *
     * @var string
     */
    private $roomTypeId;

    /**
     * Valor de custo da acomodação
     *
     * @var \Cmnet\ValueObject\Money
     */
    private $costs;

    /**
     * Informações sobre os hóspedes
     *
     * @var \Cmnet\ValueObject\Reservation\GuestList
     */
    private $guests;

    /**
     * Período da reserva
     *
     * @var \Cmnet\Util\DateTimeInterval
     */
    private $interval;

    /**
     * Forma de pagamento
     *
     * @var \Cmnet\ValueObject\Payment\Payment
     */
    private $payment;

    /**
     * Nome do responsável pela reserva
     *
     * @var string
     */
    private $name;

    /**
     * Sobrenome do responsável pela reserva
     *
     * @var string
     */
    private $surname;

    /**
     * Email do responsável pela reserva
     *
     * @var string
     */
    private $email;

    /**
     * Celular do responsável pela reserva (envio de SMS com confirmação)
     *
     * @var string
     */
    private $cellphone;

    /**
     * Comentários gerais sobre a reserva
     *
     * @var string
     */
    private $comments;

    /**
     * Cupom de promoção
     *
     * @var string
     */
    private $promotionCode;

    /**
     * Número da reserva (para alteração)
     *
     * @var int
     */
    private $reservationId;

    /**
     * Inicializa o objeto
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param \Cmnet\ValueObject\RequestorIdentification $identification Identificação do parceiro/empresa no CMNet
     * @param int $hotelId Identificação do hotel no CMNet
     * @param string $roomTypeId Código da acomodação
     * @param \Cmnet\ValueObject\Money $costs Valor de custo da acomodação
     * @param \Cmnet\ValueObject\Reservation\GuestList $guests Informações sobre os hóspedes
     * @param \Cmnet\Util\DateTimeInterval $interval Período da reserva
     * @param \Cmnet\ValueObject\Payment\Payment $payment Forma de pagamento
     * @param string $name Nome do responsável pela reserva
     * @param string $surname Sobrenome do responsável pela reserva
     * @param string $email Email do responsável pela reserva
     * @param string $cellphone Celular do responsável pela reserva (envio de SMS com confirmação)
     * @param string $comments Comentários gerais sobre a reserva
     * @param string $promotionCode Cupom de promoção
     * @param int $reservationId Número da reserva (para alteração)
     */
    public function __construct(
        $token,
        RequestorIdentification $identification,
        $hotelId,
        $roomTypeId,
        Money $costs,
        GuestList $guests,
        DateTimeInterval $interval,
        Payment $payment,
        $name,
        $surname,
        $email = null,
        $cellphone = null,
        $comments = null,
        $promotionCode = null,
        $reservationId = null
    ) {
        $this->token = $token;
        $this->identification = $identification;
        $this->hotelId = $hotelId;
        $this->roomTypeId = $roomTypeId;
        $this->costs = $costs;
        $this->guests = $guests;
        $this->interval = $interval;
        $this->payment = $payment;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->cellphone = $cellphone;
        $this->comments = $comments;
        $this->promotionCode = $promotionCode;
        $this->reservationId = $reservationId;
    }

    /**
     * @inheritdoc
     * @see \Cmnet\Service\Requests\CmnetRequest::toXml()
     */
    public function toXml($timestamp, $environment, $language)
    {
        $tagReserva = null;
        $tagComentarios = null;
        $tagEmail = null;
        $tagCelular = null;
        $promocao = null;

        if ($this->reservationId !== null) {
            $tagReserva = '<UniqueID Type="14" ID="' . $this->reservationId . '" />';
        }

        if ($this->promotionCode !== null) {
            $promocao = ' PromotionCode="' . $this->promotionCode . '" />';
        }

        if ($this->comments !== null) {
            $tagComentarios =
                '<Comments>
                    <Comment>
                        <Text>' . $this->comments . '</Text>
                    </Comment>
                </Comments>';
        }

        if ($this->email !== null) {
            $tagEmail = '<Email EmailType="1">' . $this->email . '</Email>';
        }

        if ($this->cellphone !== null) {
            $tagCelular = '<WrittenConfInst Telephone="' . $this->cellphone . '" />';
        }

        return
            '<Xml xmlns="http://www.cmnet/xmlwebservices2/">
              <OTA_HotelResRQ xmlns="http://www.opentravel.org/OTA/2003/05"
                  Version="1.003"
                  EchoToken="' . $this->token . '"
                  TimeStamp="' . $timestamp . '"
                  Target="' . $environment . '"
                  PrimaryLangID="' . $language . '">
                  <POS>
                      <Source>
                          <RequestorID Type="' . $this->identification->getType() . '"
                              ID="' . $this->identification->getId() . '"
                              URL="' . $this->identification->getUrl() . '"/>
                      </Source>
                  </POS>
                    <HotelReservations>
                      <HotelReservation>
                          ' . $tagReserva . '
                          <RoomStays>
                              <RoomStay' . $promocao . '>
                                  <RoomTypes>
                                      <RoomType RoomTypeCode="' . $this->roomTypeId . '"/>
                                  </RoomTypes>
                                  <RoomRates>
                                      <RoomRate>
                                          <Rates>
                                              <Rate>
                                                  <Base
                                                      AmountBeforeTax="'
                                                      . number_format($this->costs->getAmmount(), 2, '.', '') . '"
                                                      CurrencyCode="' . $this->costs->getCurrency() . '"/>
                                              </Rate>
                                          </Rates>
                                      </RoomRate>
                                  </RoomRates>
                                  <BasicPropertyInfo HotelCode="' . $this->hotelId . '"/>
                              </RoomStay>
                          </RoomStays>
                          <ResGlobalInfo>
                              ' . $this->guests->createTag(true) . '
                              <TimeSpan Start="' . $this->interval->getStart()->format('Y-m-d') . '"
                                  End="' . $this->interval->getEnd()->format('Y-m-d') . '"/>
                              ' . $tagComentarios . '
                              <Guarantee>
                                  ' . $this->payment->createTag() . '
                              </Guarantee>
                              <Profiles>
                                  <ProfileInfo>
                                      <Profile ProfileType="1">
                                          <Customer>
                                              <PersonName>
                                                  <GivenName>' . $this->name . '</GivenName>
                                                  <Surname>' . $this->surname . '</Surname>
                                              </PersonName>
                                              ' . $tagEmail . '
                                          </Customer>
                                      </Profile>
                                  </ProfileInfo>
                              </Profiles>
                          </ResGlobalInfo>
                      </HotelReservation>
                      ' . $tagCelular . '
                  </HotelReservations>
              </OTA_HotelResRQ>
          </Xml>';
    }

    /**
     * @inheritdoc
     * @see \Cmnet\Service\Requests\CmnetRequest::call()
     */
    public function call(SoapClient $service, $timestamp, $environment, $language)
    {
        $request = new stdClass();
        $request->Xml = new SoapVar(
            $this->toXml($timestamp, $environment, $language),
            XSD_ANYXML
        );

        return $service->xmlIncluiAlteraReserva($request)
                       ->xmlIncluiAlteraReservaResult
                       ->any;
    }
}
