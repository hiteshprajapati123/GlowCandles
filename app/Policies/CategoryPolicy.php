<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    public function delete(User $user, Category $category): Response
    {
        if ($category->products()->exists()) {
            return Response::deny('Cannot delete category with associated products.');
        }

        return Response::allow();
    }
}
