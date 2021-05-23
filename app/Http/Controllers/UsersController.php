<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Database;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;


class UsersController extends Controller
{
        
        /**
         * This method is used to redirect to user list screen
         * @author Saurabh Kumar <saurabhkumar3012official@gmail.com>
         * @since 23rd May 2021
         */
        public function usersList()
        {
                return view('users.index');
        }
        
        /**
         * This method is for fetching all active users
         * @return datatable collection array
         * @author Saurabh Kumar <saurabhkumar3012official@gmail.com>
         * @since 23rd May 2021
         */
        public function usersListAjaxHandler()
        {
                $userLists = new Collection();
                
                $users = Database::getInstance()->selectQuery([
                        'rawQuery' => 'active = ?',
                        'bindParams' => [1]
                ]);
                
                foreach ($users as $key => $user) {
                        $id = $user['id'];
                        $userLists->push([
                                'id' => $key + 1,
                                'name' => $user['name'],
                                'username' => $user['username'],
                                'email' => $user['email'],
                                'created_at' => date("d-M-Y", $user['created']),
                                'updated_at' => date("d-M-Y", $user['updated']),
                                'action' => '<a class="editUser" style="color:blue;" data-id="' . $id . '" data-toggle="modal"
                                            data-target="#editUserModal"><i class="fa fa-pencil-square-o"></i></a>
                                            &nbsp;&nbsp;
                                            <a class="deleteUser" style="color: red;" data-id="' . $id . '" >
                                                <i class="fa fa-trash-o"></i>
                                            </a>'
                        ]);
                }
                
                return DataTables::of($userLists)->make(true);
        }
        
        /**
         * This method is used for fetching single user details
         * @author Saurabh Kumar <saurabhkumar3012official@gmail.com>
         * @since 23rd May 2021
         */
        public function fetchUserDetails(Request $request)
        {
                if ($request->isMethod('post')) {
                        // Validating inputs
                        $validator = Validator::make($request->all(), [
                                'id' => 'required|integer',
                        ]);
                        if ($validator->fails()) {
                                return apiResponse(401,
                                        array_values(json_decode($validator->errors(), true))[0],
                                        'Validation error');
                        }
                        $userDetails = Database::getInstance()->selectQuery([
                                'rawQuery' => 'id = ?',
                                'bindParams' => [$request['id']]
                        ]);
                        if (!empty($userDetails)) {
                                return apiResponse(200, 'User details fetched successfully.', null, $userDetails[0]);
                        } else {
                                return apiResponse(400, 'User details not found.', null, []);
                        }
                        
                } else {
                        return apiResponse(401, "Method not allowed.", "Invalid method");
                }
        }
        
        /**
         * This method is used to update user details
         * @author Saurabh Kumar <saurabhkumar3012official@gmail.com>
         * @since 23rd May 2021
         */
        public function updateUser(Request $request)
        {
                
                if ($request->isMethod('post')) {
                        // Validating inputs
                        $validator = Validator::make($request->all(), [
                                'id' => 'required|integer',
                                'name' => 'required|',
                                'username' => 'required',
                                'email' => 'required|email|unique:users,email,' . $request['id'],
                        ]);
                        if ($validator->fails()) {
                                return apiResponse(401,
                                        array_values(json_decode($validator->errors(), true))[0],
                                        'Validation error');
                        }
                        
                        $updated = Database::getInstance()->update([
                                'rawQuery' => 'id = ?',
                                'bindParams' => [$request['id']]
                        ], [
                                'name' => $request['name'],
                                'username' => $request['username'],
                                'email' => $request['email'],
                                'updated' => time()
                        ]);
                        if ($updated) {
                                return apiResponse(200, 'User record updated successfully.');
                        } else {
                                return apiResponse(400, 'Some error occurred. Please try reloading the page.');
                        }
                        
                } else {
                        return apiResponse(401, "Method not allowed.", "Invalid method");
                }
        }
        
        /**
         * This method is for deleting single user record
         * @author Saurabh Kumar <saurabhkumar3012official@gmail.com>
         * @since 23rd May 2021
         */
        public function deleteUser(Request $request)
        {
                
                if ($request->isMethod('post')) {
                        // Validating inputs
                        $validator = Validator::make($request->all(), [
                                'id' => 'required|integer',
                        ]);
                        if ($validator->fails()) {
                                return apiResponse(401,
                                        array_values(json_decode($validator->errors(), true))[0],
                                        'Validation error');
                        }
                        
                        $updated = Database::getInstance()->update([
                                'rawQuery' => 'id = ?',
                                'bindParams' => [$request['id']]
                        ], [
                                'active' => 0
                        ]);
                        if ($updated) {
                                return apiResponse(200, 'User delete successfully.');
                        } else {
                                return apiResponse(400, 'Some error occurred. Please try reloading the page.');
                        }
                        
                } else {
                        return apiResponse(401, "Method not allowed.", "Invalid method");
                }
        }
        
        
}
