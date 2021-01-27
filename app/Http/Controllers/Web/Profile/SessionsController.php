<?php

namespace ThaoHR\Http\Controllers\Web\Profile;

use ThaoHR\Http\Controllers\Controller;
use ThaoHR\Repositories\Session\SessionRepository;

/**
 * Class SessionsController
 * @package ThaoHR\Http\Controllers\Web\Profile
 */
class SessionsController extends Controller
{
    /**
     * @var SessionRepository
     */
    private $sessions;

    /**
     * @param SessionRepository $sessions
     */
    public function __construct(SessionRepository $sessions)
    {
        $this->sessions = $sessions;
    }

    /**
     * Get sessions for specified user.
     */
    public function index()
    {
        return view('user.sessions', [
            'profile' => true,
            'user' => auth()->user(),
            'sessions' => $this->sessions->getUserSessions(auth()->id())
        ]);
    }

    /**
     * Invalidate user's session.
     *
     * @param $session \stdClass Session object.
     * @return mixed
     */
    public function destroy($session)
    {
        $this->sessions->invalidateSession($session->id);

        return redirect()->route('profile.sessions')
            ->withSuccess(__('Session invalidated successfully.'));
    }
}
