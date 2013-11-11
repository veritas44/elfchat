<?php
/* (c) Anton Medvedev <anton@elfet.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ElfChat\Controller;

use Silicone\Route;
use ElfChat\Entity\User;
use ElfChat\Form\RegistrationFormType;

/**
 * @Route("/register")
 */
class Register extends Controller
{
    /**
     * @Route("", name="register")
     */
    public function index()
    {
        $form = $this->app->formType(new RegistrationFormType($this->app['password.encoder']));

        $form->handleRequest($this->request);
        if ($form->isValid()) {
            $user = $form->getData();
            $this->app->entityManager()->persist($user);
            $this->app->entityManager()->flush();

            return $this->app->redirect($this->app->url('register_success'));
        }

        $response = $this->render('users/register.twig', array(
            'form' => $form->createView(),
        ));
        $response->setSharedMaxAge(86400);

        return $response;
    }

    /**
     * @Route("/success", name="register_success")
     */
    public function success()
    {
        return $this->render('users/register/success.twig');
    }
}