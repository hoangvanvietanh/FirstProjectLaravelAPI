<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\User;

/**
 * Class UserTransformer.
 *
 * @package namespace App\Transformers;
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Transform the User entity.
     *
     * @param \App\Entities\User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */
            'name'=>$model->name,
            'gender'=>$model->gender,
            'address'=>$model->address,
            'phone_number'=>$model->phone_number,
            'department'=>$model->department,
            'birth_day'=>$model->birth_day,
            'birth_place'=>$model->birth_place,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
