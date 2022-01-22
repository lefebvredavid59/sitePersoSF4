<?php

namespace App\Controller\Site;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ArticleRepository;
use App\Repository\SiteRepository;
use App\Repository\SocialRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(SiteRepository $siteRepository, ArticleRepository $articleRepository): Response
    {
        return $this->render('site/home/home.html.twig', [
            'dispos' => $siteRepository->findAll(),
            'articles' => $articleRepository->articleHome(),
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(SocialRepository $socialRepository): Response
    {
        return $this->render('site/about/about.html.twig', [
            'socials' => $socialRepository->findAll(),
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, MailerInterface $mailer, SocialRepository $socialRepository): Response
    {
        $contact = new Contact();
        $contactForm = $this->createForm(ContactType::class, $contact);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->from($contact->getEmailContact())
                ->to('contact@lefebvredavid.fr')
                ->addTo('dlefebvredev@gmail.com')
                ->subject($contact->getSubjectContact())
                ->context([
                    'contact_subject' => $contact->getSubjectContact(),
                    'contact_name' => $contact->getContactName(),
                    'contact_email' => $contact->getEmailContact(),
                    'message' => $contact->getMessageContact(),
                ])
                ->htmlTemplate('template/email/contactEmail.html.twig');

            $mailer->send($email);

            $this->addFlash('success_contact', 'Votre email 📧 a bien été envoyé 📨');

            $entityManager->remove($contact);
            $entityManager->flush();
        }
        return $this->render('site/home/contact.html.twig', [
            'socials' => $socialRepository->findAll(),
            'contactform' => $contactForm->createView(),
        ]);
    }
}
