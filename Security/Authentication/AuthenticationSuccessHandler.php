<?php
/**
 * AuthenticationSuccessHandler.php
 *
 * @since 21/08/14
 * @author Gerhard Seidel <gseidel.message@googlemail.com>
 */

namespace esperanto\UserBundle\Security\Authentication;

use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler
{
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $url = $this->httpUtils->generateUri($request, 'esperanto_admin_index');
        return $this->httpUtils->createRedirectResponse($request, $url);
    }
}