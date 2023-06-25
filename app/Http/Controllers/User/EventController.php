<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use LogicException;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = $request->user()
                    ->events;

        return response()
                ->json([
                    'result' => $events
                ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string']
        ]);

        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'author' => $request->user()->id
        ]);

        return response()->json([
            'error' => null,
            'result' => $event
        ]);
    }

    public function destroy(Event $event) {
        try {
            $event->participants()->detach();
            $event->delete();
        } catch(LogicException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'result' => null
            ], 401); 
        }
    }
}
