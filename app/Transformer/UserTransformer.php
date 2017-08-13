<?php
/**
 * Created by PhpStorm.
 * User: Anthony
 * Date: 8/10/2017
 * Time: 1:47 PM
 */
namespace App\Transformer;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform($userAccount) {
        return [
            'id' => $userAccount->id,
            'name' => $userAccount->name,
            'sagename' => $userAccount->sagename,
            'email' => $userAccount->email,
            'password' => $userAccount->password,
        ];
    }
}