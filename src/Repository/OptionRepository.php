<?php

namespace App\Repository;

use App\Entity\Option;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function array_values;

/**
 * @extends ServiceEntityRepository<Option>
 *
 * @method Option|null find($id, $lockMode = null, $lockVersion = null)
 * @method Option|null findOneBy(array $criteria, array $orderBy = null)
 * @method Option[]    findAll()
 * @method Option[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Option::class);
    }

    public function findByName(string $name): ?Option
    {
        return $this->findOneBy(['name'=>$name]);
    }

    /**
     * @param array $names
     * @return array|Option[]
     */
    public function findByNames(array $names): array
    {
        return $this->createQueryBuilder('o')
            ->where('o.name IN (?1)')
            ->setParameter(1, array_values($names))
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array|Option[]
     */
    public function findAllAutoload(): array
    {
        return $this->createQueryBuilder('o')
            ->where('o.autoload = ?1')
            ->setParameter(1, true)
            ->getQuery()
            ->getResult();
    }

    public function save(Option $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Option $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
