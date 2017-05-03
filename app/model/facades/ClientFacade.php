<?php
/**
 * Created by PhpStorm.
 * User: František Rožek
 * Date: 2. 5. 2017
 * Time: 19:42
 */

declare(strict_types=1);

namespace App\Model\Facades;

use App\Model\Entities\Client;
use Kdyby\Doctrine\EntityManager;
use Nette;
use Tracy\Debugger;

class ClientFacade
{
    use Nette\SmartObject;

    /** @var EntityManager Manager pro práci s entitami. */
    private $em;

    private $repository;

    /**
     * Konstruktor s injektovanou třídou pro práci s entitami.
     * @param EntityManager $em automaticky injektovaná třída pro práci s entitami
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Client::class);
    }

    /**
     * Najde a vrátí fáze podle jeho ID.
     * @param int|NULL $id ID fáze
     * @return Risk|NULL vrátí entitu rizika nebo NULL pokud riziko nebylo nalezeno
     */
    public function getClient($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Najde a vrátí všechna rizika.
     * @return array Vrátí všechna rizika.
     */
    public function getClients()
    {
        return $this->repository->findAll();
    }

    /**
     * Smaže riziko.
     * @param Risk $risk Riziko ke smazání
     * @param $autoFlush
     */
    public function removeClient($client, $autoFlush)
    {
        if (!$client instanceof Client) {
            $client = $this->getClient($client);
        }
        if ($client) {
            $this->em->remove($client);
            if ($autoFlush) {
                $this->em->flush();
            }
        }
    }


    /**
     * Vytvoří nové riziko se zadanými parametry.
     */
    public function createRisk($name, $description, $autoFlush)
    {
        $client = new Client($name, $description);
        $this->em->persist($client);
        if ($autoFlush) {
            $this->em->flush();
        }
    }

    /**
     * Upraví riziko zadanými hodnotami.
     */
    public function editClient($values, $autoFlush)
    {

        $startDate = new Nette\Utils\DateTime($values['startDate']);
        $endDate = new Nette\Utils\DateTime($values['endDate']);

        $client = $this->getClient($values['idClient']);

        $client->setName($values['idClient']);
        $client->setDescription($values['description']);
        $client->setStartDate($startDate);
        $client->setEndDate($endDate);

        $this->em->persist($client);
        if ($autoFlush) {
            $this->em->flush();
        }
    }

}