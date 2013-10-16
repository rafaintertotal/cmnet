<?php
namespace Cmnet\Service\Requests;

use \Cmnet\ValueObject\Reservation\HotelSearchCriteria;
use \Cmnet\ValueObject\Reservation\GuestList;
use \Cmnet\ValueObject\RequestorIdentification;
use \Cmnet\Util\DateTimeInterval;
use \SoapClient;
use \stdClass;
use \SoapVar;
use \InvalidArgumentException;

/**
 * Requisição para consulta de disponibilidade do Hotel
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class ConsultaDisponibilidadeHotelRequest implements CmnetRequest
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
     * Período de disponibilidade
     *
     * @var \Cmnet\Util\DateTimeInterval
     */
    private $interval;

    /**
     * Informações sobre os hóspedes
     *
     * @var \Cmnet\ValueObject\Reservation\GuestList
     */
    private $guests;

    /**
     * Parâmetros sobre o hotel
     *
     * @var \Cmnet\ValueObject\Reservation\HotelSearchCriteria
     */
    private $criteria;

    /**
     * Número da reserva
     *
     * @var int
     */
    private $reservationId;

    /**
     * Inicializa o objeto
     *
     * @param string $token Identificação para a requisição enviada pelo cliente
     * @param \Cmnet\ValueObject\RequestorIdentification $identification Identificação do parceiro/empresa no CMNet
     * @param \Cmnet\Util\DateTimeInterval $interval Período de disponibilidade
     * @param \Cmnet\ValueObject\Reservation\GuestList $guests Informações sobre os hóspedes
     * @param \Cmnet\ValueObject\Reservation\HotelSearchCriteria $criteria Parâmetros sobre o hotel
     * @param int $reservationId Número da reserva
     * @throws \InvalidArgumentException Quando o período de consulta ultrapassa 60 dias
     */
    public function __construct(
        $token,
        RequestorIdentification $identification,
        DateTimeInterval $interval,
        GuestList $guests,
        HotelSearchCriteria $criteria,
        $reservationId = null
    ) {
        if ($interval->getDiff()->format('%a') > 60) {
            throw new InvalidArgumentException('Período de consulta não pode ultrapassar 60 dias');
        }

        $this->token = $token;
        $this->identification = $identification;
        $this->interval = $interval;
        $this->guests = $guests;
        $this->criteria = $criteria;
        $this->reservationId = $reservationId;
    }

    /**
     * @inheritdoc
     * @see \Cmnet\Service\Requests\CmnetRequest::toXml()
     */
    public function toXml($timestamp, $environment, $language)
    {
        $tagReserva = '';

        if ($this->reservationId !== null) {
            $tagReserva =
                '<HotelReservationIDs>
                    <HotelReservationID ResID_Type="14" ResID_Value="' . $this->reservationId . '"/>
                </HotelReservationIDs>';
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
                          <StayDateRange
                              Start="' . $this->interval->getStart()->format('Y-m-d') . '"
                              End="' . $this->interval->getEnd()->format('Y-m-d') . '"/>
                          <RateRange/>
                          <RoomStayCandidates>
                              <RoomStayCandidate>
                                  ' . $this->guests->createTag() . '
                              </RoomStayCandidate>
                          </RoomStayCandidates>
                          ' . $this->criteria->createTag() . '
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

        return $service->xmlConsultaDispHotelValorDiaDia($request)
                       ->xmlConsultaDispHotelValorDiaDiaResult
                       ->any;
    }
}
