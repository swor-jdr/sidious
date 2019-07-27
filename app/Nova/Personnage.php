<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Personnage extends Resource
{
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Joueurs';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Modules\Personnages\Models\Personnage::class;

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
        'id',
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

            Files::make("Avatar", 'avatar')
                ->hideFromIndex(),

            Text::make('Nom', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            BelongsTo::make('Propriétaire', 'owner', 'App\Nova\User'),

            Text::make("Job", "job")
                ->nullable(),

            Text::make("Titre", "title")
                ->nullable(),

            NovaTinyMCE::make("Biographie", "bio")
                ->nullable()
                ->onlyOnForms(),

            Boolean::make("En vie", "alive")
                ->trueValue(true)
                ->falseValue(false),

            Boolean::make("Actif", "active")
                ->trueValue(true)
                ->falseValue(false),

            Boolean::make("Compte Staff", "isStaff")
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
