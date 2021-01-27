<?php

namespace ThaoHR\Http\Controllers\Web\Profile;

use ThaoHR\Http\Controllers\Controller;
use ThaoHR\Http\Requests\User\UpdateProfileLoginDetailsRequest;
use ThaoHR\Repositories\User\UserRepository;

/**
 * Class LoginDetailsController
 * @package ThaoHR\Http\Controllers
 */
class LoginDetailsController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * LoginDetailsController constructor.
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Update user's login details.
     *
     * @param UpdateProfileLoginDetailsRequest $request
     * @return mixed
     */
    public function update(UpdateProfileLoginDetailsRequest $request)
    {
        $data = $request->except('role', 'status');

        // If password is not provided, then we will
        // just remove it from $data array and do not change it
        if (! data_get($data, 'password')) {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        $this->users->update(auth()->id(), $data);

        return redirect()->route('profile')
            ->withSuccess(__('Login details updated successfully.'));
    }
}
