<?php

namespace App\Service;

use App\Entity\Family;
use App\Entity\Fruit;
use App\Repository\FamilyRepository;
use App\Repository\FruitRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class FruitsManager implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public const FRUITS_BASE_URL = 'https://fruityvice.com/api/';
    public const FRUITS_ALL = 'fruit/all';

    public function __construct(private readonly FruitRepository $fruitRepository, private readonly FamilyRepository $familyRepository, private HttpClientInterface $client, private readonly MailerManager $mailerManager)
    {
        $this->client = $this->client->withOptions([
            'base_uri' => self::FRUITS_BASE_URL,
        ]);
    }

    public function fetchAndStore(): void
    {
        // Fetch fruits from fruityvice.com
        $response = $this->client->request('GET', self::FRUITS_ALL);
        $fruits = $response->toArray();

        // Get all families
        $families = $this->familyRepository->findAll();
        $familiesWithKeys = array_combine(
            array_map(static fn(Family $family) => $family->getName(), $families),
            $families
        );

        // Get all fruits sourceId from the db to see if it's worth verifying if the fruit already exists
        $existingSourceIds = $this->fruitRepository->findAllSourceIds();

        $difference = array_diff(array_column($fruits, 'id'), $existingSourceIds);

        $this->logger->info('Fruits fetched from fruityvice.com', [
            'nbrFruits' => count($fruits),
            'nbrNewFruits' => count($difference),
        ]);

        $nbrNewFruits = count($difference);
        if ($nbrNewFruits !== 0) {
            $index = 0;
            foreach ($fruits as $fruitData) {
                if (in_array($fruitData['id'], $existingSourceIds, true)) {
                    continue;
                }

                // If the family doesn't exist, create it
                if (!isset($familiesWithKeys[$fruitData['family']])) {
                    $family = new Family();
                    $family->setName($fruitData['family']);
                    $this->familyRepository->save($family);
                    $familiesWithKeys[$fruitData['family']] = $family;
                }

                $fruit = new Fruit();
                $fruit
                    ->setFamily($familiesWithKeys[$fruitData['family']])
                    ->setName($fruitData['name'])
                    ->setSourceId($fruitData['id'])
                    ->setGenus($fruitData['genus'])
                    ->setFruitOrder($fruitData['order'])
                    ->setNutritionsCarbohydrates($fruitData['nutritions']['carbohydrates'])
                    ->setNutritionsProtein($fruitData['nutritions']['protein'])
                    ->setNutritionsFat($fruitData['nutritions']['fat'])
                    ->setNutritionsCalories($fruitData['nutritions']['calories'])
                    ->setNutritionsSugar($fruitData['nutritions']['sugar']);

                $this->fruitRepository->save($fruit, $index === $nbrNewFruits - 1);

                $index++;
            }

            $this->mailerManager->sendFruitsFetchedEmail($nbrNewFruits);
        }
    }
}
