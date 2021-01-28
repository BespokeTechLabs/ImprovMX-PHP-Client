<?php

namespace Bespoke\ImprovMX\Entities\Log;

use Bespoke\ImprovMX\Entities\AbstractEntity;
use Illuminate\Support\Carbon;

class Log extends AbstractEntity
{
    public function __construct($parameters = null)
    {
        parent::__construct($parameters);

        $this->created = Carbon::parse($this->created);

        if (!is_array($this->events)) $this->events = [];
        $this->events = array_map(function ($event) {
            return new LogEventComponent($event);
        }, $this->events);
        $this->events = collect($this->events);

        $this->forward = new AuthorComponent($this->forward);
        $this->recipient = new AuthorComponent($this->recipient);
        $this->sender = new AuthorComponent($this->sender);
    }

    public $created;
    public $createdRaw;
    public $events;
    public $forward;
    public $hostname;
    public $id;
    public $messageId;
    public $recipient;
    public $sender;
    public $subject;
    public $transport;
}
