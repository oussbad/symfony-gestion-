<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    /**
     * Recherche les projets en fonction du titre et du statut.
     *
     * @param string|null $title Le titre à rechercher (optionnel)
     * @param string|null $status Le statut à filtrer (optionnel)
     * @return Project[] Liste des projets correspondants aux critères de recherche
     */
    public function findByFilters(?string $title, ?string $status): array
    {
        $qb = $this->createQueryBuilder('p');

        if ($title) {
            $qb->andWhere('p.title LIKE :title')
               ->setParameter('title', '%'.$title.'%');
        }

        if ($status) {
            $qb->andWhere('p.status = :status')
               ->setParameter('status', $status);
        }

        return $qb->getQuery()->getResult();
    }
}
