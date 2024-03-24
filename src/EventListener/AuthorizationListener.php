<?php

// namespace App\EventListener;

// use Symfony\Component\HttpKernel\Event\RequestEvent;
// use Symfony\Component\Security\Core\Security;
// use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


// class AuthorizationListener
// {
//     private $security;

//     public function __construct(Security $security)
//     {
//         $this->security = $security;
//     }

//     public function onKernelRequest(RequestEvent $event)
//     {
//         
//         $user = $this->security->getUser();


//         if (!$this->security->isGranted('ROLE_ADMIN')) {

//             throw new AccessDeniedHttpException('Access Denied');
//         }
//     }
// }
