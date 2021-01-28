<?php


namespace Bespoke\ImprovMX\Entities\Log;


use Bespoke\ImprovMX\Entities\AbstractEntity;
use Illuminate\Support\Carbon;

class LogEventComponent extends AbstractEntity
{
    public function __construct($parameters = null)
    {
        parent::__construct($parameters);
        $this->created = Carbon::parse($this->created);
        $this->recipient = new AuthorComponent($this->recipient);
    }

    public $code;
    public $created;
    public $id;
    public $local;
    public $message;
    public $recipient;
    public $server;
    public $status;
}
