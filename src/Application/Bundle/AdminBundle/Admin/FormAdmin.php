<?php
namespace Application\Bundle\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class FormAdmin extends Admin {
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
            ->with('Básico', ['class'=>'col col-md-6'])
                ->add(
                    'name',
                    'text',
                    [
                        'label'=>'form.sonata.form.name.label',
                        'required'=>true,
                    ]
                )
                ->add(
                    'description',
                    'textarea',
                    [
                        'label'=>'form.sonata.form.description.label',
                        'attr'=>['rows'=>4],
                        'required'=>false,
                    ]
                )
                ->add(
                    'enabled',
                    null,
                    [
                        'label'=>'form.sonata.form.enabled.label',
                        'required'=>false,
                    ]
                )
            ->end()
            ->with('Formulario', ['class'=>'col col-md-6'])
                ->add(
                    'content',
                    'form_builder',
                    [
                        'label'=>'form.sonata.form.content.label',
                        'trim'=>true,
                        'required'=>true,
                    ]
                )
            ->end()
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
                    'label'=>'form.sonata.filter.name.label',
                ]
            )
            ->add(
                'enabled',
                null,
                [
                    'label'=>'form.sonata.filter.enabled.label',
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
                    'label'=>'form.sonata.list.name.label',
                ]
            )
            ->add(
                'description',
                null,
                [
                    'label'=>'form.sonata.list.description.label',
                ]
            )
            ->add(
                'enabled',
                null,
                [
                    'label'=>'form.sonata.list.enabled.label',
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
     * @param \CTL\Bundle\ProjectBundle\Entity\Form $object
     */
    public function preUpdate($object)
    {
        $object->setUpdatedAt(new \DateTime());
        parent::preUpdate($object);
    }
    
    /**
     * Pre persist action.
     * 
     * @param \CTL\Bundle\ProjectBundle\Entity\Form $object
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
     * @param \CTL\Bundle\ProjectBundle\Entity\Form $object
     */
    public function validate(\Sonata\AdminBundle\Validator\ErrorElement $errorElement, $object) {
        parent::validate($errorElement, $object);
    }
}
