<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use LogicException;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        return response()
            ->json([
                'error' => null,
                'result' => $events
            ]);
    }

    public function show(Event $event) {
        return response()
            ->json([
                'error' => null,
                'result' => $event
            ]);
    }

    public function join(Event $event, Request $request) {
        try {
            $event->register($request->user()->id);
        } catch(LogicException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'result' => null
            ], 401); 
        }
    }

    public function withdraw(Event $event, Request $request) {
        try {
            $event->remove($request->user()->id);
        } catch(LogicException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'result' => null
            ]); 
        }
    }
}
