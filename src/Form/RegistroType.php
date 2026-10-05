<?php

namespace App\Form;

use App\Entity\Registro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class RegistroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'required' => true,
            ])
            ->add('paterno', TextType::class, [
                'required' => true,
            ])
            ->add('materno', TextType::class, [
                'required' => false,
            ])
            ->add('direccion', TextType::class, [
                'required' => true,
            ])
            ->add('mail', TextType::class, [
                'required' => true,
            ])
            ->add('solicitudFile', VichFileType::class, [
                'required' => true,
                'label' => '*Carta Solicitud',
            ])
            ->add('cvFile', VichFileType::class, [
                'required' => true,
                'label' => '*Currículum Vitae',
            ])
            ->add('comprobanteFile', VichFileType::class, [
                'required' => true,
                'label' => '*Comprobante oficial de grado',
            ])
            ->add('proyectoFile', VichFileType::class, [
                'required' => true,
                'label' => '*Proyecto de investigación',
            ])
            ->add('articulosFile', VichFileType::class, [
                'required' => true,
                'label' => '*Sobretiros de artículos publicados y versiones preliminares de artículos aceptados',
            ])
            ->add('ref1nombre', TextType::class, [
                'required' => true,
            ])
            ->add('ref1mail', TextType::class, [
                'required' => true,
            ])
            ->add('ref1recomFile', VichFileType::class, [
                'required' => true,
                'label' => 'Recomendación',
                'allow_delete' => false,
            ])
            ->add('ref2nombre', TextType::class, [
                'required' => true,
            ])
            ->add('ref2mail', TextType::class, [
                'required' => true,
            ])
            ->add('ref2recomFile', VichFileType::class, [
                'required' => true,
                'label' => 'Recomendación',
            ])
            ->add('ref3nombre', TextType::class, [
                'required' => true,
            ])
            ->add('ref3mail', TextType::class, [
                'required' => true,
            ])
            ->add('ref3recomFile', VichFileType::class, [
                'required' => true,
                'label' => 'Recomendación',
            ])
            ->add('activo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Registro::class,
        ]);
    }
}
