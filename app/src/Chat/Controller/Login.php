<?php
/* (c) Anton Medvedev <anton@elfet.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chat\Controller;

use Chat\Entity\Guest;
use Chat\Entity\Message;
use Chat\Entity\User;
use Chat\Exception\Exception;
use Silicone\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/login")
 */
class Login extends Controller
{
    /**
     * @Route("", name="login")
     */
    public function index(Request $request)
    {
        $response = $this->render('users/login.twig', array(
            'error' => $this->app['security.last_error']($request),
            'last_username' => $this->app['session']->get('_security.last_username'),
        ));
        return $response;
    }

    /**
     * @Route("/guest", name="login_guest")
     */
    public function guest()
    {
        $guest = new Guest();
        $guest->setUsername('Guest');

        return $this->app->redirect($this->app->url('chat'));
    }
}
