<?php
declare(strict_types=1);

namespace App\Handler\Contact;

use App\Entity\Contact;
use App\Form\Request\ContactRequest;
use Doctrine\ORM\EntityManagerInterface;

class Edit
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function prepopulate(Contact $contact, ContactRequest $request)
    {
        $request->fullName = $contact->getFullName();
        $request->telephone = $contact->getTelephone();
        $request->email = $contact->getEmail();
        $request->note = $contact->getNote();
    }

    public function handle(Contact $contact, ContactRequest $contactRequest)
    {
        $this->entityManager->persist($contact);

        $contact->setFullName($contactRequest->fullName);
        $contact->setEmail($contactRequest->email);
        $contact->setTelephone($contactRequest->telephone);
        $contact->setNote($contactRequest->note);

        $this->entityManager->flush();
    }

}
