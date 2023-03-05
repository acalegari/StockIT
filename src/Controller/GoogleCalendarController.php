<?php

namespace App\Controller;


use App\Repository\ReservationsRepository;
use ContainerMzKGXCE\getGoogleCalendarControllerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Google\Service\Calendar;
use Google_Client;

class GoogleCalendarController extends AbstractController
{
    private ClientRegistry $clientRegistry;
    private EntityManagerInterface $entityManager;

    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $entityManager)
    {
        $this->clientRegistry = $clientRegistry;
        $this->entityManager = $entityManager;
    }


    #[Route('/google/calendar', name: 'app_google_calendar')]
    public function index(ReservationsRepository $reservationsRepository, Request $request): Response
    {

    

        $client = $this->clientRegistry->getClient('google_main');
        
         /** @var Google_Client $client */
        $client = new Google_Client();
        $client->setClientId('GOOGLE_CLIENT_ID');
        $client->addScope(Calendar::CALENDAR);
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php');
        $client->setAccessType('offline');        // offline access
        $client->setIncludeGrantedScopes(true);   // incremental auth
      
        
        $events = $reservationsRepository->findAll();
        $reservation = [];

        //array format json of event
        foreach($events as $event) {
            $reservation[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBackgroundColor(),
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor(),
                'allDay' => $event->isAllDay(),
                'creator' => $event->getCreator(),
                'summary' => $event->getSummary(),
                'status' => $event->getStatus()
            ];
        }

        $data = json_encode($reservation);

        return $this->render('google_calendar/index.html.twig', compact('data'));
    }
}
