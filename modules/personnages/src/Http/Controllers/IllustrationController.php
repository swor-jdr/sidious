<?php
namespace Modules\Personnages\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Personnages\Models\Personnage;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class IllustrationController extends Controller
{
    /**
     * Set illustration images
     *
     * @param Personnage $personnage
     * @return Personnage
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function illustrate(Personnage $personnage)
    {
        request()->validate([
            "avatar" => "image|mimes:jpeg,png,jpg,gif|max:2048",
            "banner" => "image|mimes:jpeg,png,jpg,gif|max:2048",
        ]);

        if(request()->hasFile("avatar") && request()->file("avatar")->isValid()) {
            $personnage->addMediaFromRequest('avatar')->toMediaCollection('avatar');
            $thumb = $personnage->getMedia('avatar')->first()->getUrl('thumb');
            $regular = $personnage->getMedia('avatar')->first()->getUrl('regular');

            $personnage->avatar_tiny = $thumb;
            $personnage->avatar_regular = $regular;
            $personnage->save();
        }

        if(request()->hasFile("banner") && request()->file("banner")->isValid()) {
            $personnage->addMediaFromRequest('banner')->toMediaCollection('banner');
            $banner = $personnage->getMedia('banner')->first()->getUrl('banner');

            $personnage->banner_url = $banner;
            $personnage->save();
        }

        if(!request()->hasFile("banner") && !request()->hasFile("avatar"))
        {
            throw new BadRequestException("no file given");
        }

        return $personnage;
    }
}
