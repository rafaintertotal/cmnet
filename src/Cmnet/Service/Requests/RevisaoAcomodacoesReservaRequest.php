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
 * Requisição para revisão das acomodações reservadas
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class RevisaoAcomodacoesReservaRequest implements CmnetRequest
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
     * @var string
     */
    private $hotelId;

    /**
     * Código da acomodação
     *
     * @var string
     */
    private $roomTypeId;

    /**
     * Informações sobre os hóspedes
     *
     * @var \Cmnet\ValueObject\Reservation\GuestList
     */
    private $guests;

    /**
     * Período de disponibilidade solicitado
     *
     * @var \Cmnet\Util\DateTimeInterval
     */
    private $interval;

    /**
     * Cupom de desconto para a reserva
     *
     * @var string
     */
    private $promotionCode;

    /**
     * Número da reserva
     *
     * @var int
     */
    private $reservationId;

    /**
     * Inicializa o objeto de requisição
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param \Cmnet\ValueObject\RequestorIdentification $identification Identificação do parceiro/empresa no CMNet
     * @param int $hotelId Identificação do hotel no CMNet
     * @param string $roomTypeId Código da acomodação
     * @param \Cmnet\ValueObject\Reservation\GuestList $guests Informações sobre os hóspedes
     * @param \Cmnet\Util\DateTimeInterval $interval Período de disponibilidade solicitado
     * @param string $promotionCode Cupom de desconto para a reserva
     * @param int $reservationId Número da reserva
     */
    public function __construct(
        $token,
        RequestorIdentification $identification,
        $hotelId,
        $roomTypeId,
        GuestList $guests,
        DateTimeInterval $interval,
        $promotionCode = null,
        $reservationId = null
    ) {
        $this->token = $token;
        $this->identification = $identification;
        $this->hotelId = $hotelId;
        $this->roomTypeId = $roomTypeId;
        $this->guests = $guests;
        $this->interval = $interval;
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
        $promocao = null;

        if ($this->reservationId !== null) {
            $tagReserva =
                '<HotelReservationIDs>
                    <HotelReservationID ResID_Type="14" ResID_Value="' . $this->reservationId . '" />
                </HotelReservationIDs>';
        }

        if ($this->promotionCode !== null) {
            $promocao = ' PromotionCode="' . $this->promotionCode . '" />';
        }

        return
            '<Xml xmlns="http://www.cmnet/xmlwebservices2/">
              <OTA_HotelAvailRQ xmlns="http://www.opentravel.org/OTA/2003/05"
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
                    <AvailRequestSegments>
                      <AvailRequestSegment AvailReqType="Room">
                          <StayDateRange Start="' . $this->interval->getStart()->format('Y-m-d') . '"
                                  End="' . $this->interval->getEnd()->format('Y-m-d') . '"/>
                          <RoomStayCandidates>
                              <RoomStayCandidate RoomTypeCode="' . $this->roomTypeId . '"' . $promocao . '>
                                  ' . $this->guests->createTag() . '
                              </RoomStayCandidate>
                          </RoomStayCandidates>
                          <HotelSearchCriteria>
                              <Criterion>
                                  <HotelRef HotelCode="' . $this->hotelId . '" />
                              </Criterion>
                          </HotelSearchCriteria>
                      </AvailRequestSegment>
                  </AvailRequestSegments>
                  ' . $tagReserva . '
              </OTA_HotelAvailRQ>
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

        return $service->xmlRevisaoDispHotel($request)
                       ->xmlRevisaoDispHotelResult
                       ->any;
    }
}
