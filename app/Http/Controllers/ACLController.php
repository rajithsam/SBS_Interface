<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Permission as Permission;
use App\View as View;
use JavaScript;
use Route;
use Auth;
use App\User as User;
use Hash as Hash;

class ACLController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function addUser(Request $request)
    {
        $isActive =   $request->input('isActive');
        $isSuperUser = $request->input('isSuperUser');
        $credentials = $request->only('email', 'password','name');
        $credentials['password'] = Hash::make($credentials['password']);
        try 
        {
            $user = User::create($credentials);
            if($isActive)
                $user->isActive = $isActive;
            else
                $user->isActive = false;

            if($request->user()->isSuperUser)
            {
                if($isSuperUser)           
                    $user->isSuperUser = $isSuperUser;
                else
                    $user->isSuperUser = false;
            }
            $user->save();

            $request['operation'] = 'Add User';
            $request['old_value'] = '-';
            $request['new_value'] = $user;
            LogController::create($request);
        } 
        catch (Exception $e) 
        {
            #return Response::json(['error' => 'User already exists.'], Illuminate\Http\Response::HTTP_CONFLICT);
        }
        return redirect()->action('ACLController@editUserPermissions');
    }

    public function editUser(Request $request)
    {
        $id = $request->input('userId');
        $isActive =   $request->input('isActive');
        $isSuperUser = $request->input('isSuperUser');
        $email = $request->input('email');
        $password = $request->input('password');
        $name = $request->input('name');
        $changePassword = $request->input('changePassword');

        try 
        {
            $user = User::find($id);

            $request['old_value'] =  User::find($id);
            
            $user->email = $email;
            $user->name = $name;

            if($changePassword)
            {
                $password = Hash::make($password);
                $user->password = $password;
            }

            if($isActive)
                $user->isActive = $isActive;
            else
                $user->isActive = false;

            if($request->user()->isSuperUser)
            {
                if($isSuperUser)           
                    $user->isSuperUser = $isSuperUser;
                else
                    $user->isSuperUser = false;
            }
            $user->save();
            $request['operation'] = 'Update User';
            
            $request['new_value'] = $user;
            LogController::create($request);

        } 
        catch (Exception $e) 
        {
            #return Response::json(['error' => 'User already exists.'], Illuminate\Http\Response::HTTP_CONFLICT);
        }
        return redirect()->action('ACLController@editUserPermissions');
    }


    public function updatePermission(Request $request)
    {
        $permission = Permission::find($request->input('PermissionId'));

        $request['old_value'] = Permission::find($request->input('PermissionId'));

        $viewsIds  = $request->input('views'); // related ids
        $pivotData = array_fill(0, count($viewsIds), ['created_by_user' => $request->user()->name, 'created_from_ip' => $request->ip()]);
        $syncData  = array_combine($viewsIds, $pivotData);
        $permission->views()->sync($syncData);

        $request['operation'] = 'Update Permission';
        $request['new_value'] = $permission;
        LogController::create($request);

        return redirect()->action('ACLController@editPermissions');

    }

    public function addPermission(Request $request)
    {
        $permission = new Permission();
        $permission->name = $request->input('permissionName');
        $permission->created_by_user =  $request->user()->id;
        $permission->created_from_ip = $request->ip();
        $permission->save();

        $viewsIds  = $request->input('views'); // related ids
        if(count($viewsIds) !=0)
        {
            $pivotData = array_fill(0, count($viewsIds), ['created_by_user' => $request->user()->name, 'created_from_ip' => $request->ip()]);
            $syncData  = array_combine($viewsIds, $pivotData);
            $permission->views()->sync($syncData);
        }


        $request['operation'] = 'Add Permission';
        $request['old_value'] = '-';
        $request['new_value'] = $permission;
        LogController::create($request);

        return redirect()->action('ACLController@editPermissions');

    }

    public function deletePermission(Request $request, $PermissionId)
    {
        $permission = Permission::find($PermissionId);
        
        $request['old_value'] = $permission;
        
        $permission->delete();

        $request['operation'] = 'Delete Permission';
        $request['new_value'] = '-';
        LogController::create($request);

        return redirect()->action('ACLController@editPermissions');
    }

    public function editPermissions()
    {
        $views = View::all()->lists("id", "path");
        $routeCollection = Route::getRoutes();


        foreach($routeCollection as $route)
        {
            if(!array_has($views, $route->getPath()))
            {
                $temp = new View();
                $temp->path = $route->getPath();
                $temp->save();
            }
        }
/*
        $views = View::all();
        $found = false;
        for($i = 0 ; $i < count($views); $i++)
        {
            for($j = 0 ; $j < count($routeCollection); $j++)
            {
                if($views[$i]->path == $routeCollection->getRoutes()[$j]->getPath())
                {
                    $found = true;
                    break;
                }
            }
            echo $routeCollection->getRoutes()[$i]->getPath() , "\n";
            echo $views[$i]->path , "\n" ;
            if(!$found)
            {
                echo $views[$i]->path;
                $views[$i]->delete();
            }
        }
 */      

        $views = View::all();
        $permission = Permission::with('views')->get();  

        JavaScript::put([
            'Permissions' => $permission,
            'Views' => $views
            ]);
        $data = array(
            'Permissions' => $permission,
            'Views' => $views
            );

    	return view('ACL/permissions' , $data);
    }

    public function updateUserPermission(Request $request)
    {
        $user =User::find($request->input('PermissionId'));
        $permission = Permission::find($request->input('PermissionId'));

        $viewsIds  = $request->input('views'); // related ids
        $pivotData = array_fill(0, count($viewsIds), ['created_by_user' => $request->user()->name, 'created_from_ip' => $request->ip()]);
        $syncData  = array_combine($viewsIds, $pivotData);
        $user->permissions()->sync($syncData);
        return redirect()->action('ACLController@editUserPermissions');

    }

    public function addUserPermission(Request $request)
    {
        $permission = new Permission();
        $permission->name = $request->input('permissionName');
        $permission->created_by_user =  $request->user()->id;
        $permission->created_from_ip = $request->ip();
        $permission->save();

        $viewsIds  = $request->input('views'); // related ids
        if(count($viewsIds) !=0)
        {
            $pivotData = array_fill(0, count($viewsIds), ['created_by_user' => $request->user()->name, 'created_from_ip' => $request->ip()]);
            $syncData  = array_combine($viewsIds, $pivotData);
            $permission->views()->sync($syncData);
        }
        return redirect()->action('ACLController@editUserPermissions');

    }

    public function deleteUserPermission(Request $request, $PermissionId)
    {
        $permission = User::find($PermissionId);
        
        $request['old_value'] = $permission;
        
        $permission->delete();
        
        $request['operation'] = 'Delete User';
        $request['new_value'] = '-';
        LogController::create($request);

        return redirect()->action('ACLController@editUserPermissions');
    }

    public function editUserPermissions()
    {         

        $views = Permission::all();
        $permission =   User::with('permissions')->get();
        JavaScript::put([
            'Permissions' =>$permission,
            'Views' => $views 
            ]);
        $data = array(
            'Permissions' => $permission,
            'Views' => $views
            );

        return view('ACL/userPermissions' , $data);
    }
}
