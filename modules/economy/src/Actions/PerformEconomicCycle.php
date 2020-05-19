<?php
namespace Modules\Economy\Actions;

use Carbon\Carbon;
use Lorisleiva\Actions\Action;
use Modules\Economic\Jobs\ProcessEconomicTransfer;
use Modules\Economy\Events\CyclePerformed;
use Modules\Economy\Models\Fiche;

class PerformEconomicCycle extends Action
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    public function handle()
    {
        $fiches = Fiche::all();
        $motivation = "Cycle Economique | " . Carbon::now()->format(" m Y");
        foreach ($fiches as $fiche) {
            ProcessEconomicTransfer::dispatch($motivation, abs($fiche->balance), $fiche->account->id, null);
        }
        event(new CyclePerformed);
    }
}
