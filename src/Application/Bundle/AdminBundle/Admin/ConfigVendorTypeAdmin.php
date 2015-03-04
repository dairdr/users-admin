<?php
namespace Application\Bundle\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ConfigVendorTypeAdmin extends Admin {
    
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
                'name',
                'text',
                [
                    'label'=>'config_vendor_type.sonata.form.name.label',
                    'required'=>true,
                ]
            )
            ->add(
                'description',
                'textarea',
                [
                    'label'=>'config_vendor_type.sonata.form.description.label',
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
                    'label'=>'config_vendor_type.sonata.filter.name.label',
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
                    'label'=>'config_vendor_type.sonata.list.name.label',
                ]
            )
            ->add(
                'description',
                null,
                [
                    'label'=>'config_vendor_type.sonata.list.description.label',
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
