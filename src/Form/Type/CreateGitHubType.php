<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;

class CreateGitHubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('count', IntegerType::class,
            [
                'label' => 'Enter the number of the top PHP repositories to save:',
                'constraints' => [
                    new Range(
                        [
                            'min' => 1,
                            'max' => 100,
                        ]
                    )
                ]
            ]
            )
            ->add('save', SubmitType::class)
        ;
    }
}