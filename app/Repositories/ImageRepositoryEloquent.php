<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ImageRepository;
use App\Entities\Image;
use App\Validators\ImageValidator;

/**
 * Class ImageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ImageRepositoryEloquent extends BaseRepository implements ImageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Image::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    /**
     * Upload the image
     * @param $image
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function uploadImage($image, $name=null)
    {
        return $this->upload($image);
    }
    /**
     * Upload the image
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    private function upload($image, $name=null)
    {
        try{
            $name == null ? $name = uniqid() : $name = $name;
            $path = Storage::disk('public')->put('images', $image);
            $uploadedImage = Image::create([
                'path' => $path,
                'name' => $name,
            ]);
            return $uploadedImage;
        }catch (\Exception $exception){
            return response('Internal Server Error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
