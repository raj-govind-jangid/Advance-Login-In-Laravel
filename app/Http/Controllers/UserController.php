<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Mail;

class UserController extends Controller
{
    public function loginuser(Request $request)
    {
        $email = $request->email;
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('/');
        }
        else{
            session()->put('fail',"Email or Password is incorrect");
            return redirect('/login');
        }
    }

    public function registeruser(Request $request)
    {
        if(!User::where(['email'=>$request->email])->first())
        {
            $password = Str::random(10);
            $userin = new User;
            $userin->name = $request->name;
            $userin->email = $request->email;
            $userin->password = Hash::make($password);
            $userin->type = "User";
            $save = $userin->save();

            if($save){
                $data = ['email'=>$request->email,'password'=>$password];
                $user['to'] = $request->email;
                Mail::send('mail.createaccount',$data,function($messages) use ($user){
                $messages->to($user['to']);
                $messages->subject('Your Account Credentials');
                });
                session()->put('success',"We have sended the password to your email account");
                return redirect('/login');
            }

            else{
                session()->put('fail',"Something Went Wrong");
                return redirect('/register');
            }

        }

        else{
            session()->put('fail',"Email Already Exists");
            return redirect('/register');
        }

    }

    public function logout(){
        $useremail = Auth::user()->email;
        Auth::logout();
        Cache::pull(".$useremail.");
        return redirect('login');
    }

    public function forgetpassword(Request $request){
        if($user = User::where(['email'=>$request->email])->first()){
            $forgetemail = $request->email;
            $resetcode = rand(100000,999999);
            $resetcodetime = date('Y-m-d h:i:s',strtotime('15 minutes'));
            $user->update(['resetcode'=>$resetcode, 'resetcodetime'=>$resetcodetime]);
            $data = ['resetcode'=>$resetcode];
            $user['to'] = $request->email;
            Mail::send('mail.forgetpassword',$data,function($messages) use ($user){
            $messages->to($user['to']);
            $messages->subject('Your One Time Password to change password');
            });
            session()->put('success',"We have send OTP To your Email Id");
            return view('user.changepassword',['forgetemail'=>$forgetemail]);
        }
        else{
            session()->put('fail',"Email ID not Found");
            return redirect('/forgetpassword');
        }
    }

    public function changepassword(Request $request){
        $forgetemail = $request->forgetemail;
        $user = User::where(['email'=>$forgetemail])->first();
        if($request->verifyotp == $user['resetcode']){
            $currenttime = date('Y-m-d h:i:s',strtotime('now'));

            if($user['resetcodetime'] > $currenttime){
                $user->update(['password'=> Hash::make($request->password)]);
                session()->put('success',"Password have Changed Successfully");
                return redirect('/login');
            }

            else{
                session()->put('fail',"Please Entry Valid OTP");
                return view('user.changepassword',['forgetemail'=>$forgetemail]);
            }
        }

        else{
            session()->put('fail',"Please Entry Valid OTP");
            return view('user.changepassword',['forgetemail'=>$forgetemail]);
        }
    }

    public function profile(){
        $user = User::where(['email'=>Auth::user()->email])->first();
        return view('user.profile',['user'=>$user]);
    }

    public function updateprofile(Request $request){
        $user = User::where(['email'=>Auth::user()->email])->first();
        $oldemail = $user['email'];
        $newemail = $request->email;
        $checkemail = User::whereIn('email', array($oldemail, $newemail))->get()->count();
        if($user['email'] == $request->email){
            $user->update([
                'name'=> $request->name,
                'email'=> $request->email,
            ]);
            session()->put('success',"Profile Updated Successfully");
            return redirect('profile');
        }
        elseif($checkemail == 1){
            $verifycode = rand(100000,999999);
            $verifycodetime = date('Y-m-d h:i:s',strtotime('15 minutes'));
            $user->update(['verifycode'=>$verifycode, 'verifycodetime'=>$verifycodetime]);
            $data = ['verifycode'=>$verifycode];
            $user['to'] = $newemail;
            Mail::send('mail.changeemailaddress',$data,function($messages) use ($user){
            $messages->to($user['to']);
            $messages->subject('Your One Time Password to Verify Email Id');
            });
            session()->put('success',"We have Send OTP To Your New Email Id");
            return view('user.changeemailaddress',['newemail'=>$newemail,'oldemail'=>$oldemail]);
        }
        elseif($checkemail == 2){
            session()->put('fail',"Email Id already exists");
            return redirect('profile');
        }
    }

    public function updateemailaddress(Request $request){
        $oldemail = $request->oldemail;
        $newemail = $request->newemail;
        $user = User::where(['email'=>$oldemail])->first();
        echo $user;
        if(Hash::check($request->password, $user->user_password)){
            $currenttime = date('Y-m-d h:i:s',strtotime('now'));

            if($user['verifycode'] == $request->verifyotp && $user['verifycodetime'] > $currenttime){
                $user->update([
                    'email'=>$newemail
                ]);
                session()->put('success','Email ID changed Successfully');
                return redirect('profile');
            }

            else{
                session()->put('fail','Verify Code is Invalid');
                return view('user.changeemailaddress',['newemail'=>$newemail,'oldemail'=>$oldemail]);
            }
        }

        else{
            session()->put('fail','Password is Invalid');
            return view('user.changeemailaddress',['newemail'=>$newemail,'oldemail'=>$oldemail]);
        }

    }

    public function changeuserpassword(){
        $email = Auth::user()->email;
        return view('user.changeuserpassword',['email'=>$email]);
    }

    public function updateuserpassword(Request $request){
        $user = User::where(['email'=>Auth::user()->email])->first();
        if(Hash::check($request->oldpassword, $user->user_password)){

            if($request->password == $request->confirmpassword){
                $user->update(['password'=>Hash::make($request->password)]);
                session()->put('success',"Password Change Successfully");
                Auth::logout();
                return redirect('/login');
            }

            else{
                session()->put('fail',"Password Don't Match Correctly");
                return redirect()->back();
            }
        }

        else{
            session()->put('fail',"Please Enter Your Old Password Correctly");
            return redirect()->back();
        }
    }

    public function onlineuser(){
        if(Auth::user()){
            $useremail = Auth::user()->email;
            Cache::put(".$useremail.",1,60);
        }
    }

    static function userstatus($useremail){
        if(Cache::get(".$useremail.")){
           return "<span style='color: green;'>Online</span>";
        }
        else{
           return "<span style='color: red;'>Offline</span>";
        }
    }
}
