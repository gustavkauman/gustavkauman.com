<?php

namespace App\Http\Controllers;

use App\UserGroup;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{

    /**
     * Return the array of all user groups.
     * This method is meant to be *only* called in an API fashion.
     *
     * @param Request $request
     * @return UserGroup[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        $groups = UserGroup::all();

        return $groups;
    }

    /**
     * Store the user group in the database.
     * This method is meant to be *only* called in an API fashion.
     *
     * @param Request $request
     * @return UserGroup
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', UserGroup::class);

        $data = $this->validateRequest();

        return UserGroup::create($data);
    }

    /**
     * Validate the request made to the server
     *
     * @return array data
     */
    private function validateRequest() {
       return request()->validate([
           'name' => 'required|string',
           'description' => 'required|string'
       ]);
    }


}
