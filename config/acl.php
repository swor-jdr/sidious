<?php
return [
    "actions" => [
        '*' => 'Tout',
        'viewAny' => 'Voir tous',
        'view' => 'Voir',
        'create' => 'Créer',
        'update' => 'Modifier',
        'delete' => 'Supprimer',
        'restore' => 'Restaurer',
        'forceDelete' => 'Forcer la suppression',
    ],
    "entities" => [
        '*' => 'Tout',
        'App\User' => 'Utilisateur',
        \Modules\Personnages\Models\Personnage::class => 'Personnage',
        'Silber\Bouncer\Database\Role' => 'Role',
        'Silber\Bouncer\Database\Ability' => 'Ability',
    ]
];
