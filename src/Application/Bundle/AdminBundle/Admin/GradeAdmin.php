<?php
namespace Application\Bundle\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class GradeAdmin extends Admin
{
    
    public function __construct($code, $class, $baseControllerName)
    {
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
                    'label' => 'grade.sonata.form.name.label',
                    'required' => true,
                ]
            )
            ->add(
                'description',
                'textarea',
                [
                    'label' => 'grade.sonata.form.description.label',
                    'required' => false,
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
                    'label' => 'grade.sonata.filter.name.label',
                ]
            )
            ->add(
                'description',
                null,
                [
                    'label' => 'grade.sonata.filter.description.label',
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
                    'label' => 'grade.sonata.list.name.label',
                ]
            )
            ->add(
                'description',
                null,
                [
                    'label' => 'grade.sonata.list.description.label',
                ]
            )
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'show' => [],
                        'edit' => [],
                        'delete' => [],
                    ]
                ]
            )
        ;
    }
}
