<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\User;
use App\Transformer\UserAccountTransformer;


class UserController extends Controller
{
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index()
    {
        //Get all users
        $userAccounts = User::paginate(15);
        // Return a collection of $task with pagination
        return $this->response->withPaginator($userAccounts, new  UserAccountTransformer());
    }

    public function show($id)
    {
        //Get the user
        $userAccount = User::find($id);
        if (!$userAccount) {
            return $this->response->errorNotFound('User Not Found');
        }
        // Return a single user account
        return $this->response->withItem($userAccount, new  UserAccountTransformer());
    }

    public function destroy($id)
    {
        //Get the user
        $userAccount = User::find($id);
        if (!$userAccount) {
            return $this->response->errorNotFound('User Not Found');
        }

        if($userAccount->delete()) {
            return $this->response->withItem($userAccount, new  UserAccountTransformer());
        } else {
            return $this->response->errorInternalError('Could not delete a user');
        }

    }

    public function store(Request $request)  {

        $userAccount = new User;

        $userAccount->id = $request->input('id');
        $userAccount->password = $request->input('password');
        $userAccount->sagename = $request->input('sagename');
        $userAccount->realname = $request->input('realname');
        $userAccount->email = $request->input('email');

        if($userAccount->save()) {
            return $this->response->withItem($userAccount, new  UserAccountTransformer());
        } else {
            return $this->response->errorInternalError('Could not create a user account');
        }

    }

    public function edit(Request $request,$id) {
        $userAccount = User::find($id);
        if (!$userAccount) {
            return $this->response->errorNotFound('User Account ID Not Found');
        }
        else {
            $userAccount->id = $id;
            $userAccount->password = $request->input('password');
            $userAccount->sagename = $request->input('sagename');
            $userAccount->realname = $request->input('realname');
            $userAccount->email = $request->input('email');
        }

        if($userAccount->save()) {
            return $this->response->withItem($userAccount, new  UserAccountTransformer());
        } else {
            return $this->response->errorInternalError('Could not create a user account');
        }
    }

}
