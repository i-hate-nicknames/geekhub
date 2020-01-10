<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManagerInterface;

class UserChangedListener
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param User $user
     * @param LifecycleEventArgs $event
     */
    public function postUpdate(User $user, LifecycleEventArgs $event)
    {
        if ($user->getIsTarget()) {
            $repo = $this->manager->getRepository(User::class);
            $repo->setTarget($user->getId());
        }
    }
}
