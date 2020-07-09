<?php
declare(strict_types=1);

namespace App\Handler\Contact;

use App\Entity\Contact;
use App\Form\Request\ContactRequest;
use Doctrine\ORM\EntityManagerInterface;

class Add
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ContactRequest $contactRequest)
    {
        $contact = new Contact(
            $contactRequest->fullName,
            $contactRequest->telephone,
            $contactRequest->email,
            $contactRequest->note
        );
        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        return $contact;
    }

}
