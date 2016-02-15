<?php
/**
 * Created by IntelliJ IDEA.
 * User: dj3
 * Date: 27/12/15
 * Time: 02:55
 */

namespace UnrLab\SecurityBundle\Listener;



use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use UnrLab\SecurityBundle\Entity\BaseUser;
use UnrLab\SecurityBundle\Service\UserProvider;

class SecurityListener
{
    private $provider;
    private $session;
    private $securityHeaderKey;
    private $securityHeaderValue;
    private $manager;

    public function __construct(UserProvider $provider, Session $session, $securityHeaderKey, $securityHeaderValue, EntityManagerInterface $manager)
    {
        $this->provider = $provider;
        $this->session = $session;
        $this->securityHeaderKey = $securityHeaderKey;
        $this->securityHeaderValue = $securityHeaderValue;
        $this->manager = $manager;
    }

    public function onKernelRequest (GetResponseEvent $event)
    {
        if ($event->isMasterRequest()) {
            $request = $event->getRequest();
            if ($request->getRequestUri() === '/rest-login') {
                if (!$this->checkLoginHeader($request)) {
                    $event->setResponse($this->buildAccessDeniedResponse());
                }

                $event->setResponse(new JsonResponse('', Response::HTTP_CREATED, array(
                    'XINSession' => $this->storage->getToken()->getCredentials()
                )));
            } else {
                if (!$this->checkSessionHeader($request)) {
                    $event->setResponse($this->buildAccessDeniedResponse());
                }
            }
        }
    }

    private final function buildASession($session, $repository)
    {
        $user = $this->provider->loadUserByToken($session, $repository);
        if ($user) {
            $authenticatedToken = new UsernamePasswordToken($user, $session, 'front', ['ROLE_USER']);
            $authenticatedToken->setUser($user);
            $this->session->set($session, $authenticatedToken);

            return true;
        }

        return false;
    }

    private final function checkLoginHeader(Request $request)
    {
        $result = false;
        if (($request->headers->has($this->securityHeaderKey) && $request->headers->get($this->securityHeaderKey) === $this->securityHeaderValue)) {
            if (!$request->request) {
                $request->request = new ParameterBag();
            }
            $request->request->add(json_decode($request->getContent(), true));
            if ($request->request && $request->request->has('username') && $request->request->has('public_key')) {
                $username = $request->request->get('username');
                $publicKey = $request->request->get('public_key');
                $isAdmin = $request->request->get('is_admin', null);
                $repository = $isAdmin ? 'UnrLabDomainBundle:SuperAdmin' : 'UnrLabDomainBundle:BillUser';
                $user = $this->provider->loadUserByKeyAndUsername($publicKey, $username, $repository);
                if ($user && $user instanceof BaseUser) {
                    if (!$user->getAccessToken()) {
                        $user->generateAccessToken();
                        $this->manager->flush();
                    }
                    $result = $this->buildASession($user->getAccessToken(), $repository);
                }
            }
        }

        return $result;
    }

    private final function checkSessionHeader(Request $request)
    {
        $result = false;
        if (($request->headers->has($this->securityHeaderKey) && $request->headers->get($this->securityHeaderKey) === $this->securityHeaderValue)) {
            if ($request->request && $request->headers->has('XINSession')) {
                $sessionTest = $request->headers->get('XINSession');
                $isAdmin = $request->get('is_admin', null);
                $repository = $isAdmin ? 'UnrLabDomainBundle:SuperAdmin' : 'UnrLabDomainBundle:BillUser';
                $user = $this->provider->loadUserByToken($sessionTest, $repository);
                if ($user) {
                    $result = $this->buildASession($user->getAccessToken(), $repository);
                }
            }
        }

        return $result;
    }

    private function buildAccessDeniedResponse()
    {
        return new JsonResponse('', Response::HTTP_FORBIDDEN);
    }
}