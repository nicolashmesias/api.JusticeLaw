<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    private $calendarService;

    public function __construct(GoogleCalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    public function createMeeting(Request $request)
    {
        $validated = $request->validate([
            'summary' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'attendees' => 'required|array',
            'attendees.*' => 'email',
        ]);

        $event = $this->calendarService->createMeetEvent(
            $validated['summary'],
            $validated['start_time'],
            $validated['end_time'],
            $validated['attendees']
        );

        return response()->json([
            'message' => 'Reunión creada exitosamente',
            'event_link' => $event->getHangoutLink(),
        ]);
    }
}
