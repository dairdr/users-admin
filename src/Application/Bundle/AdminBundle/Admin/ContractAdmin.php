<?php
namespace Application\Bundle\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ContractAdmin extends Admin {
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
            ->tab('Tab 1')
                ->with('Grupo 1', ['class'=>'col col-md-6'])
                    ->add(
                        'labelCode',
                        'text',
                        [
                            'label'=>'contract.sonata.form.label_code.label',
                            'required'=>true,
                        ]
                    )
                    ->add(
                        'object',
                        'text',
                        [
                            'label'=>'contract.sonata.form.object.label',
                            'required'=>true,
                        ]
                    )
                ->end()
                ->with('Grupo 2', ['class'=>'col col-md-6'])
                    ->add(
                        'value',
                        'number',
                        [
                            'label'=>'contract.sonata.form.value.label',
                            'precision'=>0,
                            'required'=>false,
                        ]
                    )
                    ->add(
                        'currency',
                        'currency',
                        [
                            'label'=>'contract.sonata.form.currency.label',
                            'required'=>false,
                        ]
                    )
                    ->add(
                        'startDate',
                        'sonata_type_date_picker',
                        [
                            'label'=>'contract.sonata.form.start_date.label',
                            'required'=>false,
                        ]
                    )
                    ->add(
                        'endDate',
                        'sonata_type_date_picker',
                        [
                            'label'=>'contract.sonata.form.end_date.label',
                            'required'=>false,
                        ]
                    )
                ->end()
            ->end()
            ->tab('Tab 2')
                ->with('Grupo 1', ['class'=>'col col-md-6'])
                    ->add(
                        'prefix',
                        'text',
                        [
                            'label'=>'contract.sonata.form.prefix.label',
                            'required'=>false,
                        ]
                    )
                    ->add(
                        'configContractType',
                        'sonata_type_model_autocomplete',
                        [
                            'label'=>'contract.sonata.form.config_contract_type.label',
                            'class'=>$this->container->getParameter('ctl_project.entities.config_contract_type_class'),
                            'property'=>'name',
                            'minimum_input_length'=>2,
                            'placeholder'=>$this->trans('contract.sonata.form.config_contract_type.placeholder'),
                            'required'=>true,
                        ]
                    )
                    ->add(
                        'enabled',
                        null,
                        [
                            'label'=>'contract.sonata.form.enabled.label',
                            'required'=>false,
                        ]
                    )
                    ->setHelps(
                        [
                            'startDate'=>'contract.sonata.form.start_date.help_message',
                            'endDate'=>'contract.sonata.form.end_date.help_message',
                        ]
                    )
                ->end()
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
                'labelCode',
                null,
                [
                    'label'=>'contract.sonata.filter.label_code.label',
                ]
            )
            ->add(
                'object',
                null,
                [
                    'label'=>'contract.sonata.filter.object.label',
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
                    'label'=>'contract.sonata.list.label_code.label',
                ]
            )
            ->add(
                'object',
                null,
                [
                    'label'=>'contract.sonata.list.object.label',
                ]
            )
            ->add(
                'value',
                null,
                [
                    'label'=>'contract.sonata.list.value.label',
                ]
            )
            ->add(
                'startDate',
                null,
                [
                    'label'=>'contract.sonata.list.start_date.label',
                ]
            )
            ->add(
                'endDate',
                null,
                [
                    'label'=>'contract.sonata.list.end_date.label',
                ]
            )
            ->add(
                'enabled',
                null,
                [
                    'label'=>'contract.sonata.list.enabled.label',
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
     * 
     * @param \Sonata\AdminBundle\Validator\ErrorElement $errorElement
     * @param \CTL\Bundle\ProjectBundle\Entity\Vendor $object
     */
    public function validate(\Sonata\AdminBundle\Validator\ErrorElement $errorElement, $object) {
        parent::validate($errorElement, $object);
    }
}
