<?php
namespace Application\Bundle\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class NeighborhoodAdmin extends Admin {
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
                'name',
                'text',
                [
                    'label'=>'neighborhood.sonata.form.name.label',
                    'required'=>true,
                ]
            )
            ->add(
                'city',
                'sonata_type_model_autocomplete',
                [
                    'label'=>'neighborhood.sonata.form.city.label',
                    'class'=>$this->container->getParameter('ctl_project.entities.city_class'),
                    'property'=>'name',
                    'minimum_input_length'=>2,
                    'placeholder'=>  $this->trans('neighborhood.sonata.form.city.placeholder'),
                    'required'=>false,
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
                'name',
                null,
                [
                    'label'=>'neighborhood.sonata.filter.name.label',
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
                'name',
                null,
                [
                    'label'=>'neighborhood.sonata.list.name.label',
                ]
            )
            ->add(
                'city',
                null,
                [
                    'label'=>'neighborhood.sonata.list.city.label',
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
