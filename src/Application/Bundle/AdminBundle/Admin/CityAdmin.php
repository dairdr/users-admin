<?php
namespace Application\Bundle\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CityAdmin extends Admin {
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
                    'label'=>'city.sonata.form.iata.label',
                    'required'=>true,
                ]
            )
            ->add(
                'name',
                'text',
                [
                    'label'=>'city.sonata.form.name.label',
                    'required'=>true,
                ]
            )
            ->add(
                'zipcode',
                'text',
                [
                    'label'=>'city.sonata.form.zipcode.label',
                    'required'=>false,
                ]
            )
            ->add(
                'state',
                'sonata_type_model_autocomplete',
                [
                    'label'=>'city.sonata.form.state.label',
                    'class'=>$this->container->getParameter('ctl_project.entities.state_class'),
                    'property'=>'name',
                    'minimum_input_length'=>2,
                    'placeholder'=>  $this->trans('city.sonata.form.state.placeholder'),
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
                    'label'=>'city.sonata.filter.iata.label',
                ]
            )
            ->add(
                'name',
                null,
                [
                    'label'=>'city.sonata.filter.name.label',
                ]
            )
            ->add(
                'zipcode',
                null,
                [
                    'label'=>'city.sonata.filter.zipcode.label',
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
                    'label'=>'city.sonata.list.iata.label',
                ]
            )
            ->add(
                'name',
                null,
                [
                    'label'=>'city.sonata.list.name.label',
                ]
            )
            ->add(
                'state',
                null,
                [
                    'label'=>'city.sonata.list.state.label',
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
