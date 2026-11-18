<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Users\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;


class UserController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return $this->unauthorizedResponse();
        }
        // $this->authorize('isAdmin');

        $users = User::latest()->paginate(10);

        return $this->sendResponse($users, 'Users list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Users\UserRequest  $request
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRequest $request)
    {
        if (!Gate::allows('isAdmin')) {
            return $this->unauthorizedResponse();
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),          
            'locations' => $request['locations'],
            'cashAccounts' => $request['cashAccounts'],
            'cardAccounts' => $request['cardAccounts'],
            'onlineAccounts' => $request['onlineAccounts'],
            'gpayAccounts' => $request['gpayAccounts'],
            'phonepeAccounts' => $request['phonepeAccounts'],
            'amazonpayAccounts' => $request['amazonpayAccounts'],
        ]);

        return $this->sendResponse($user, 'User Created Successfully');
    }

    /**
     * Update the resource in storage
     *
     * @param  \App\Http\Requests\Users\UserRequest  $request
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(UserRequest $request, $id)
    {
        if (!Gate::allows('isAdmin')) {
            return $this->unauthorizedResponse();
        }

        $user = User::findOrFail($id);

        if (!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);
        }
        $request->merge([
          'locations' => $request['locations'],
          'cashAccounts' => $request['cashAccounts'],
          'cardAccounts' => $request['cardAccounts'],
          'onlineAccounts' => $request['onlineAccounts'],
          'gpayAccounts' => $request['gpayAccounts'],
          'phonepeAccounts' => $request['phonepeAccounts'],
          'amazonpayAccounts' => $request['amazonpayAccounts'],
        ]);

        $user->update($request->all());

        return $this->sendResponse($user, 'User Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $user = User::findOrFail($id);
        // delete the user

        $user->delete();

        return $this->sendResponse([$user], 'User has been Deleted');
    }
}
