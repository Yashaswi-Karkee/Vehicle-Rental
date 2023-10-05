<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Agency;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class adminController extends Controller
{
    public function showAdmin()
    {
        $admin = Admin::all();
        $user = User::all();
        $agency = Agency::where('isVerified', 1)->get();

        return view('adminDashboard', compact('admin', 'user', 'agency'));
    }

    //Show pending accounts to be verified
    public function showPendingRequests()
    {
        $pend = 1;
        $agency = Agency::where('isVerified', 0)->get();
        if (count($agency) == 0) {
            $pend = null;
        }
        return view('pendingAdmin', compact('agency', 'pend'));
    }

    //Logout function
    public function logoutAdmin()
    {
        if (Session::has('loginEmail')) {
            Session::pull('loginEmail');
            return redirect()->to(route('homepage'))->with('success', 'Successfully logged out!');
        }
        return back()->with('fail', 'Login first');
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
            Mail::send('emails.accountDelete', [], function ($message) use ($email) {
                $message->to($email);
                $message->subject('Account Deleted');
            });
            return back()->with('success', 'Account Deleted Successfully');
        } else {
            $user = Agency::where('email', '=', $email)->first();
            $post = Posts::where('agencyEmail', '=', $email)->get();
            $image_path = public_path("profile_pictures/{$user->profile_pic}");
            $pan_path = public_path("PANCard/{$user->PAN_pic}");
            $register_path = public_path("RegistrationCert/{$user->company_register_pic}");

            dd(File::exists($pan_path));

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

            // Check if the image file exists before attempting deletion
            if (File::exists($pan_path)) {
                dd($pan_path);
                try {
                    // Delete the existing image
                    File::delete($pan_path);
                } catch (\Exception $e) {
                    // Handle any exceptions that occur during deletion
                    return back()->with('fail', 'Error deleting the existing image.');
                }
            }

            // Check if the image file exists before attempting deletion
            if (File::exists($register_path)) {
                try {
                    // Delete the existing image
                    File::delete($register_path);
                } catch (\Exception $e) {
                    // Handle any exceptions that occur during deletion
                    return back()->with('fail', 'Error deleting the existing image.');
                }
            }

            foreach ($post as $p) {

                $image_path = public_path("posts_pic/{$p->pic}");
                $p->delete();
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

            }

            $user->delete();
            Mail::send('emails.accountDelete', [], function ($message) use ($email) {
                $message->to($email);
                $message->subject('Account Deleted');
            });

            return back()->with('success', 'Account Deleted Successfully');
        }
    }

    //Account Accept
    public function acceptAccount($email)
    {
        $user = Agency::where('email', '=', $email)->first();
        if ($user) {
            $user->isVerified = 1;
            $user->update();
            Mail::send('emails.accountVerified', [], function ($message) use ($email) {
                $message->to($email);
                $message->subject('Account Verified');
            });
            return back()->with('success', 'Account Verified');
        }
        return back()->with('fail', 'Some Error Occured');
    }

    //Account Reject
    public function rejectAccount($email)
    {
        $user = Agency::where('email', '=', $email)->first();
        if ($user) {
            $image_path = public_path("profile_pictures/{$user->profile_pic}");
            $pan_path = public_path("PANCard/{$user->PAN_pic}");
            $register_path = public_path("RegistrationCert/{$user->company_register_pic}");

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
            // Check if the image file exists before attempting deletion
            if (File::exists($pan_path)) {
                try {
                    // Delete the existing image
                    File::delete($pan_path);
                } catch (\Exception $e) {
                    // Handle any exceptions that occur during deletion
                    return back()->with('fail', 'Error deleting the existing image.');
                }
            }

            // Check if the image file exists before attempting deletion
            if (File::exists($register_path)) {
                try {
                    // Delete the existing image
                    File::delete($register_path);
                } catch (\Exception $e) {
                    // Handle any exceptions that occur during deletion
                    return back()->with('fail', 'Error deleting the existing image.');
                }
            }
            $user->delete();
            Mail::send('emails.accountRejected', [], function ($message) use ($email) {
                $message->to($email);
                $message->subject('Account Rejected');
            });
            return back()->with('success', 'Account Rejected');
        } else {
            return back()->with('fail', 'User not found');
        }

    }

    // public function createAdminCredentials()
    // {
    //     $email = "admin@yahoo.com";
    //     $password = Hash::make("password");
    //     $admin = new Admin();
    //     $admin->email = $email;
    //     $admin->password = $password;
    //     $admin->save();
    // }
}