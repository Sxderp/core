<?php

namespace FluxBB\Actions;

use FluxBB\Core\Action;
use FluxBB\Models\User;

class ProfilePage extends Action
{
    protected function run()
    {
        $uid = $this->request->get('id');

        $user = User::findOrFail($uid);

        $this->data['user'] = $user;
    }
}
