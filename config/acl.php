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
        \Modules\Forum\Models\Post::class => 'Post',
        \Modules\Forum\Models\Topic::class => 'Topic',
        \Modules\Forum\Models\Forum::class => 'Forum',
        \Modules\Factions\Models\Group::class => 'Faction',
        \Modules\Inventory\Models\ObjectType::class => 'Type',
        \Modules\Inventory\Models\Thing::class => 'Objet',
        \Modules\Inventory\Models\Possession::class => 'Possession',
        \Modules\Economy\Models\Account::class => 'Compte',
        \Modules\Economy\Models\Company::class => 'Entreprise',
        \Modules\Economy\Models\Fiche::class => 'Fiche',
        'Silber\Bouncer\Database\Role' => 'Role',
        'Silber\Bouncer\Database\Ability' => 'Ability',
    ]
];
