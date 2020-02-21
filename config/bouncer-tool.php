<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Entities
    |--------------------------------------------------------------------------
    |
    | The entities that are displayed in the Entity Type field in the Ability
    | resource.
    |
    */

    'entities' => [
        '*' => 'Tout',
        'App\User' => 'Utilisateur',
        \Modules\Personnages\Models\Personnage::class => 'Personnage',
        'Silber\Bouncer\Database\Role' => 'Role',
        'Silber\Bouncer\Database\Ability' => 'Ability',
    ],

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    |
    | The actions that are displayed in the Name field in the Ability
    | resource.
    |
    */

    'actions' => [
        '*' => 'Tout',
        'viewAny' => 'Voir tous',
        'view' => 'Voir',
        'create' => 'Créer',
        'update' => 'Modifier',
        'delete' => 'Supprimer',
        'restore' => 'Restaurer',
        'forceDelete' => 'Forcer la suppression',
    ],

];
