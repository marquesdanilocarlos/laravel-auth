<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class Post
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update($user)
    {
        $permission = $user->type === 'admin';
        return $permission
            ? Response::allow()
            : Response::deny('Você deve ser admin para realizar esta ação.');
    }

    public function delete($user, $post)
    {
        return $post->owner == $user->id
            ? Response::allow()
            : Response::deny('Você não é o autor deste post.');
    }
}
