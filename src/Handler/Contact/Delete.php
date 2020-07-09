<?php
declare(strict_types=1);

namespace App\Handler\Contact;

use App\Entity\Contact;
use App\Form\Request\ContactRequest;
use Doctrine\ORM\EntityManagerInterface;

class Delete
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(Contact $contact)
    {
        $this->entityManager->remove($contact);
        $this->entityManager->flush();
    }

}

