<?php

use Shanhaijing\SentryExt\Users\Eloquent\User;

class AccountSettingsController extends BaseController
{
    protected $editUser;

    public function __construct()
    {
        parent::__construct();

        $username = Route::getCurrentRoute()->getParameter('username');
        $user = Sentry::getUserProvider()->findByUsername($username);
        if (!$user) {
            App::abort(404);
        }
        if (!Sentry::check() || $this->user->id != $user->id) {
            App::abort(403);
        }
        View::share('user', $user);
        $this->editUser = $user;
    }

    public function getAvatar()
    {
        $avatar_type = Session::has('avatar_type') ? Session::get('avatar_type') : null;
        if (!$avatar_type) {
            $avatar_type = $this->editUser->avatar == 'gravatar' ? 'gravatar' : 'upload';
        }
        return View::make('account/settings/avatar', array(
            'avatar_type' => $avatar_type,
        ));
    }

    public function putAvatar()
    {
        if (Input::get('avatar_type') == 'gravatar') {
            $this->editUser->avatar = 'gravatar';
            $this->editUser->save();
        } 
        else {
            $rules = 'mimes:jpeg,jpg,png|max:200';
            if ($this->editUser->avatar == 'gravatar') {
                $rules = 'required|' . $rules;
            }
            $validator = Validator::make(input::all(), array('img' => $rules));
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)
                    ->with('avatar_type', 'upload')->withInput();
            }
            $filename = $this->editUser->id . '.png';
            Input::file('img')->move(shanhaijing_avatar_path(), $filename);

            $this->editUser->avatar = 'upload';
            $this->editUser->save();
        }

        return Redirect::back();
    }

}
