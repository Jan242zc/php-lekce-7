<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\PurchaseOrder;
use App\Repository\ProgrammingLanguageRepository;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index()
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    
     /** 
        * @Route("/test/list", name="list", methods="GET")
        */
        public function test(ProgrammingLanguageRepository $programmingLanguageRepository)
        {
            return $this->render('test/index.html.twig', [
                'programmingLanguage' => $programmingLanguageRepository->findAll()
            ]);
        }
        
        /** 
        * @Route("/test/known", name="test_known", methods="GET")
        */
        public function known(ProgrammingLanguageRepository $programmingLanguageRepository)
        {
            return $this->render('test/known.html.twig', [
                'progLgs' => $programmingLanguageRepository->findKnown()
                ]);
        }
        
        /** 
        * @Route("/test/{id}", name="id", methods="GET")
        */
        public function detail(PurchaseOrder $purchaseOrder)
        {
            return $this->render('purchase_order/detail.html.twig', [
                'purchaseOrder' => $purchaseOrder
            ]);
        }
        
        
       
}
