<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()
            ->json(EventResource::collection(Event::with(['owner', 'attendees'])->latest()->paginate(10)))
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TODO: remove this placeholder, and add the authenticated user instead
        $currentUserId = 2;

        $validated = $request->validate([
            'name' => ['bail', 'sometimes', 'string', 'max:255'],
            'description' => ['bail', 'sometimes', 'string'],
            'price_in_pennies' => ['bail', 'sometimes', 'numeric'],
            'total_seats' => ['bail', 'sometimes', 'numeric'],
            'group_discount' => ['bail', 'nullable', 'decimal:2', 'min:0', 'max:1'],
            'start_time' => ['bail', 'sometimes', 'date', 'after_or_equal:now'],
            'end_time' => ['bail', 'sometimes', 'date', 'after:start_time'],
        ]);

        $validated['user_id'] = $currentUserId;

        $event = Event::create($validated);

        return response()->json(new EventResource($event))->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return response()->json(new EventResource($event->loadMissing(['owner', 'attendees'])))->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => ['bail', 'nullable', 'string', 'max:255'],
            'description' => ['bail', 'nullable', 'string'],
            'price_in_pennies' => ['bail', 'nullable', 'numeric'],
            'total_seats' => ['bail', 'nullable', 'numeric'],
            'group_discount' => ['bail', 'nullable', 'decimal:2', 'min:0', 'max:1'],
            'start_time' => ['bail', 'nullable', 'date', 'after_or_equal:now'],
            'end_time' => ['bail', 'nullable', 'date', 'after:start_time'],
        ]);

        $event->update($validated);

        return response()->json(new EventResource($event))->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response()->setStatusCode(204);
    }
}
