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
    public function index()
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
        //Validate
        // $request->validate([
        //     'title' => 'required|min:3',
        //     'description' => 'required',
        // ]);
        
        $user->gender = $request->gender;
        $user->save();
        $request->session()->flash('message', 'Successfully modified the user!');
        return redirect('users');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userIp = $this->getUserIp();
        $genderData = $this->getGenderData($request->first_name, $userIp);
        // $userLocation = $this->getUserIp();

        $user = User::create(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'gender' => $genderData->getGender(), 'email' => $request->email]);

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


    protected function getUserIp() 
        {
            if (!empty($_SERVER['HTTP_CLIENT_IP']))   
            {
              $ip=$_SERVER['HTTP_CLIENT_IP'];
            }
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   
            {
              $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else
            {
              $ip=$_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        }

    protected function getGenderData($first_name = '', $userIp = '')
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
                } else {
                    $lookup = $apiClient->getByFirstName($first_name);
                }
                
                if ($lookup->genderFound()) { 
                    return $lookup;      // female
                }

                // // Query a full name and improve the result by providing a country code
                // $lookup = $apiClient->getByFirstNameAndLastNameAndCountry('Thomas Johnson', 'US');
                // if ($lookup->genderFound()) {
                //     echo $lookup->getGender();      // male
                //     echo $lookup->getFirstName();   // Thomas
                //     echo $lookup->getLastName();    // Johnson
                // }

            } catch (GenderApi\Exception $e) {
                // Name lookup failed due to a network error or insufficient requests
                // left. See https://gender-api.com/en/api-docs/error-codes
                echo 'Exception: ' . $e->getMessage();
            }
        }
}
