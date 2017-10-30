<?php

namespace Rakshitbharat\Supersu\Controllers;

use Illuminate\Http\Request;
use Rakshitbharat\Supersu\Supersu;
use Illuminate\Routing\Controller;

class SupersuController extends Controller {

    protected $superSu;

    public function __construct(Supersu $superSu) {
        $this->superSu = $superSu;
    }

    public function loginAsUser(Request $request) {
        $this->superSu->loginAsUser($request->userId, $request->originalUserId);
        session()->put('admin_permission', AdminPermission::where('admin_role_id', Admin::find($request->userId)->admin_role_id)->pluck('admin_permission_slug', 'id')->toArray());
        return redirect()->back();
    }

    public function return(Request $request)
    {
    $this->superSu->return();

    return redirect()->back();
}

}
