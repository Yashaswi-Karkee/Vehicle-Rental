<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Order;
use App\Models\Posts;
use App\Models\Notification;
use GrahamCampbell\ResultType\Success;
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
use Cixware\Esewa\Config;
use Cixware\Esewa\Client;

require_once '../vendor/autoload.php';




// Init composer autoloader.
require '../vendor/autoload.php';

// use Stevebauman\Location\Facades\Location;

class CustomizedController extends Controller
{

    // //Filtering options
    // public function filtering($latitude, $longitude)
    // {
    //     return [$latitude, $longitude];
    // }


    //HomePage View
    public function homepage()
    {
        if (Session::has('result')) {
            $result = Session::get('result');
            Session::pull('result');
            $data = array();
            $check = array();
            $count = 0;
            $check = $result;
            if (is_null($check)) {
                $temp = 1;
                $post = null;
            } else {
                $temp = 0;
                // $post = Posts::leftJoin('agencies', 'agencies.email', '=', 'agencyEmail')->get();
                $post = $result;
            }
            $notification = Notification::where('notification_to', Session::get('loginEmail'))->orderBy('id', 'desc')->get();
            $data = User::where('email', '=', Session::get('loginEmail'))->first();
            if ($data) {
                return view("homepage", compact('data', 'temp', 'post', 'notification', 'count'));
            } else {
                $data = Agency::where('email', '=', Session::get('loginEmail'))->first();
                if ($data) {
                    return view("homepage", compact('data', 'temp', 'post', 'notification', 'count'));
                } else {
                    $data = null;
                    return view('homepage', compact('data', 'temp', 'post'));
                }
            }

        } else {

            $data = array();
            $check = array();
            $count = 0;
            $check = Posts::first();
            if (is_null($check)) {
                $temp = 1;
                $post = null;
            } else {
                $temp = 0;
                // $post = Posts::leftJoin('agencies', 'agencies.email', '=', 'agencyEmail')->get();
                $post = Posts::get();
            }
            $notification = Notification::where('notification_to', Session::get('loginEmail'))->orderBy('id', 'desc')->get();
            $data = User::where('email', '=', Session::get('loginEmail'))->first();
            if ($data) {
                return view("homepage", compact('data', 'temp', 'post', 'notification', 'count'));
            } else {
                $data = Agency::where('email', '=', Session::get('loginEmail'))->first();
                if ($data) {
                    return view("homepage", compact('data', 'temp', 'post', 'notification', 'count'));
                } else {
                    $data = null;
                    return view('homepage', compact('data', 'temp', 'post'));
                }
            }
        }

    }





    //Notification Display
    public function notificationShow()
    {
        $notification = Notification::where('notification_to', Session::get('loginEmail'))->orderBy('id', 'desc')->get();
        foreach ($notification as $notify) {
            if ($notify->isRead == 0) {
                $notify->isRead = 1;
                $notify->update();
            }
        }
        return view('notification.notification', compact('notification'));

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
        $agency = Agency::where('email', '=', $request->email)->first();
        $admin = Admin::where('email', '=', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('loginEmail', $user->email);
                return redirect()->to(route('homepage'));
            } else {
                return back()->with('fail', 'Password doesnot match');
            }

        } elseif ($agency) {
            if ($agency->isVerified == 1) {
                if (Hash::check($request->password, $agency->password)) {
                    $request->session()->put('loginEmail', $agency->email);
                    return redirect()->to(route('homepage'));
                } else {
                    return back()->with('fail', 'Password doesnot match');
                }
            } else {
                return back()->with('fail', 'Your credentials are not verified by admin!');
            }
        } else if ($admin) {
            if (Hash::check($request->password, $admin->password)) {
                $request->session()->put('loginEmail', $admin->email);
                return redirect()->to(route('show.admin'));
            } else {
                return back()->with('fail', 'Password doesnot match');
            }
        } else {
            return back()->with('fail', 'This email is not registered');
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

        if (User::where('email', '=', $request->email)->first() || Agency::where('email', '=', $request->email)->first() || Admin::where('email', '=', $request->email)->first()) {
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
            'image' => 'required|mimes:png,jpg,jpeg,svg,gif|image',
            'address' => 'required',
            'contact' => 'required|max:10',
            'latitude' => 'required',
            'longitude' => 'required',
            'registration_num' => 'required',
            'pan_number' => 'required',
            'pan_image' => 'required|image|mimes:png,jpg,jpeg,svg,gif',
            'registration_image' => 'required|image|mimes:png,jpg,jpeg,svg,gif',

        ]);


        if (User::where('email', '=', $request->email)->first() || Agency::where('email', '=', $request->email)->first() || Admin::where('email', '=', $request->email)->first()) {
            return back()->with('fail', 'Email already taken');
        } else {
            $newImgName = time() . "-" . $request->name . '.' . $request->image->extension();

            $request->image->move(public_path('profile_pictures'), $newImgName);

            $PANimg = time() . "-" . $request->name . '.' . $request->pan_image->extension();

            $request->pan_image->move(public_path('PANCard'), $PANimg);

            $Registerimg = time() . "-" . $request->name . '.' . $request->registration_image->extension();

            $request->registration_image->move(public_path('RegistrationCert'), $Registerimg);

            $user = new Agency();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->contact = $request->contact;
            $user->address = $request->address;
            $user->password = Hash::make($request->password);
            $user->profile_pic = $newImgName;
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
            $user->isVerified = 0;
            $user->PAN_no = $request->pan_number;
            $user->register_number = $request->registration_num;
            $user->PAN_pic = $PANimg;
            $user->company_register_pic = $Registerimg;

            $res = $user->save();
            if ($res) {
                Mail::send('emails.agencyVerificationOnProgress', [], function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('Agency Verification');
                });
                return back()->with('success', 'An email has been sent to your inbox');
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
                $image_path = public_path("profile_pictures/{$temp1->profile_pic}");

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

            $posts = Posts::where('email', '=', $temp2->email)->get();

            foreach ($posts as $post) {
                $post->agencyEmail = $request->email;
                $post->latitude = $request->latitude;
                $post->longitude = $request->longitude;
                $post->update();
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
        $user = User::where('email', '=', $email)->first();
        if ($user) {
            $image_path = public_path("profile_pictures/{$user->profile_pic}");

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
            $user->delete();
            return redirect('logout');
        } else {
            $user = Agency::where('email', '=', $email)->first();
            $post = Posts::where('agencyEmail', '=', $email)->get();
            $image_path = public_path("profile_pictures/{$user->profile_pic}");

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

            foreach ($post as $p) {

                $image_path = public_path("posts_pic/{$p->pic}");

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
                $p->delete();
            }

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
        $temp3 = Admin::where('email', '=', $request->email)->first();



        if ($temp1 || $temp2 || $temp3) {

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
        $temp3 = Admin::where('email', '=', $request->email)->first();

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
        } else if ($data && $temp3) {

            Admin::where('email', '=', $request->email)->update(['password' => Hash::make($request->password)]);
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

    //Get view for Updating Post
    public function updatePostGet($id)
    {
        $post = Posts::where('id', '=', $id)->first();
        return view('posts.updatePosts', compact('post'));
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
            $message = "You created a post";
            $email = Session::get('loginEmail');
            Notification::notify($message, $email, "System");
            return back()->with('success', 'Post Created!');

        } else {

            return back()->with('fail', 'Something went wrong!');

        }

    }

    //Actual code to update post
    public function updatePostPost(Request $request, $id)
    {
        $temp1 = Posts::where('id', '=', $id)->first();
        if ($temp1) {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'type' => 'required',
                'price' => 'required',
                'quantity' => 'required',
                'image' => 'mimes:png,jpg,jpeg,svg,gif|max:5048|image',
            ]);

            if ($request->hasFile('image')) {
                // Construct the full image path using public_path()
                $image_path = public_path("posts_pic/{$temp1->pic}");

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
                $newImgName = time() . "-" . $request->title . '.' . $request->image->extension();
                $request->image->move(public_path('posts_pic'), $newImgName);
                $temp1->pic = $newImgName;
            }


            $temp1->title = $request->title;
            $temp1->description = $request->description;
            $temp1->type = $request->type;
            $temp1->rate = $request->price;
            $temp1->quantity = $request->quantity;

            $temp1->update();
            $message = "You updated your post";
            $email = Session::get('loginEmail');
            Notification::notify($message, $email, "System");
            return back()->with('success', 'Post Updated!');

        } else {

            return back()->with('fail', 'Something went wrong!');

        }

    }

    //Delete Posts
    public function deletePosts($id)
    {
        $post = Posts::where('id', '=', $id)->first();
        if ($post) {

            $post->delete();

            $message = "You deleted your post";
            $email = Session::get('loginEmail');
            Notification::notify($message, $email, "System");
            return back()->with('success', 'Post Deleted!');
        } else {

            return back()->with('fail', 'Something went wrong!');

        }
    }















    //Functions for order handling
    //Get order page
    public function getOrderPage($id, $userEmail, $agencyEmail)
    {
        return view('orderPage', compact('id', 'userEmail', 'agencyEmail'));
    }

    // Post order page
    public function postOrderPage(Request $request, $id, $userEmail, $agencyEmail)
    {
        $request->validate([
            'pickUpDate' => 'required|date|after:today',
            // Pick-Up Date must be today or in the future
            'dropDate' => 'required|date|after:pickUpDate',
            // Drop Date must be after or equal to Pick-Up Date
        ]);
        // Check if the user is an agency
        $check = Agency::where('email', $userEmail)->first();
        if ($userEmail == $agencyEmail || $check) {
            return back()->with('fail', 'Rental Agencies cannot order! Please use different credentials');
        }


        try {
            // Parse date and time inputs
            $pickupDateTime = Carbon::parse($request->input('pickUpDate') . ' ' . $request->input('pickUpTime'));
            $dropDateTime = Carbon::parse($request->input('dropDate') . ' ' . $request->input('dropTime'));
        } catch (\Exception $e) {
            // Handle date parsing errors here, e.g., invalid date format
            return back()->with('fail', 'Invalid date or time');
        }

        // Calculate total days
        $totalDays = $pickupDateTime->diffInDays($dropDateTime);
        if ($totalDays <= 0) {
            return back()->with('fail', 'Invalid date!');

        }

        // Calculate total price based on rate and total days
        $post = Posts::where('id', '=', $id)->first();
        $quantity = $post->quantity;
        if ($quantity <= 0) {
            return back()->with('fail', 'Sorry the product is out of stock');
        }
        $rate = $post->rate;
        $price = $rate * $totalDays;
        $post->quantity = $quantity - 1;
        $post->update();

        // Create a new Order instance and set its properties
        $table = new Order();
        $table->orderedBy = $userEmail;
        $table->orderedFrom = $agencyEmail;
        $table->productId = $id;
        $table->isCompleted = 0;
        $table->isAccepted = 0;
        $table->pickUpDate = $request->input('pickUpDate');
        $table->dropDate = $request->input('dropDate');
        $table->pickUpTime = $request->input('pickUpTime');
        $table->dropTime = $request->input('dropTime');
        $table->pickUpLocation = $request->input('pickUpLocation');
        $table->dropLocation = $request->input('dropLocation');
        $table->totalPrice = $price;
        $table->paymentStatus = "Unpaid";
        // Save the Order instance to the database
        $table->save();
        Mail::send('emails.orderCreated', [], function ($message) use ($agencyEmail) {
            $message->to($agencyEmail);
            $message->subject('Order Request Received');
        });

        $message = "You have received a new order";
        Notification::notify($message, $agencyEmail, "System");

        return back()->with('success', 'Order placed successfully');


    }

    //Payment Selection Get
    public function paymentSelection($id)
    {
        $order = Order::where('id', $id)->first();
        return view('paymentSelection', compact('order'));
    }

    //Payment Selection Post
    public function paymentSelectionPost(Request $request, $id, $userEmail, $agencyEmail)
    {
        $order = Order::where('id', $id)->first();
        $post = Posts::where('id', $order->productId)->first();
        $user = User::where('email', $userEmail)->first();
        if ($request->paymentMethod == 'esewa') {

            // Set success and failure callback URLs.

            $successUrl = url('/success');
            $failureUrl = url('/fail');

            // Config for development.
            $config = new Config($successUrl, $failureUrl);

            // Initialize eSewa client.
            $esewa = new Client($config);
            $esewa->process($id, $order->totalPrice, 0, 0, 0);

        } elseif ($request->paymentMethod == 'stripe') {
            $productItems = [];

            \Stripe\Stripe::setApiKey('sk_test_51Nx7ipHhFrhpubP1EePozGVEdvf6Gw2nmCLCF2RrXaJqtgp4g8GBCyDa6XRWbVNKhYv3zWy3dv6KUUjQJgv296UJ007XLZgDsX');
            // $stripe = new \Stripe\StripeClient('sk_test_51Nx7ipHhFrhpubP1EePozGVEdvf6Gw2nmCLCF2RrXaJqtgp4g8GBCyDa6XRWbVNKhYv3zWy3dv6KUUjQJgv296UJ007XLZgDsX');
            $quantity = $order->totalPrice / $post->rate;
            $price = intval($post->rate);
            $productItems[] = [
                'price_data' => [
                    'product_data' => [
                        'name' => $post->title,
                    ],
                    'currency' => 'NPR',
                    'unit_amount' => $price . '00',
                ],
                'quantity' => $quantity
            ];

            $checkoutSession = \Stripe\Checkout\Session::create([
                'line_items' => [$productItems],
                'mode' => 'payment',
                'customer_email' => $userEmail,
                'success_url' => url('/success/' . $id),
                'cancel_url' => url('/fail/', $id),
            ]);
            return redirect()->away($checkoutSession->url);
        } elseif ($request->paymentMethod == 'COD') {
            $order = Order::where('id', '=', $id)->first();
            $order->paymentStatus = "COD";
            $order->update();
            $message = $user->name . " has set the payment method to COD for the product " . $post->title;
            Notification::notify($message, $agencyEmail, $userEmail);
            return back()->with('success', 'Payment Status set to COD');
        } else {
            return back()->with('fail', 'Error Occured');
        }
    }

    //Esewa Success
    public function esewaSuccess()
    {
        $id = $_GET['pid'];
        $order = Order::where('id', '=', $id)->first();
        $user = User::where('email', $order->orderedBy)->first();
        $post = Posts::where('id', $order->productId)->first();
        $order->paymentStatus = "Paid";
        $order->update();
        $message = $user->name . " has made payment for the product " . $post->title;
        Notification::notify($message, $order->orderedFrom, $order->orderedBy);
        return view('successPage');
    }

    //Esewa failure
    public function esewaFailure()
    {
        return view('failPage');
    }
    //Stripe Success
    public function stripeSuccess($id)
    {
        $order = Order::where('id', '=', $id)->first();
        $user = User::where('email', $order->orderedBy)->first();
        $post = Posts::where('id', $order->productId)->first();
        $order->paymentStatus = "Paid";
        $order->update();
        $message = $user->name . " has made payment for the product " . $post->title;
        Notification::notify($message, $order->orderedFrom, $order->orderedBy);
        return view('successPage');
    }

    //Stripe failure
    public function stripeFailure($id)
    {
        // $order = Order::where('id', '=', $id)->first();
        // $post = Posts::where('id', '=', $order->productId)->first();
        // $order->delete();
        // $post->quantity = $post->quantity + 1;
        // $post->update();
        return view('failPage');
    }

    //Delete Order
    public function deleteOrder($id)
    {
        $order = Order::where('id', '=', $id)->first();
        $post = Posts::where('id', '=', $order->productId)->first();
        $order->delete();
        $post->quantity = $post->quantity + 1;
        $post->update();
        $user = User::where('email', $order->orderedBy)->first();
        $message = $user->name . " has deleted the order with title " . $post->title;
        Notification::notify($message, $order->orderedFrom, $order->orderedBy);
        return back()->with('success', 'Deleted Successfully');
    }

    //Edit Order view
    public function editOrderView($id)
    {
        $order = Order::where('id', '=', $id)->first();
        return view('updateOrder', compact('order'));

    }

    //Edit Order Post
    public function editOrderPost(Request $request, $id)
    {
        $order = Order::where('id', '=', $id)->first();
        $user = User::where('email', $order->orderedBy)->first();
        // Check if the user is an agency
        $agencyEmail = Agency::where('email', '=', Session::get('loginEmail'))->first();
        if ($agencyEmail) {
            return back()->with('fail', 'Rental Agencies cannot order! Please use different credentials');
        }
        if ($order->paymentStatus == "Unpaid") {

            // Parse date and time inputs
            $pickupDateTime = Carbon::parse($request->input('pickUpDate') . ' ' . $request->input('pickUpTime'));
            $dropDateTime = Carbon::parse($request->input('dropDate') . ' ' . $request->input('dropTime'));

            // Calculate total days
            $totalDays = $pickupDateTime->diffInDays($dropDateTime);

            // Calculate total price based on rate and total days
            $post = Posts::where('id', '=', $order->productId)->first();
            $rate = $post->rate;
            $price = $rate * $totalDays;


            $order->pickUpDate = $request->input('pickUpDate');
            $order->dropDate = $request->input('dropDate');
            $order->pickUpTime = $request->input('pickUpTime');
            $order->dropTime = $request->input('dropTime');
            $order->pickUpLocation = $request->input('pickUpLocation');
            $order->dropLocation = $request->input('dropLocation');
            $order->totalPrice = $price;

            // Save the Order instance to the database
            $order->update();
            $message = $user->name . " has updated the order details of " . $post->title;
            Notification::notify($message, $order->orderedFrom, $order->orderedBy);

            return back()->with('success', 'Order Updated');
        } else {
            return back()->with('fail', 'Order cannot be updated!');
        }
    }
    //Accept Order
    public function acceptOrder($id)
    {
        $order = Order::where('id', '=', $id)->first();
        $email = $order->orderedBy;
        $order->isAccepted = 1;
        $order->update();
        Mail::send('emails.orderAccepted', [], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Order Verified');
        });
        $user = Agency::where('email', $order->orderedFrom)->first();
        $post = Posts::where('id', $order->productId)->first();
        $message = $user->name . " has accepted the order for " . $post->title;
        Notification::notify($message, $order->orderedBy, $order->orderedFrom);
        return back()->with('success', 'Accepted Order');
    }

    //Reject Order
    public function rejectOrder($id)
    {
        $order = Order::where('id', '=', $id)->first();
        $email = $order->orderedBy;
        $post = Posts::where('id', '=', $order->productId)->first();
        $order->delete();
        $post->quantity = $post->quantity + 1;
        $post->update();
        Mail::send('emails.orderRejected', [], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Order Rejected');
        });
        $user = Agency::where('email', $order->orderedFrom)->first();
        $post = Posts::where('id', $order->productId)->first();
        $message = $user->name . " has rejected the order for " . $post->title;
        Notification::notify($message, $order->orderedBy, $order->orderedFrom);
        return back()->with('success', 'Rejected Order');
    }

    //Complete Order
    public function completeOrder($id)
    {
        $order = Order::where('id', '=', $id)->first();
        $email = $order->orderedBy;
        $order->isCompleted = 1;
        $order->update();
        Mail::send('emails.orderComplete', [], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Order Completed');
        });
        $user = User::where('email', $order->orderedBy)->first();
        $user1 = Agency::where('email', $order->orderedFrom)->first();
        $post = Posts::where('id', $order->productId)->first();
        $message = "Thank you " . $user->name . " for the order " . $post->title . " from " . $user1->name . ". Your order will be delivered today. Dont forget to leave a review. ";
        Notification::notify($message, $order->orderedBy, $order->orderedFrom);
        return back()->with('success', 'Completed Order');
    }



















    //Request Functions
    //Requests get
    public function showRequestList()
    {
        $temp1 = User::where('email', '=', Session::get('loginEmail'))->first();
        $temp2 = Agency::where('email', '=', Session::get('loginEmail'))->first();
        if ($temp1) {
            $temp2 = null;
            $order = Order::where('orderedBy', '=', Session::get('loginEmail'))->where('paymentStatus', 'Unpaid')->get();
        } elseif ($temp2) {
            $temp1 = null;
            $order = Order::where('orderedFrom', '=', Session::get('loginEmail'))->where('paymentStatus', 'Unpaid')->get();
        }
        return view('requestList', compact('order', 'temp1', 'temp2'));
    }

    //Pending Order Get
    public function showPendingOrder()
    {
        $temp1 = User::where('email', '=', Session::get('loginEmail'))->first();
        $temp2 = Agency::where('email', '=', Session::get('loginEmail'))->first();
        if ($temp1) {
            $temp2 = null;
            $order = Order::where('orderedBy', '=', Session::get('loginEmail'))->where('isCompleted', '0');
            $order = $order->where('paymentStatus', 'Paid')->orWhere('paymentStatus', 'COD')->get();
        } elseif ($temp2) {
            $temp1 = null;
            $order = Order::where('orderedFrom', '=', Session::get('loginEmail'))->where('isCompleted', '0');
            $order = $order->where('paymentStatus', 'Paid')->orWhere('paymentStatus', 'COD')->get();
        }
        return view('pendingOrders', compact('order', 'temp1', 'temp2'));
    }

    //Show order History
    public function showOrderHistory()
    {

        $temp1 = User::where('email', '=', Session::get('loginEmail'))->first();
        $temp2 = Agency::where('email', '=', Session::get('loginEmail'))->first();
        if ($temp1) {
            $temp2 = null;
            $order = Order::where('orderedBy', '=', Session::get('loginEmail'))->get();
        } elseif ($temp2) {
            $temp1 = null;
            $order = Order::where('orderedFrom', '=', Session::get('loginEmail'))->get();
        }
        return view('orderHistory', compact('order', 'temp1', 'temp2'));

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