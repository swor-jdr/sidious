<?php
namespace Modules\Economy\Checks;

use BeyondCode\SelfDiagnosis\Checks\Check;
use Inani\LaravelNovaConfiguration\Helpers\Configuration;

class LastEconomicCycleCheck implements Check
{
    /**
     * The name of the check.
     *
     * @param array $config
     * @return string
     */
    public function name(array $config): string
    {
        return 'Last Economic Cycle is set';
    }

    /**
     * Perform the actual verification of this check.
     *
     * @param array $config
     * @return bool
     */
    public function check(array $config): bool
    {
        return Configuration::get("LAST_ECONOMIC_CYCLE", false);;
    }

    /**
     * The error message to display in case the check does not pass.
     *
     * @param array $config
     * @return string
     */
    public function message(array $config): string
    {
        return 'Economic cycles cannot run without a \"m Y\" date set in LAST_ECONOMIC_CYCLE var in Configuration';
    }
}
