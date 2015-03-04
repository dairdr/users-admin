<?php
namespace Application\Bundle\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ProjectAdmin extends Admin {
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
                'labelCode',
                'text',
                [
                    'label'=>'project.sonata.form.label_code.label',
                    'required'=>true,
                ]
            )
            ->add(
                'name',
                'text',
                [
                    'label'=>'project.sonata.form.name.label',
                    'required'=>true,
                ]
            )
            ->add(
                'address',
                'text',
                [
                    'label'=>'project.sonata.form.address.label',
                    'required'=>false,
                ]
            )
            ->add(
                'phone',
                'text',
                [
                    'label'=>'project.sonata.form.phone.label',
                    'required'=>false,
                ]
            )
            ->add(
                'email',
                'email',
                [
                    'label'=>'project.sonata.form.email.label',
                    'required'=>false,
                ]
            )
            ->add(
                'description',
                'textarea',
                [
                    'label'=>'project.sonata.form.description.label',
                    'required'=>false,
                ]
            )
            ->add(
                'observation',
                'textarea',
                [
                    'label'=>'project.sonata.form.observation.label',
                    'required'=>false,
                ]
            )
            ->add(
                'city',
                'sonata_type_model_autocomplete',
                [
                    'label'=>'project.sonata.form.city.label',
                    'class'=>$this->container->getParameter('ctl_project.entities.city_class'),
                    'property'=>'name',
                    'minimum_input_length'=>2,
                    'placeholder'=>$this->trans('project.sonata.form.city.placeholder'),
                    'required'=>false,
                ]
            )
            ->add(
                'neighborhood',
                'sonata_type_model_autocomplete',
                [
                    'label'=>'project.sonata.form.neighborhood.label',
                    'class'=>$this->container->getParameter('ctl_project.entities.neighborhood_class'),
                    'property'=>'name',
                    'minimum_input_length'=>2,
                    'placeholder'=>$this->trans('project.sonata.form.neighborhood.placeholder'),
                    'required'=>false,
                ]
            )
            ->add(
                'area',
                'sonata_type_model_autocomplete',
                [
                    'label'=>'project.sonata.form.area.label',
                    'class'=>$this->container->getParameter('ctl_project.entities.area_class'),
                    'property'=>'name',
                    'minimum_input_length'=>2,
                    'placeholder'=>$this->trans('project.sonata.form.area.placeholder'),
                    'required'=>false,
                ]
            )
            ->add(
                'contract',
                'sonata_type_model_autocomplete',
                [
                    'label'=>'project.sonata.form.contract.label',
                    'class'=>$this->container->getParameter('ctl_project.entities.contract_class'),
                    'property'=>'object',
                    'minimum_input_length'=>2,
                    'placeholder'=>$this->trans('project.sonata.form.contract.placeholder'),
                    'required'=>false,
                ]
            )
            ->add(
                'configProjectState',
                'sonata_type_model_autocomplete',
                [
                    'label'=>'project.sonata.form.config_project_state.label',
                    'class'=>$this->container->getParameter('ctl_project.entities.config_project_state_class'),
                    'property'=>'name',
                    'minimum_input_length'=>2,
                    'placeholder'=>$this->trans('project.sonata.form.config_project_state.placeholder'),
                    'required'=>true,
                ]
            )
            ->add(
                'enabled',
                null,
                [
                    'label'=>'project.sonata.form.enabled.label',
                    'required'=>false,
                ]
            )
            ->add(
                'website',
                'url',
                [
                    'label'=>'project.sonata.form.website.label',
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
                'labelCode',
                null,
                [
                    'label'=>'project.sonata.filter.label_code.label',
                ]
            )
            ->add(
                'name',
                null,
                [
                    'label'=>'project.sonata.filter.name.label',
                ]
            )
            ->add(
                'website',
                null,
                [
                    'label'=>'project.sonata.filter.website.label',
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
                'labelCode',
                null,
                [
                    'label'=>'project.sonata.list.label_code.label',
                ]
            )
            ->add(
                'name',
                null,
                [
                    'label'=>'project.sonata.list.name.label',
                ]
            )
            ->add(
                'city',
                null,
                [
                    'label'=>'project.sonata.list.city.label',
                ]
            )
            ->add(
                'configProjectState',
                null,
                [
                    'label'=>'project.sonata.list.config_project_state.label',
                ]
            )
            ->add(
                'enabled',
                null,
                [
                    'label'=>'project.sonata.list.enabled.label',
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
     * @param \CTL\Bundle\ProjectBundle\Entity\Project $object
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
     * @param \CTL\Bundle\ProjectBundle\Entity\Project $object
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
     * @param \CTL\Bundle\ProjectBundle\Entity\Project $object
     */
    public function validate(\Sonata\AdminBundle\Validator\ErrorElement $errorElement, $object) {
        parent::validate($errorElement, $object);
    }
}
