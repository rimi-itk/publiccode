<?php

namespace App\Form;

use App\Entity\Crawler\PublisherCodeHosting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;

class PublisherCodeHostingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', TextType::class, [
                'help' => new TranslatableMessage(
                    'Enter an organization url, e.g. <code>https://github.com/octocat</code>, if "Is organization url" is set or a repository url, e.g. <code>https://github.com/octocat/Hello-World</code>'
                ),
            ])
            ->add('isGroup', CheckboxType::class, [
                'label' => new TranslatableMessage('Is organization url'),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PublisherCodeHosting::class,
        ]);
    }
}
