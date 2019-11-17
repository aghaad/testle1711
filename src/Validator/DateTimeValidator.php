<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use App\Entity\Commande;

class DateTimeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint App\Validator\DateTime */

        $datetime = new \DateTime();
        $hour = date('G');
        $datetime->diff($DateCommande);
        if ($datetime == $DateCommande && $formule == 1 && $hour >= 14) {
            return true;
        } else {
            return false;
        };
        // journée = 1 et demi-journée=0
        // if $datecommande = today && journée=ok && timetoday>14 (message d'erreur)

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
