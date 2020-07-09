<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ContactRepository;
use App\Entity\Contact;
use App\Form\Request\ContactRequest;
use App\Handler\Contact\Add;
use App\Handler\Contact\Edit;
use App\Handler\Contact\Delete;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @var ContactRepository
     */
    private ContactRepository $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function list(Request $request)
    {
        return $this->render('contact/list.html.twig', [
            'contacts' => $this->contactRepository->findAll()
        ]);
    }

    public function add(
        Request $request,
        Add $handler,
        ContactRequest $contactRequest)
    {
        //dd($request->request->get('contact'));
        if ($request->request->get('contact')) {
            $email = $request->request->get('contact')['email'];
            $contact = $this->contactRepository->findOneBy(['email' => $email]);
            if ($contact) {
                $this->addFlash('error', 'Contact already exists');
                return $this->redirect($this->generateUrl('list_contacts'));
            }
        }
        $form = $this->createForm(ContactType::class, $contactRequest, [
            'action' => $this->generateUrl('add_contact'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $handler->handle($contactRequest);
            $this->addFlash('success', 'Contact has been successfully added');

            return $this->redirect($this->generateUrl('list_contacts'));
        }

        return $this->render('contact/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Contact $contact
     * @param ContactRequest $contactRequest
     * @param Edit $handler
     * @Route("/{slug}", name="edit_contact")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit(
        Request $request,
        Contact $contact,
        ContactRequest $contactRequest,
        Edit $handler
    )
    {
        $handler->prepopulate($contact, $contactRequest);
        $form = $this->createForm(ContactType::class, $contactRequest, [
            'action' => $this->generateUrl('edit_contact', [
                'slug' => $contact->getSlug()
            ]),
            'method' => 'POST'
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $handler->handle($contact, $contactRequest);
            $this->addFlash('success', 'Contact has been successfully edited');
            return $this->redirect($this->generateUrl('list_contacts'));
        }

        return $this->render('contact/edit.html.twig', [
            'form' => $form->createView(),
            'contact' => $contact
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_contact", requirements={"id":"\d+"})
     */
    public function delete(
        Request $request,
        Contact $contact,
        Delete $handler
    )
    {
        $handler->handle($contact);
        $this->get('session')->getFlashBag()->set('success', 'Contact has been successfully deleted');

        return $this->render('contact/list.html.twig', [
            'contacts' => $this->contactRepository->findAll()
        ]);
    }
}
