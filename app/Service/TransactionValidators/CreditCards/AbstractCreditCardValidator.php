<?php

namespace App\Service\TransactionValidators\CreditCards;

abstract class AbstractCreditCardValidator
{
    public $nextValidation;

    public function link(AbstractCreditCardValidator $nextValidator): AbstractCreditCardValidator
    {
        $this->nextValidation = $this->nextValidation;

        return $nextValidator;
    }

    public function validate(): bool
    {
        if (!$this->nextValidation) {
            return true;
        }

        return $this->nextValidation->validate();
    }
}
