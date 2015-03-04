<?php
namespace Application\Bundle\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CountryAdmin extends Admin {
    
    public function __construct($code, $class, $baseControllerName) {
        parent::__construct($code, $class, $baseControllerName);
    }

    /**
     * Fields to be shown on create/edit forms.
     * 
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add(
                'iata',
                'text',
                [
                    'label'=>'country.sonata.form.iata.label',
                    'required'=>true,
                ]
            )
            ->add(
                'name',
                'text',
                [
                    'label'=>'country.sonata.form.name.label',
                    'required'=>true,
                ]
            )
        ;
    }

    /**
     * Fields to be shown on filter forms.
     * 
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'iata',
                null,
                [
                    'label'=>'country.sonata.filter.iata.label',
                ]
            )
            ->add(
                'name',
                null,
                [
                    'label'=>'country.sonata.filter.name.label',
                ]
            )
        ;
    }

    /**
     * Fields to be shown on lists.
     * 
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier(
                'iata',
                null,
                [
                    'label'=>'country.sonata.list.iata.label',
                ]
            )
            ->add(
                'name',
                null,
                [
                    'label'=>'country.sonata.list.name.label',
                ]
            )
            ->add(
                '_action',
                'actions',
                [
                    'actions'=>[
                        'show'=>[],
                        'edit'=>[],
                        'delete'=>[],
                    ]
                ]
            )
        ;
    }
}
