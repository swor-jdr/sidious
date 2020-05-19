<?php
namespace Modules\Economy\Projectors;

use Modules\Economy\Actions\MakeTransaction;
use Modules\Economy\Events\TransactionOrder;
use Spatie\EventSourcing\Projectors\Projector;
use Spatie\EventSourcing\Projectors\ProjectsEvents;

class AccountProjector implements Projector
{
    use ProjectsEvents;

    protected array $handlesEvents = [
        TransactionOrder::class => MakeTransaction::class
    ];
}
