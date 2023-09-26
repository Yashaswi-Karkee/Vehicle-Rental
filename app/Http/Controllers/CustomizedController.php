<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Agency;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Mail;
use Str;
use Illuminate\Support\Facades\DB;
use File;

// use Stevebauman\Location\Facades\Location;

class CustomizedController extends Controller
{

    //HomePage View
    public function homepage()
    {
        $data = array();
        $check = array();
        $check = Posts::first();
        if (is_null($check)) {
            $temp = 1;
        } else {
            $temp = 0;
            $post = Posts::leftJoin('agencies', 'agencies.email', '=', 'agencyEmail')->get();
        }
        $data = User::where('email', '=', Session::get('loginEmail'))->first();
        if ($data) {
            return view("homepage", compact('data', 'temp', 'post'));
        } else {
            $data = Agency::where('email', '=', Session::get('loginEmail'))->first();
            if ($data) {
                return view("homepage", compact('data', 'temp', 'post'));
            } else {
                return view('homepage', compact('data', 'temp', 'post'));
            }
        }

    }












    // Login functions
    // Get Login view
    public function login()
    {
        return view("auth.loginPage");
    }

    //Logout function
    public function logout()
    {
        if (Session::has('loginEmail')) {
            Session::pull('loginEmail');
            return redirect()->to(route('homepage'))->with('success', 'Successfully logged out!');
        }
        return back()->with('fail', 'Login first');
    }

    //Login Verification
    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', '=', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('loginEmail', $user->email);
                return redirect()->to(route('homepage'));
            } else {
                return back()->with('fail', 'Password doesnot match');
            }

        } else {
            $agency = Agency::where('email', '=', $request->email)->first();
            if ($agency) {
                if (Hash::check($request->password, $agency->password)) {
                    $request->session()->put('loginEmail', $agency->email);
                    return redirect()->to(route('homepage'));
                } else {
                    return back()->with('fail', 'Password doesnot match');
                }
            } else {
                return back()->with('fail', 'This email is not registered');
            }

        }
    }













    //Register User Functions
    //Register User view
    public function registrationUser()
    {
        return view("auth.registerUser");
    }

    //Register Agency view
    public function registrationAgency()
    {
        return view("auth.registerAgency");
    }

    //Register User Verification
    public function registerUser(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'address' => 'required',
            'contact' => 'required|max:10',
            'image' => 'required|mimes:png,jpg,jpeg,svg,gif|max:5048|image'
        ]);

        if (User::where('email', '=', $request->email)->first() || Agency::where('email', '=', $request->email)->first()) {
            return back()->with('fail', 'Email already taken');
        } else {
            $newImgName = time() . "-" . $request->name . '.' . $request->image->extension();

            $request->image->move(public_path('profile_pictures'), $newImgName);


            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->contact = $request->contact;
            $user->address = $request->address;
            $user->password = Hash::make($request->password);
            $user->profile_pic = $newImgName;

            $res = $user->save();
            if ($res) {
                return back()->with('success', 'You have registered successfully');
            } else {
                return back()->with('fail', 'Something went wrong');
            }
        }
    }

    //Register Agency Verification
    public function registerAgency(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'image' => 'required|mimes:png,jpg,jpeg,svg,gif|max:5048|image',
            'address' => 'required',
            'contact' => 'required|max:10',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);


        if (User::where('email', '=', $request->email)->first() || Agency::where('email', '=', $request->email)->first()) {
            return back()->with('fail', 'Email already taken');
        } else {
            $newImgName = time() . "-" . $request->name . '.' . $request->image->extension();

            $request->image->move(public_path('profile_pictures'), $newImgName);

            $user = new Agency();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->contact = $request->contact;
            $user->address = $request->address;
            $user->password = Hash::make($request->password);
            $user->profile_pic = $newImgName;
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;

            $res = $user->save();
            if ($res) {
                return back()->with('success', 'You have registered successfully');
            } else {
                return back()->with('fail', 'Something went wrong');
            }
        }
    }














    //Settings and Profile Functions
    //User Profile View
    public function showUserProfile($email)
    {
        if (Session::has('loginEmail') && $email == Session::get('loginEmail')) {
            $temp2 = 1;
        } else {
            $temp2 = 0;
        }
        $check = Posts::where('agencyEmail', '=', $email)->first();
        if (is_null($check)) {
            $temp1 = 1;
            $post = null;
        } else {
            $temp1 = 0;
            $post = Posts::where('agencyEmail', '=', $email)->get();
        }
        $data = Agency::where('email', '=', $email)->first();
        if ($data) {
            return view('userProfile', compact('data', 'temp1', 'temp2', 'post'));
        } else {
            return back()->with('fail', 'Some error occured!');
        }
    }

    //Show settings view
    public function settings()
    {
        $data1 = array();
        $data1 = User::where('email', '=', Session::get('loginEmail'))->first();
        if ($data1) {
            return view("auth.settings", compact('data1'));
        } else {
            $data1 = Agency::where('email', '=', Session::get('loginEmail'))->first();
            if ($data1) {
                return view("auth.settings", compact('data1'));
            }
        }

    }

    //Edit and Update Profile Get
    public function editProfile()
    {
        $data1 = array();
        $data1 = User::where('email', '=', Session::get('loginEmail'))->first();
        if ($data1) {
            return view("auth.profileEditUser", compact('data1'));
        } else {
            $data1 = Agency::where('email', '=', Session::get('loginEmail'))->first();
            if ($data1) {
                return view("auth.profileEditAgency", compact('data1'));
            }
        }

    }

    //Update Profile POST
    public function updateProfile(Request $request, $email)
    {
        $temp1 = User::where('email', '=', $email)->first();
        $temp2 = Agency::where('email', '=', $email)->first();
        if ($temp1) {
            $request->validate([
                'name' => 'string|required',
                'email' => 'email|required',
                'address' => 'required',
                'contact' => 'required|max:10',
                'image' => 'mimes:png,jpg,jpeg,svg,gif|max:5048|image',
            ]);
            if ($request->hasFile('image')) {
                $image_path = "/images/$temp1->profile_pic"; // Value is not URL but directory file path
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
                $newImgName = time() . "-" . $request->name . '.' . $request->image->extension();
                $request->image->move(public_path('profile_pictures'), $newImgName);
                $temp1->profile_pic = $newImgName;
            }


            $temp1->name = $request->name;
            $temp1->email = $request->email;
            $temp1->contact = $request->contact;
            $temp1->address = $request->address;

            $temp1->update();
            return redirect()->to(route('settings'))->with('success', 'Details Changed!');

        } else {

            $request->validate([
                'name' => 'string|required',
                'email' => 'email|required',
                'address' => 'required',
                'contact' => 'required|max:10',
                'image' => 'mimes:png,jpg,jpeg,svg,gif|max:5048|image',
                'latitude' => 'required',
                'longitude' => 'required'
            ]);
            if ($request->hasFile('image')) {
                // Construct the full image path using public_path()
                $image_path = public_path("profile_pictures/{$temp2->profile_pic}");

                // Check if the image file exists before attempting deletion
                if (File::exists($image_path)) {
                    try {
                        // Delete the existing image
                        File::delete($image_path);
                    } catch (\Exception $e) {
                        // Handle any exceptions that occur during deletion
                        return back()->with('fail', 'Error deleting the existing image.');
                    }
                }

                // Upload and save the new image
                $newImgName = time() . "-" . $request->name . '.' . $request->image->extension();
                $request->image->move(public_path('profile_pictures'), $newImgName);
                $temp2->profile_pic = $newImgName;
            }

            $temp2->name = $request->name;
            $temp2->email = $request->email;
            $temp2->contact = $request->contact;
            $temp2->address = $request->address;
            $temp2->latitude = $request->latitude;
            $temp2->longitude = $request->longitude;

            $temp2->update();
            return redirect()->to(route('settings'))->with('success', 'Details Changed!');

        }

    }

    //Delete Account
    public function deleteAccount($email)
    {
        $user = User::where('email', '=', $email);
        if ($user) {
            $user->delete();
            return redirect('logout');
        } else {
            $user = Agency::where('email', '=', $email);
            $post = Posts::where('agencyEmail', '=', $email)->get();
            foreach ($post as $p)
                $p->delete();

            $user->delete();

            return redirect('logout');
        }
    }

    //Update password code
    public function updatePassword(Request $request, $email)
    {
        $request->validate([
            'current' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);
        $temp1 = User::where('email', '=', $email)->first();
        $temp2 = Agency::where('email', '=', $email)->first();

        if ($temp1) {
            if (Hash::check($request->current, $temp1->password)) {
                $temp1->password = Hash::make($request->password);
                $temp1->update();
                return back()->with('success', 'Password Changed!');
            } else {
                return back()->with('fail', 'Old Password is incorrect');
            }
        } else {
            if (Hash::check($request->current, $temp2->password)) {
                $temp2->password = Hash::make($request->password);
                $temp2->update();
                return back()->with('success', 'Password Changed!');
            } else {
                return back()->with('fail', 'Old Password is incorrect');
            }

        }
    }

















    //Forget Password functions
    //Email Verifiation view
    public function emailVerifyGet()
    {
        return view('auth.emailVerify');
    }

    //Password change view
    public function passwordResetGet($token)
    {
        return view('auth.changePassword', compact('token'));
    }

    //email verification for sending mail
    public function emailVerifyPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $temp1 = User::where('email', '=', $request->email)->first();
        $temp2 = Agency::where('email', '=', $request->email)->first();


        if ($temp1 || $temp2) {

            $token = Str::random(64);
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
            Mail::send('emails.forgotPass', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            return redirect()->to(route('email.verify.get'))->with('success', 'Please check your inbox');
        }

        return back()->with('fail', 'Please enter registered Email');
    }

    //Function to reset the password
    public function passwordResetPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        $temp1 = User::where('email', '=', $request->email)->first();
        $temp2 = Agency::where('email', '=', $request->email)->first();

        $data = DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();

        if ($data && $temp1) {
            User::where('email', '=', $request->email)->update(['password' => Hash::make($request->password)]);
            DB::table('password_reset_tokens')->where('email', '=', $request->email)->delete();
            return redirect()->to(route('login'))->with('success', 'Successfully changed password!');
        } else if ($data && $temp2) {

            Agency::where('email', '=', $request->email)->update(['password' => Hash::make($request->password)]);
            DB::table('password_reset_tokens')->where('email', '=', $request->email)->delete();
            return redirect()->to(route('login'))->with('success', 'Successfully changed password!');
        } else {
            DB::table('password_reset_tokens')->where('email', '=', $request->email)->delete();
            return back()->with('fail', 'Please try again');
        }

    }


















    //Functions for Posts
    //Get view for Creating Posts
    public function createPostGet($email)
    {
        return view('posts.createPosts', compact('email'));
    }

    //Actual code to create a post
    public function createPostPost(Request $request, $email)
    {
        $temp1 = Agency::where('email', '=', $email)->first();
        if ($temp1) {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'type' => 'required',
                'price' => 'required',
                'quantity' => 'required',
                'image' => 'mimes:png,jpg,jpeg,svg,gif|max:5048|image|required',
            ]);

            $newImgName = time() . "-" . $request->title . '.' . $request->image->extension();
            $request->image->move(public_path('posts_pic'), $newImgName);
            $post = new Posts();

            $post->pic = $newImgName;
            $post->title = $request->title;
            $post->agencyEmail = $email;
            $post->description = $request->description;

            $post->type = $request->type;
            $post->rate = $request->price;
            $post->quantity = $request->quantity;
            $post->latitude = $temp1->latitude;
            $post->longitude = $temp1->longitude;

            $post->save();
            return back()->with('success', 'Post Created!');

        } else {

            return back()->with('fail', 'Something went wrong!');

        }

    }

















    //Code for practising

    // public function location()
    // {
    //     // $ip = request()->ip();
    //     $data = Location::get('113.199.231.69');
    //     dd($data);
    //     return view('location', compact('data'));
    // }

    // public function location()
    // {
    //     return view('location');
    // }
    // public function showRequestList()
    // {
    //     if (Posts::exists()) {

    //         $data = Posts::all();
    //         return view("requestLists", compact('data'));
    //     } else {
    //         return view("requestLists", compact('data'));
    //     }
    // }
}