<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserDataPersister
 * @package App\DataPersister
 */
final class UserDataPersister implements ContextAwareDataPersisterInterface
{
    /** @var DataPersisterInterface $decorated */
    private $decorated;

    /** @var UserPasswordEncoderInterface  $passwordEncoder */
    private $passwordEncoder;

    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * UserDataPersister constructor.
     * @param DataPersisterInterface $decorated
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $entityManager
     */
    public function __construct
    (
        DataPersisterInterface $decorated,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager
    )
    {
        $this->decorated = $decorated;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    /**
     * @param User $data
     * @param array $context
     * @return bool
     */
    public function supports($data, array $context = []): bool
    {
        return $this->decorated->supports($data);
    }

    /**
     * @param User $data
     * @param array $context
     * @return object|void
     */
    public function persist($data, array $context = [])
    {
        $result = $this->decorated->persist($data);

        if($data instanceof User) {
            $this->setEncodePassword($data);
        }

        return $result;
    }

    /**
     * @param User $data
     * @param array $context
     * @return mixed
     */
    public function remove($data, array $context = [])
    {
        return $this->decorated->remove($data);
    }

    /**
     * @param User $data
     */
    private function setEncodePassword($data)
    {
        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)->find($data->getId());

        $encodePassword = $this->passwordEncoder->encodePassword($data, $data->getPassword());
        $user->setPassword($encodePassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}