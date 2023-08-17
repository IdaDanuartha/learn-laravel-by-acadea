<?php

namespace App\Repositories;

use App\Events\Model\User\UserCreated;
use App\Exceptions\GeneralJsonException;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository
{
    public function store(array $attributes) 
    {
        return DB::transaction(function() use ($attributes) {
            $created = User::create([
                'name' => data_get($attributes, 'name'),
                'email' => data_get($attributes, 'email'),
            ]);

            throw_if(!$created, GeneralJsonException::class, "Failed to create model user");
            event(new UserCreated($created));
            return $created;
        });
    }
    
    /**
     * @param User $user
     * @param array $attributes
     * @return mixed
     */
    public function update($user, array $attributes) 
    {
        //
    }

        /**
     * @param User $user
     * @return mixed
     */
    public function forceDelete($user) {
        //
    }
}
