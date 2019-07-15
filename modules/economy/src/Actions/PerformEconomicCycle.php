<?php
namespace Modules\Economy\Actions;

use Carbon\Carbon;
use Lorisleiva\Actions\Action;
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
            (new MakeTransaction)->run([
                "motivation" => $motivation,
                "to" => $fiche->account->id,
                "amount" => abs($fiche->balance),
                "isCredit" => ($fiche->balance >= 0)
            ]);
        }
        event(new CyclePerformed);
    }
}
