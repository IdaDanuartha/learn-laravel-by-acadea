<?php

namespace App\Http\Controllers;

use App\Events\Model\User\UserCreated;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

/**
 * @group User Management
 */

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        event(new UserCreated(User::factory()->make()));
        $users = User::with(['comments', 'posts'])->get();

        return new JsonResponse([
            'data' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return "store data";
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): User
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        return "update data";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        return "destroy data";
    }
}
