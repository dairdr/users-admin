<?php
namespace Application\Bundle\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class OfficeAdmin extends Admin {
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
                    'label'=>'office.sonata.form.name.label',
                    'required'=>true,
                ]
            )
            ->add(
                'address',
                'text',
                [
                    'label'=>'office.sonata.form.address.label',
                    'required'=>false,
                ]
            )
            ->add(
                'phone',
                'text',
                [
                    'label'=>'office.sonata.form.phone.label',
                    'required'=>false,
                ]
            )
            ->add(
                'mobile',
                'text',
                [
                    'label'=>'office.sonata.form.mobile.label',
                    'required'=>false,
                ]
            )
            ->add(
                'email',
                'email',
                [
                    'label'=>'office.sonata.form.email.label',
                    'required'=>false,
                ]
            )
            ->add(
                'vendor',
                'sonata_type_model_autocomplete',
                [
                    'label'=>'office.sonata.form.vendor.label',
                    'class'=>$this->container->getParameter('ctl_project.entities.vendor_class'),
                    'property'=>'businessName',
                    'minimum_input_length'=>2,
                    'placeholder'=>  $this->trans('office.sonata.form.vendor.placeholder'),
                    'required'=>true,
                ]
            )
            ->add(
                'city',
                'sonata_type_model_autocomplete',
                [
                    'label'=>'office.sonata.form.city.label',
                    'class'=>$this->container->getParameter('ctl_project.entities.city_class'),
                    'property'=>'name',
                    'minimum_input_length'=>2,
                    'placeholder'=>  $this->trans('office.sonata.form.city.placeholder'),
                    'required'=>true,
                ]
            )
            ->add(
                'neighborhood',
                'sonata_type_model_autocomplete',
                [
                    'label'=>'office.sonata.form.neighborhood.label',
                    'class'=>$this->container->getParameter('ctl_project.entities.neighborhood_class'),
                    'property'=>'name',
                    'minimum_input_length'=>2,
                    'placeholder'=>  $this->trans('office.sonata.form.neighborhood.placeholder'),
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
                    'label'=>'office.sonata.filter.name.label',
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
                null ,
                [
                    'label'=>'office.sonata.list.name.label',
                ]
            )
            ->add(
                'vendor',
                null,
                [
                    'label'=>'office.sonata.list.vendor.label',
                ]
            )
            ->add(
                'address',
                null,
                [
                    'label'=>'office.sonata.list.address.label',
                ]
            )
            ->add(
                'city',
                null,
                [
                    'label'=>'office.sonata.list.city.label',
                ]
            )
            ->add(
                'phone',
                null,
                [
                    'label'=>'office.sonata.list.phone.label',
                ]
            )
            ->add(
                'email',
                null,
                [
                    'label'=>'office.sonata.list.email.label',
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
    
    /**
     * Pre update action.
     * 
     * @param \CTL\Bundle\ProjectBundle\Entity\Office $object
     */
    public function preUpdate($object)
    {
        $object->setUpdatedAt(new \DateTime());
        parent::preUpdate($object);
    }
    
    /**
     * Pre persist action.
     * 
     * @param \CTL\Bundle\ProjectBundle\Entity\Office $object
     */
    public function prePersist($object)
    {
        $object->setCreatedAt(new \DateTime());
        $object->setUpdatedAt(new \DateTime());
        parent::prePersist($object);
    }
    
    /**
     * Validate action.
     * 
     * @param \Sonata\AdminBundle\Validator\ErrorElement $errorElement
     * @param \CTL\Bundle\ProjectBundle\Entity\Office $object
     */
    public function validate(\Sonata\AdminBundle\Validator\ErrorElement $errorElement, $object) {
        parent::validate($errorElement, $object);
    }
}
