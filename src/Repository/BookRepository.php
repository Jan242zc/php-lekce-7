<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Book::class);
    }
    
/**
 * @return BookCentury[]
 */
public function showByCentury($dolni, $horni)
{
    return $this->createQueryBuilder('c')
        ->andWhere('c.rok_vydani >= :dolni')
        ->setParameter('dolni', $dolni)
        ->andWhere('c.rok_vydani <= :horni')
        ->setParameter('horni', $horni)
        ->getQuery()
        ->getResult()
    ;
}

//pomocná funkce pro získání autorů v databázi
/**
 * @return BookAuthors[]
 */
public function getAuthors()
{
    return $this->createQueryBuilder('b')
        ->select(array('b.autor'))
        ->getQuery()
        ->getResult()
    ;
}

// toto hází chybu, kterou zmiňuje v BookController.php
/**
 * @return BooksAuthors[]
 */
public function getByAuthors($autor)
{
    return $this->createQueryBuilder('a')
        ->andWhere('a.autor = :autor')
        ->setParameter('autor', $autor)
        ->getQuery()
        ->getResult()
    ;
}

/**
 * @return BookPrice[]
 */
public function orderByPrice()
{
    return $this->createQueryBuilder('p')
        ->orderBy('p.cena', 'DESC')
        ->getQuery()
        ->getResult()
    ;
}

/**
 * @return BookNew[]
 */
public function findNew()
{
    return $this->CreateQueryBuilder('n')
        ->andWhere('n.rok_vydani >= :parametr')
        ->setParameter('parametr', date("Y") - 2)
        ->getQuery()
        ->getResult()
    ;
}

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
