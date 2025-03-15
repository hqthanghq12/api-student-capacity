<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class StatusRequestCreateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $statusRequest;

    public $statusRequestNote;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($statusRequest, $statusRequestNote)
    {
        //
        $this->statusRequest = $statusRequest;
        $this->statusRequestNote = $statusRequestNote;
    }

    public function broadcastOn()
    {
        return [
            new Channel("admin-channel." . $this->statusRequest->campus_id),
            new Channel('admin-ho-channel'),
        ];
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->statusRequest->id,
            'created_at' => Carbon::parse($this->statusRequestNote->created_at)->format('H:i'),
            'created_by' => Str::replace(config('util.END_EMAIL_FPT'), '', $this->statusRequest->user->email),
            'campus' => $this->statusRequest->campus->name,
            'link' => route('admin.status-requests.detail', $this->statusRequest->id),
        ];
    }
}
