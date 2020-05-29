<?php

namespace App\Repository;

use App\Entity\ContactPro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContactPro|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactPro|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactPro[]    findAll()
 * @method ContactPro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactProRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactPro::class);
    }

    public function findContactsByPrenom(string $prenom) {
        return $this->findBy(
            array('prenom' => $prenom)
        );
    }

    public function findContactsRecent(array $search) {
        $query = $this->createQueryBuilder('c')
            // ->select('COUNT(c)')
            ->orderBy('c.id', 'DESC')
            // ->setMaxResults(1)
        ;

        if ($search['date']) {
            $query
                ->andWhere('c.createdAt > :date')
                ->setParameter('date', $search['date']);
        }

        if ($search['prenom']) {
            $query
                ->andWhere('c.prenom = :prenom')
                ->setParameter('prenom', $search['prenom']);
        }

        return $query->getQuery()->getResult();
    }
}
