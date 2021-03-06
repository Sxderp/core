<?php

namespace FluxBB\Actions;

use FluxBB\Core\Action;
use FluxBB\Models\User;
use FluxBB\Models\ConfigRepositoryInterface;
use FluxBB\Server\Request;
use FluxBB\Validator\UserValidator;

class Register extends Action
{
    protected $validator;

    protected $config;


    public function __construct(UserValidator $validator, ConfigRepositoryInterface $repository)
    {
        $this->validator = $validator;
        $this->config = $repository;
    }

    /**
     * Run the action and return a response for the user.
     *
     * @return void
     */
    protected function run()
    {
        $user = new User([
            'username'          => $this->request->get('user'),
            'group_id'          => $this->config->get('o_default_user_group'),
            'password'          => $this->request->get('password'),
            'email'             => $this->request->get('email'),
            'email_setting'     => $this->config->get('o_default_email_setting'),
            'timezone'          => $this->config->get('o_default_timezone'),
            'dst'               => $this->config->get('o_default_dst'),
            'language'          => $this->config->get('o_default_lang'),
            'style'             => $this->config->get('o_default_style'),
            //'registration_ip'   => $this->request->getClientIp(),
            //'last_visit'        => $this->request->server('REQUEST_TIME', time()),
        ]);

        $this->onErrorRedirectTo(new Request('register'));
        $this->validator->validate($this->request->get());

        $user->save();
        $this->trigger('user.registered', [$user]);

        $this->redirectTo(
            new Request('index'),
            trans('fluxbb::register.reg_complete')
        );
    }
}
