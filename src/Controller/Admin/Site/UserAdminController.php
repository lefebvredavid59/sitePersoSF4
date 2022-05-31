<?php

namespace App\Controller\Admin\Site;

use App\Entity\User;
use App\Form\Admin\Site\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class UserAdminController extends AbstractController
{
    /**
     * @Route("/", name="user_admin_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/site/user_admin/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_admin_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('admin/site/user_admin/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_admin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/site/user_admin/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_admin_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
