<?php
namespace Modules\Personnages\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Economy\Traits\HasEconomy;
use Modules\Factions\Models\Assignation;
use Modules\Factions\Models\Group;
use Modules\Factions\Traits\InGroups;
use Modules\Personnages\Events\PersonnageCreated;
use Modules\Personnages\Events\PersonnageDeleted;
use Modules\Personnages\Events\PersonnageUpdated;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Personnage extends Model implements HasMedia
{
    use SoftDeletes, HasSlug, HasMediaTrait, HasRolesAndAbilities, HasEconomy, InGroups;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['alive', 'owner_id'];

    protected $hidden = ["deleted_at"];

    protected $with = ['assignations'];

    public static $rules = [
        "name" => "unique:personnages|min:3|required",
        "owner" => "required",
    ];

    protected $dispatchesEvents = [
        "created" => PersonnageCreated::class,
        "updated" => PersonnageUpdated::class,
        "deleted" => PersonnageDeleted::class,
    ];

    /**
     * Get the options for generating the slug.
     *
     * @return mixed
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Register media collections for the personnage
     *
     * @return void
     */
    public function registerMediaCollections()
    {
        $this->addMediaCollection('avatar')->singleFile();
    }

    /**
     * User this personnage is owned by
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(config("personnages.owner.class"), "owner_id");
    }

    /**
     * Filter staff from casual personnages
     *
     * @param $query
     * @param boolean $bool
     * @return mixed
     */
    public function scopeStaff($query, $bool)
    {
        return $query->where('isStaff', $bool);
    }

    /**
     * Filter active personnages
     *
     * @param $query
     * @param boolean $bool
     * @return mixed
     */
    public function scopeActive($query, $bool)
    {
        return $query->where('active', $bool);
    }

    /**
     * Select by owner
     *
     * @param $query
     * @param $id
     * @return mixed
     */
    public function scopeOf($query, $id)
    {
        return $query->where('owner_id', $id);
    }

    /**
     * Set active to this personnage as given boolean
     *
     * @param bool $active
     * @throws \Exception
     */
    public function setActive(bool $active)
    {
        try {
            $this->active = $active;
            $this->save();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function boot()
    {
        parent::boot();

        static::created(function($model) {
            $personnages = $model->owner->personnages;
            foreach ($personnages as $personnage) $personnage->setActive(false);
            $model->setActive(true);
        });
    }
}
