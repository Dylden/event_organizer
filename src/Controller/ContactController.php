<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {

        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $email = new Email();

            $emailTemplate = $this->renderView('contact/template.html.twig', [
                'contact' => $contact
            ]);

            $email->from('no-reply@mateo.com')
            ->to('contact@mateo.com')
            ->subject('Une demande de contact a été faite')
            ->html($emailTemplate);

            $mailer->send($email);

            $this->addFlash('success' , 'Message sent successfully !');
        return $this->redirectToRoute('app_contact');
        };

        return $this->render('contact/index.html.twig', [
            'form_view' => $form->createView(),
        ]);
    }
}
