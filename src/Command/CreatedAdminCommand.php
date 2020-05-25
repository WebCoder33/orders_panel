<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CreatedAdminCommand
 * @package App\Command
 */
class CreatedAdminCommand extends Command
{
    /** @var string $defaultName */
    protected static $defaultName='app:create-admin';

    /** @var ContainerInterface $container */
    private $container;

    /** @var UserPasswordEncoderInterface $passwordEncoder */
    private $passwordEncoder;

    /**
     * CreatedAdminCommand constructor.
     * @param ContainerInterface $container
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(ContainerInterface $container, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct();
        $this->container = $container;
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Register new User')
            ->addArgument('username', InputArgument::REQUIRED, 'username')
            ->addArgument('password', InputArgument::REQUIRED, 'Password');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->createUser(
            $input->getArgument('username'),
            $input->getArgument('password')
        );

        $io->success('New user created!');

        return 0;
    }

    /**
     * @param string $username
     * @param string $password
     */
    private function createUser(string $username, string $password): void
    {
        /** @var $entityManager EntityManagerInterface */
        $entityManager = $this->container->get('doctrine')->getManager();

        $user = new User();
        $user->setUsername($username);
        $user->setFullName('Неизвестный пользователь');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));

        $entityManager->persist($user);
        $entityManager->flush();
    }
}