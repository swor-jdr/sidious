<?php

namespace Modules\Economy\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Economy\Models\EconomyLine;
use Modules\Economy\Models\Fiche;

class EconomyLineController extends Controller
{
    /**
     * Get all lines in a fiche
     *
     * @param Fiche $fich
     * @return Fiche
     */
    public function index(Fiche $fich)
    {
        return $fich->load("lines");
    }

    /**
     * Show a single economy line
     *
     * @param Fiche $fich
     * @param EconomyLine $economy_line
     * @return EconomyLine
     */
    public function show(Fiche $fich, EconomyLine $economy_line)
    {
        return $economy_line;
    }

    /**
     * Create line in a fiche
     *
     * @param Fiche $fich
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function store(Fiche $fich)
    {
        $data = request()->only(['isCredit', 'motivation', 'amount']);

        try {
            $line = $fich->lines()->create($data);
            return $line;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Update an economy line
     *
     * @param Fiche $fich
     * @param EconomyLine $economy_line
     * @return EconomyLine
     * @throws \Exception
     */
    public function update(Fiche $fich, EconomyLine $economy_line)
    {
        $data = request()->only(['isCredit', 'motivation', 'amount']);

        DB::beginTransaction();
        try {
            $difference = $data['amount'] - $economy_line->amount;
            $isCredit = ($difference >= 0);

            $economy_line->update($data);
            $fich->updateBalance(abs($difference), $isCredit);

            DB::commit();
            return $economy_line;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * Remove economy line
     *
     * @param Fiche $fich
     * @param EconomyLine $economy_line
     * @return EconomyLine
     * @throws \Exception
     */
    public function destroy(Fiche $fich, EconomyLine $economy_line)
    {
        try {
            $economy_line->delete();
            return $economy_line;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Validate economy line
     *
     * @param Fiche $fich
     * @param int $number
     * @return EconomyLine
     */
    public function validation(Fiche $fich, $number)
    {
        $economyLine = EconomyLine::findOrFail($number);
        $economyLine->isValidated = true;
        $economyLine->validatedBy = request()->user()->id;
        $economyLine->save();

        return $economyLine;
    }
}
