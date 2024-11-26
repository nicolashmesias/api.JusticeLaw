<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

class GoogleCalendarService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuthConfig(storage_path('app/google-calendar-credentials.json'));
        $this->client->addScope(Calendar::CALENDAR_EVENTS);
    }

    public function createMeetEvent($summary, $startTime, $endTime, $attendees = [])
    {
        $calendarService = new Calendar($this->client);

        $event = new Event([
            'summary' => $summary,
            'start' => ['dateTime' => $startTime, 'timeZone' => 'America/Bogota'],
            'end' => ['dateTime' => $endTime, 'timeZone' => 'America/Bogota'],
            'conferenceData' => [
                'createRequest' => [
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                    'requestId' => 'meet-' . uniqid(),
                ],
            ],
            'attendees' => array_map(fn($email) => ['email' => $email], $attendees),
        ]);

        return $calendarService->events->insert('primary', $event, ['conferenceDataVersion' => 1]);
    }
}
