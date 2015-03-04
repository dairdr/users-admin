<?php
namespace Application\Bundle\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormBuilderType extends AbstractType {
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'attr'=>['class'=>'form-control form-serialized', 'rows'=>5],
            'read_only'=>true,
        ]);
    }

    public function getParent()
    {
        return 'textarea';
    }

    public function getName()
    {
        return 'form_builder';
    }
}
