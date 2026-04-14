<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\RoleEnum;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $users = [
            ['firstname' => 'Corentin', 'lastname' => 'Planet', 'email' => 'corentin@gmail.com', 'password' => '3333', 'date' => DateTime::createFromFormat("Y-m-d H:i:s", "2026-04-01 12:30:01"), 'role' => RoleEnum::Regular],
            ['firstname' => 'Baptiste', 'lastname' => 'Parmentier', 'email' => 'baptiste@gmail.com', 'password' => '2222', 'date' => DateTime::createFromFormat("Y-m-d H:i:s", "2026-04-01 14:30:01"), 'role' => RoleEnum::Moderator]
        ];
        foreach ($users as $data) {
            $user = new User();
            $user->setFirstname($data["firstname"]);
            $user->setLastname($data["lastname"]);
            $user->setEmail($data["email"]);
            $user->setPassword($data["password"]);
            $user->setDate($data["date"]);
            $user->setRole($data["role"]);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
