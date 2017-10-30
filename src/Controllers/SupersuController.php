<?php

namespace Rakshitbharat\Supersu\Controllers;

use Illuminate\Http\Request;
use Rakshitbharat\Supersu\Supersu;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Application;

class SupersuController extends Controller {

    protected $app;
    protected $superSu;

    public function __construct(Supersu $superSu, Application $app) {
        $this->superSu = $superSu;
        $this->app = $app;
    }

    public function loginAsUser(Request $request) {
        $this->superSu->loginAsUser($request->userId, $request->originalUserId);
        try {
            \App\Facades\SupersuCustom::loginAsUser($this);
        } catch (\Exception $ex) {
            
        }
        return redirect()->back();
    }

    public function returnCurrent(Request $request) {
        $this->superSu->returnCurrent();

        return redirect()->back();
    }

}
