<?php
namespace Application\Bundle\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class StateAdmin extends Admin {
    private $container = null;
    
    public function __construct($code, $class, $baseControllerName, $container) {
        parent::__construct($code, $class, $baseControllerName);
        $this->container = $container;
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
                    'label'=>'state.sonata.form.iata.label',
                    'required'=>true,
                ]
            )
            ->add(
                'name',
                'text',
                [
                    'label'=>'state.sonata.form.name.label',
                    'required'=>true,
                ]
            )
            ->add(
                'country',
                'sonata_type_model_autocomplete',
                [
                    'label'=>'state.sonata.form.country.label',
                    'class'=>$this->container->getParameter('ctl_project.entities.country_class'),
                    'property'=>'name',
                    'minimum_input_length'=>2,
                    'placeholder'=>$this->trans('state.sonata.form.country.placeholder'),
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
                    'label'=>'state.sonata.filter.iata.label',
                ]
            )
            ->add(
                'name',
                null,
                [
                    'label'=>'state.sonata.filter.name.label',
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
                    'label'=>'state.sonata.list.iata.label',
                ]
            )
            ->add(
                'name',
                null,
                [
                    'label'=>'state.sonata.list.name.label',
                ]
            )
            ->add(
                'country',
                null,
                [
                    'label'=>'state.sonata.list.country.label',
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
