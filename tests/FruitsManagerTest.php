<?php

namespace App\Tests;

use App\Repository\FamilyRepository;
use App\Repository\FruitRepository;
use App\Service\FruitsManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FruitsManagerTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $container = static::getContainer();
        /** @var FruitsManager $fruitsManager */
        $fruitsManager = $container->get(FruitsManager::class);
        $fruitRepository = $container->get(FruitRepository::class);
        $familyRepository = $container->get(FamilyRepository::class);

        $fruitsManager->fetchAndStore();

        $this->assertCount(2, $fruitRepository->findAll());
        $this->assertCount(1, $familyRepository->findAll());
    }
}
