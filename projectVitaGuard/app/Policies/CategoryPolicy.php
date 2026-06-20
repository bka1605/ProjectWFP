<?php
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    public function delete(User $user)
    {
        return ($user->role == "admin") 
            ? Response::allow() 
            : Response::deny("Only admins are allowed to perform this operation");
    }
}