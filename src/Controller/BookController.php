<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="book_index", methods="GET")
     */
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', ['books' => $bookRepository->findAll()]);
    }
    
    /**
     * @Route("/listing/century", name="booklisting_century", methods="GET")
     */
    public function century(BookRepository $bookRepository): Response
    {
        return $this->render('book/century.html.twig', ['books' => [
        'pred1900' => $bookRepository->showByCentury(0, 1900),
        'dvacate' => $bookRepository->showByCentury(1900, 2000),
        'po2000' => $bookRepository->showByCentury(2000,3000)
        ]]);
    }
    
    //Tady jsem chtěl vytvořenou službou v BookRepository dát do pole $autori všechny autory v databázi (to se zadařilo).
    //Potom vytvořit asociativní pole $dleAutora, do kterého se zanesou hodnoty z databáze dle autorů, stejně jako se 
    // v předchozí funkci do pole 'books' zanesly záznamy dle století.
    //Výsledkem je však chyba SQLSTATE[HY093]: Invalid parameter number: parameter was not 
    //Chci odevzdat úkol v termínu, takže o tom nadále budu dumat sám :)
    /**
     * @Route("/listing/author", name="booklisting_author", methods="GET")
     */
    public function author(BookRepository $bookRepository): Response
    {
        $autori = $bookRepository->getAuthors();
        $dleAutora = [];
        foreach ($autori as $autor) {
            $dleAutora[$autor] = $bookRepository->getByAuthors($autor);
        }
        return $this->render('book/authors.html.twig', ['books' => $dleAutora]);
    }
    
    /**
     * @Route("/listing/price", name="booklisting_price", methods="GET")
     */
    public function price(BookRepository $bookRepository): Response
    {
        return $this->render('book/price.html.twig', ['books' => $bookRepository->orderByPrice()]);
    }
    
    /**
     * @Route("/listing/new", name="booklisting_new", methods="GET")
     */
    public function listNew(BookRepository $bookRepository): Response
    {
        return $this->render('book/listnew.html.twig', ['books' => $bookRepository->findNew()]);
    }
    
    /**
     * @Route("/new", name="book_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="book_show", methods="GET")
     */
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', ['book' => $book]);
    }

    /**
     * @Route("/{id}/edit", name="book_edit", methods="GET|POST")
     */
    public function edit(Request $request, Book $book): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('book_edit', ['id' => $book->getId()]);
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="book_delete", methods="DELETE")
     */
    public function delete(Request $request, Book $book): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($book);
            $em->flush();
        }

        return $this->redirectToRoute('book_index');
    }
}

// snažil jsem se vytvořit novou třídu, jak se píše v zadání, ale Symfony mi hlásilo, že stránku nelze najít :(

///**
// * @Route("/booklisting")
// */
/*class BookListingController extends AbstractController
{
    /**
     * @Route("/century", name="book_century", methods="GET")
     */
  /*  public function century(BookRepository $bookRepository): Response
    {
        return $this->render('book/century.html.twig', ['book' => $bookRepository->showByCentury()]);
    }
} */

