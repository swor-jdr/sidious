<?php

namespace App\Nova;

use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Modules\Factions\Models\Group;
use Timothyasp\Color\Color;

class Faction extends Resource
{
    public static $group = "Groupes";

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Group::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Nom', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Color::make("Couleur", "color")
                ->rules('required', 'max:255'),

            NovaTinyMCE::make("Contenu", "content")
                ->nullable(),

            Boolean::make('Secret', 'isSecret')
                ->trueValue(true)
                ->falseValue(false),

            Boolean::make('Privé', 'isPrivate')
                ->trueValue(true)
                ->falseValue(false),

            Boolean::make('Faction', 'isFaction')
                ->trueValue(true)
                ->falseValue(false),

            Boolean::make('Active', 'active')
                ->trueValue(true)
                ->falseValue(false),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
