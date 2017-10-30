<?php

namespace Rakshitbharat\Supersu;

use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Application;
use Illuminate\Session\SessionManager;
use Symfony\Component\HttpFoundation\Response;
use Modules\PermissionBuilder\Models\AdminPermission;
use App\Admin;

class Supersu {

    protected $app;
    protected $auth;
    protected $session;
    protected $sessionKey = 'supersu.original_id';
    protected $usersCached = null;

    public function __construct(Application $app, AuthManager $auth, SessionManager $session) {
        $this->app = $app;
        $this->auth = $auth;
        $this->session = $session;
    }

    public function loginAsUser($userId, $currentUserId) {
        $this->session->put('supersu.has_supered', true);
        $this->session->put($this->sessionKey, $currentUserId);

        $this->auth->loginUsingId($userId);
        }

        public function return()
        {
        if (!$this->hasSupered()) {
        return false;
        }

        $this->auth->logout();

        $originalUserId = $this->session->get($this->sessionKey);

        if ($originalUserId) {
            session()->put('admin_permission', AdminPermission::where('admin_role_id', Admin::find($originalUserId)->admin_role_id)->pluck('admin_permission_slug', 'id')->toArray());
            $this->auth->loginUsingId($originalUserId);
        }

        $this->session->forget($this->sessionKey);
        $this->session->forget('supersu.has_supered');

        return true;
    }

    public function injectToView(Response $response) {
        $packageContent = view('supersu::user-selector', [
            'users' => $this->getUsers(),
            'hasSupered' => $this->hasSupered(),
            'originalUser' => $this->getOriginalUser(),
            'currentUser' => $this->auth->user()
                ])->render();

        $responseContent = $response->getContent();

        $response->setContent($responseContent . $packageContent);
    }

    public function getOriginalUser() {
        if (!$this->hasSupered()) {
            return $this->auth->user();
        }

        $userId = $this->session->get($this->sessionKey);

        return $this->getUsers()->where('id', $userId)->first();
    }

    public function hasSupered() {
        return $this->session->has('supersu.has_supered');
    }

    public function getUsers() {
        if ($this->usersCached) {
            return $this->usersCached;
        }

        $user = $this->getUserModel();

        return $this->usersCached = $user->get();
    }

    protected function getUserModel() {
        $userModel = Config::get('supersu.user_model');
        return $this->app->make($userModel);
    }

}
