<?php

namespace App\Form;

use App\Entity\Rdv;
use App\Repository\UtilisateurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RdvType extends AbstractType
{
    private $userRepo;
    public function __construct(UtilisateurRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('idCoach', ChoiceType::class, array(
                'choices' => $this->userRepo->findBy(["type"=>'coach']),
                'choice_value' =>'idUtilisateur',
                'choice_label' => 'fullName',
    ))

            ->add('date', TextType::class,array(
                'required' => true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rdv::class,
        ]);
    }
}
