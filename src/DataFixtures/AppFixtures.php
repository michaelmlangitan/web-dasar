<?php

namespace App\DataFixtures;

use App\Entity\Option;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUser($manager);
        $this->loadOptions($manager);

        $manager->flush();
    }

    private function loadUser(ObjectManager $manager)
    {
        // Important: don't forget to set username, email, and password.
        $user = new User();
        $user->setName('Admin');
        $user->setUsername('admin');
        $user->setEmail('example@email.com');
        $user->setRoles([User::ROLE_SUPER_ADMIN]);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'admin'));
        $user->setCreatedAt(new DateTimeImmutable());
        $manager->persist($user);
    }

    private function loadOptions(ObjectManager $manager)
    {
        foreach ($this->getDataOptions() as $data) {
            $option = new Option();
            $option->setName($data["name"]);
            $option->setValue($data["value"]);
            $option->setAutoload($data["autoload"]);
            $manager->persist($option);
        }
    }

    private function getDataOptions(): array
    {
        return [
            [
                'name'=>'app_name',
                'value'=>'Web Dasar',
                'autoload'=>true
            ],
            [
                'name'=>'app_description',
                'value'=>'Your app description here.',
                'autoload'=>true
            ],
            [
                'name'=>'html_lang',
                'value'=>'id',
                'autoload'=>true
            ],
            [
                'name'=>'web_charset',
                'value'=>'UTF-8',
                'autoload'=>true
            ]
        ];
    }
}
