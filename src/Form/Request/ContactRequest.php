<?php
declare(strict_types=1);

namespace App\Form\Request;
use Symfony\Component\Form\Extension\Validator\Constraints;

class ContactRequest
{
    /**
     * @Constraints\NotBlank
     * @var string
     */
    public ?string $fullName = null;

    /**
     * @Constraints\NotBlank
     * @Constraints\Length(
     *      min = 9,
     *      minMessage = "Telefon must have at least 9 numbers",
     * )
     * @var string
     */
    public ?string $telephone = null;

    /**
     * @CustomConstraint\NotBlank(message="Email is required")
     * @Constraint\Email(message="notEmail")
     *
     * @var string
     */
    public ?string $email = null;

    /**
     * @var string
     */
    public ?string $note = null;
}
