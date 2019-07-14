<?php

namespace Modules\Economy\Controllers;

use App\Http\Controllers\Controller;
use Modules\Economy\Models\Company;
use Modules\Galaxy\Models\Planet;

class CompanyController extends Controller
{
    /**
     * List all companies
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Company[]
     */
    public function index()
    {
        return Company::with("planet", "managers")
            ->all();
    }

    /**
     * Show a company
     *
     * @param Company $company
     * @return Company
     */
    public function show(Company $company)
    {
        return $company->load("planet", "managers", "fiche", "account");
    }

    /**
     * Create company
     *
     * @return mixed
     * @throws \Exception
     */
    public function store()
    {
        $data = request()->only("name", "planet_id");

        try {
            $planet = Planet::findOrFail($data['planet_id']);
            return $planet->companies()->create($data);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Update company
     *
     * @param Company $company
     * @return Company
     * @throws \Exception
     */
    public function update(Company $company)
    {
        $data= request()->only(["name", "planet_id"]);
        try {
            $company->update($data);
            return $company;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Delete a company
     *
     * @param Company $company
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Company $company)
    {
        try {
            $company->delete();
            return response()->json();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
