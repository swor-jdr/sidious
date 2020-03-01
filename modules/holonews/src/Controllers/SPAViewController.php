<?php
namespace Modules\Holonews\Controllers;

use Modules\Holonews\Holonews;

class SPAViewController
{
    /**
     * Single page application catch-all route.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view('holonews::layout', [
            'winkScriptVariables' => Holonews::scriptVariables(),
        ]);
    }
}
