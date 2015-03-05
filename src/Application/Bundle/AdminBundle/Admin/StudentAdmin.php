<?php
namespace Application\Bundle\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class StudentAdmin extends Admin
{
    private $container = null;
    
    public function __construct($code, $class, $baseControllerName, $container)
    {
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
                'names',
                'text',
                [
                    'label'=>'vendor.sonata.form.names.label',
                    'required'=>false,
                ]
            )
            ->add(
                'lastname',
                'text',
                [
                    'label'=>'vendor.sonata.form.lastnames.label',
                    'required'=>false,
                ]
            )
            ->add(
                'voted',
                null,
                [
                    'label'=>'vendor.sonata.form.enabled.label',
                    'required'=>false,
                ]
            )
            ->add(
                'voteCounting',
                null,
                [
                    'label'=>'vendor.sonata.form.enabled.label',
                    'required'=>false,
                ]
            )
            ->add(
                'isPersonero',
                null,
                [
                    'label'=>'vendor.sonata.form.enabled.label',
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
                'voted',
                null,
                [
                    'label'=>'admin.vendor.filter.lastnames.label',
                ]
            )
            ->add(
                'isPersonero',
                null,
                [
                    'label'=>'admin.vendor.filter.lastnames.label',
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
            ->add(
                'names',
                null,
                [
                    'label'=>'vendor.sonata.list.names.label',
                ]
            )
            ->add(
                'lastname',
                null,
                [
                    'label'=>'vendor.sonata.list.lastnames.label',
                ]
            )
            ->add(
                'voted',
                null,
                [
                    'label'=>'vendor.sonata.list.lastnames.label',
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
     * @param \CTL\Bundle\ProjectBundle\Entity\Vendor $object
     */
    public function preUpdate($object)
    {
        $object->setUpdatedAt(new \DateTime());
        $object->setFosUserUser($this->container->get('security.context')->getToken()->getUser());
        parent::preUpdate($object);
    }
    
    /**
     * Pre persist action.
     * 
     * @param \CTL\Bundle\ProjectBundle\Entity\Vendor $object
     */
    public function prePersist($object)
    {
        $object->setCreatedAt(new \DateTime());
        $object->setUpdatedAt(new \DateTime());
        $object->setFosUserUser($this->container->get('security.context')->getToken()->getUser());
        parent::prePersist($object);
    }
    
    /**
     * Validate action.
     * 
     * @param \Sonata\AdminBundle\Validator\ErrorElement $errorElement
     * @param \CTL\Bundle\ProjectBundle\Entity\Vendor $object
     */
    public function validate(\Sonata\AdminBundle\Validator\ErrorElement $errorElement, $object) {
        parent::validate($errorElement, $object);
    }
}
