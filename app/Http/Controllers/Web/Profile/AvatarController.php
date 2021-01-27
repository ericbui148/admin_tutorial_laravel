<?php

namespace ThaoHR\Http\Controllers\Web\Profile;

use Illuminate\Http\Request;
use ThaoHR\Events\User\ChangedAvatar;
use ThaoHR\Http\Controllers\Controller;
use ThaoHR\Repositories\User\UserRepository;
use ThaoHR\Services\Upload\UserAvatarManager;

/**
 * Class ProfileController
 * @package ThaoHR\Http\Controllers
 */
class AvatarController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * UsersController constructor.
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Upload and update user's avatar.
     *
     * @param Request $request
     * @param UserAvatarManager $avatarManager
     * @return mixed
     */
    public function update(Request $request, UserAvatarManager $avatarManager)
    {
        $request->validate(['avatar' => 'image']);

        $name = $avatarManager->uploadAndCropAvatar(
            $request->file('avatar'),
            $request->get('points')
        );

        if ($name) {
            return $this->handleAvatarUpdate($name);
        }

        return redirect()->route('profile')
            ->withErrors(__('Avatar image cannot be updated. Please try again.'));
    }

    /**
     * Update avatar for currently logged in user
     * and fire appropriate event.
     *
     * @param $avatar
     * @return mixed
     */
    private function handleAvatarUpdate($avatar)
    {
        $this->users->update(auth()->id(), ['avatar' => $avatar]);

        event(new ChangedAvatar);

        return redirect()->route('profile')
            ->withSuccess(__('Avatar changed successfully.'));
    }

    /**
     * Update user's avatar from external location/url.
     *
     * @param Request $request
     * @param UserAvatarManager $avatarManager
     * @return mixed
     */
    public function updateExternal(Request $request, UserAvatarManager $avatarManager)
    {
        $avatarManager->deleteAvatarIfUploaded(auth()->user());

        return $this->handleAvatarUpdate($request->get('url'));
    }
}
