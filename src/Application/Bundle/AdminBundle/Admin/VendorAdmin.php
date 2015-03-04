<?php
namespace Application\Bundle\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class VendorAdmin extends Admin {
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
                'identificationNumber',
                'text',
                [
                    'label'=>'vendor.sonata.form.identification_number.label',
                    'required'=>true,
                ]
            )
            ->add(
                'verificationDigit',
                'text',
                [
                    'label'=>'vendor.sonata.form.verification_digit.label',
                    'required'=>false,
                ]
            )
            ->add(
                'businessName',
                'text',
                [
                    'label'=>'vendor.sonata.form.business_name.label',
                    'required'=>false,
                ]
            )
            ->add(
                'names',
                'text',
                [
                    'label'=>'vendor.sonata.form.names.label',
                    'required'=>false,
                ]
            )
            ->add(
                'lastnames',
                'text',
                [
                    'label'=>'vendor.sonata.form.lastnames.label',
                    'required'=>false,
                ]
            )
            ->add(
                'configDocumentType',
                'sonata_type_model_autocomplete',
                [
                    'label'=>'vendor.sonata.form.config_document_type.label',
                    'class'=>$this->container->getParameter('ctl_project.entities.config_document_type_class'),
                    'property'=>'name',
                    'minimum_input_length'=>2,
                    'placeholder'=>$this->trans('vendor.sonata.form.config_document_type.placeholder'),
                    'required'=>true,
                ]
            )
            ->add(
                'configVendorType',
                'sonata_type_model_autocomplete',
                [
                    'label'=>'vendor.sonata.form.config_vendor_type.label',
                    'class'=>$this->container->getParameter('ctl_project.entities.config_vendor_type_class'),
                    'property'=>'name',
                    'minimum_input_length'=>2,
                    'placeholder'=>$this->trans('vendor.sonata.form.config_vendor_type.placeholder'),
                    'required'=>true,
                ]
            )
            ->add(
                'enabled',
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
                'identificationNumber',
                null,
                [
                    'label'=>'vendor.sonata.filter.identification_number.label',
                ]
            )
            ->add(
                'verificationDigit',
                null,
                [
                    'label'=>'vendor.sonata.filter.verification_digit.label',
                ]
            )
            ->add(
                'businessName',
                null,
                [
                    'label'=>'vendor.sonata.filter.business_name.label',
                ]
            )
            ->add(
                'names',
                null,
                [
                    'label'=>'admin.vendor.filter.names.label',
                ]
            )
            ->add(
                'lastnames',
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
            ->addIdentifier(
                'identificationNumber',
                null,
                [
                    'label'=>'vendor.sonata.list.identification_number.label',
                ]
            )
            ->add(
                'verificationDigit',
                null,
                [
                    'label'=>'vendor.sonata.list.verification_digit.label',
                ]
            )
            ->add(
                'businessName',
                null,
                [
                    'label'=>'vendor.sonata.list.business_name.label',
                ]
            )
            ->add(
                'names',
                null,
                [
                    'label'=>'vendor.sonata.list.names.label',
                ]
            )
            ->add(
                'lastnames',
                null,
                [
                    'label'=>'vendor.sonata.list.lastnames.label',
                ]
            )
            ->add(
                'configDocumentType',
                null,
                [
                    'label'=>'vendor.sonata.list.config_document_type.label',
                ]
            )
            ->add(
                'configVendorType',
                null,
                [
                    'label'=>'vendor.sonata.list.config_vendor_type.label',
                ]
            )
            ->add(
                'enabled',
                null,
                [
                    'label'=>'vendor.sonata.list.enabled.label',
                    'editable'=>true,
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
