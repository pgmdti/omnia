<?php
/**
 * Created by PhpStorm.
 * User: fcoco
 * Date: 11/06/2018
 * Time: 21:58
 */

namespace App\Redirection;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;


class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;
    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }
    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        return new RedirectResponse($this->router->generate($this->urlRedirection($token)));
    }

    /**
     * @param TokenInterface $token
     * @return string
     */
    public function urlRedirection(TokenInterface $token){

        $redirection = "index_geral";

        $roles = $token->getRoles();

        $rolesTab = array_map(function($role){
            return $role->getRole();
        }, $roles);

        if (in_array('ROLE_ESP', $rolesTab, true))
            $redirection = 'esp_produtividade_ato_index';
        else if(in_array('ROLE_AESP', $rolesTab, true))
            $redirection = 'esp_produtividade_analista_ato_index';

        return $redirection;
    }

}