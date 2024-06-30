<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Repository\TrancheHoraireRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use CalendarBundle\Event\CalendarEvent;
use CalendarBundle\Entity\Event;

class EmploiDuTempsSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private TrancheHoraireRepository $tranchesRepository,
        private UrlGeneratorInterface $router
    ){
    } 

    public static function getSubscribedEvents(): array
    {
        return [
            CalendarEvent::class => 'onCalendarSetData',
            ];
    }

    public function onCalendarSetData(CalendarEvent $setDataEvent)
    {
        $start = $setDataEvent->getStart();
        $end = $setDataEvent->getEnd();
        $filters = $setDataEvent->getFilters();

        // Modify the query to fit to your entity and needs
        // Change booking.beginAt by your start date property
        $bookings = $this->tranchesRepository->findAll()
            /*->createQueryBuilder('booking')
            ->where('booking.debut BETWEEN :start and :end OR booking.fin BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()*/
        ;

        foreach ($bookings as $booking) {
            // this create the events with your data (here booking data) to fill calendar
            $bookingEvent = new Event(
                $booking->getMatiere()->__toString(),
                $booking->getDebut(),
                $booking->getFin() // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             */
            $bookingEvent->setOptions([
                'backgroundColor' => 'red',
                'borderColor' => 'red',
            ]);
            
            $bookingEvent->addOption(
                'url',
                $this->router->generate('app_tranche_horaire_showing', [
                    'id' => $booking->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $setDataEvent->addEvent($bookingEvent);
        }
    }
}
