<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use GenderApi\Client as GenderApiClient;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::all();
        return view('users.index', compact('users', $users));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required',
        ]);

        $userIp = $this->getUserIp();
        $genderData = $this->getGenderData($request->first_name, $userIp);

        $user = User::create(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'gender' => $genderData->getGender(), 'country' => $userIp, 'email' => $request->email]);

        if ($genderData->getAccuracy() < 70) {           
            return redirect('/users/' .$user->id.'/edit');
        } 

        return redirect('/users/' .$user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user', $user));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit',compact('user',$user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'gender' => 'required',
        ]);
        
        $user->gender = $request->gender;
        $user->save();
        $request->session()->flash('message', 'Successfully modified the user!');
        return redirect('users');
    }

    protected function getUserIp()
        {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else if (!empty($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            } else {
                $ip = false;
            }
          
            $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
            
            if($query && $query['status'] == 'success') {
                return $query['country'];
            } else {
                return 'Country N/A';
            }
        }

    protected function getGenderData($first_name = '')
        {
            if (empty($first_name)) {
                echo 'Exception: user name required';
                return;
            }

            try {
                $apiClient = new GenderApiClient('sCGwxJoUHhwrrygkts');

                // Query a single name
                if (!empty($userIp)) {
                    $lookup = $apiClient->getByFirstNameAndClientIpAddress($first_name, $userIp);
                    // $lookup = $apiClient->getByFirstNameAndLocale($first_name, $userLocale);
                } else {
                    $lookup = $apiClient->getByFirstName($first_name);
                }
                
                if ($lookup->genderFound()) { 
                    return $lookup;      // female
                }
            } catch (GenderApi\Exception $e) {
                echo 'Exception: ' . $e->getMessage();
            }
        }
}
