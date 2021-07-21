<?php

namespace App\Controller;

use App\Entity\Loan;
use App\Form\LoanType;
use App\Repository\LoanRepository;
use App\Repository\BorrowerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * @Route("/loan")
 */
class LoanController extends AbstractController
{
    /**
     * @Route("/", name="loan_index", methods={"GET"})
     */
    public function index(LoanRepository $loanRepository, BorrowerRepository $borrowerRepository): Response
    {
        $user = $this->getUser();
        $loans = $loanRepository->findAll();

        // On récupère le compte de l'utilisateur authentifié
        

        // On vérifie si l'utilisateur est un student
        // Note : on peut aussi utiliser $this->isGranted('ROLE_STUDENT') au
        // lieu de in_array('ROLE_STUDENT', $user->getRoles()).
        if ($this->isGranted('ROLE_BORROWER')) {
            // L'utilisateur est un student

            // On récupère le profil student lié au compte utilisateur
            $borrower = $borrowerRepository->findOneByUser($user);

            // On récupère la school year de l'utilisater 
            $loans = $borrower->getLoans();
            
        }
        return $this->render('loan/index.html.twig', [
            'loans' => $loans,
        ]);
    }

    /**
     * @Route("/new", name="loan_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $loan = new Loan();
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($loan);
            $entityManager->flush();

            return $this->redirectToRoute('loan_index');
        }

        return $this->render('loan/new.html.twig', [
            'loan' => $loan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="loan_show", methods={"GET"})
     */
    public function show(Loan $loan, BorrowerRepository $borrowerRepository): Response
    {
        if ($this->isGranted('ROLE_BORROWER')) {
            // L'utilisateur est un EMPRUNTEUR
            
            // On récupère le compte de l'utilisateur authentifié
            $user = $this->getUser();

            // On récupère le profil student lié au compte utilisateur
            $borrower = $borrowerRepository->findOneByUser($user);

            // On vérifie si la school year que l'utilisateur demande et la school year
            // auquel il est rattaché correspondent.
            // Si ce n'est pas le cas on lui renvoit un code 404
            if (!$borrower->getLoans()->contains($loan)){
                throw new NotFoundHttpException();
            }

        }
        return $this->render('loan/show.html.twig', [
            'loan' => $loan,]);
        
        }

    /**
     * @Route("/{id}/edit", name="loan_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Loan $loan): Response
    {
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('loan_index');
        }

        return $this->render('loan/edit.html.twig', [
            'loan' => $loan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="loan_delete", methods={"POST"})
     */
    public function delete(Request $request, Loan $loan): Response
    {
        if ($this->isCsrfTokenValid('delete'.$loan->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($loan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('loan_index');
    }
}
