<?php

namespace AppBundle\Service;


use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

class HotelFormHelper
{

    /**
     * @param FormInterface $form
     *
     * @return array
     */
    public function getFormErrors(FormInterface $form)
    {
        $errors = [];
        // Global
        foreach ($form->getErrors() as $error) {
            $errors[$form->getName()][] = $error->getMessage();
        }

        // Fields
        /** @var Form $child */
        foreach ($form as $child) {
            if (!$child->isValid()) {
                foreach ($child->getErrors() as $error) {
                    $errors[$child->getName()][] = $error->getMessage();
                }
            }
        }

        return $errors;
    }
}