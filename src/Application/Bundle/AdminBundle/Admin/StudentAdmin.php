<?php
namespace Application\Bundle\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class StudentAdmin extends Admin
{
    private $container;
    protected $baseRoutePattern = 'student';
    protected $baseRouteName = 'sonata_student';
    
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
                    'label' => 'student.sonata.form.names.label',
                    'required' => true,
                ]
            )
            ->add(
                'lastname',
                'text',
                [
                    'label' => 'student.sonata.form.lastname.label',
                    'required' => true,
                ]
            )
            ->add(
                'voted',
                null,
                [
                    'label' => 'student.sonata.form.voted.label',
                    'required' => false,
                ]
            )
            ->add(
                'isPersonero',
                null,
                [
                    'label' => 'student.sonata.form.is_personero.label',
                    'required' => false,
                ]
            )
            ->add(
                'isCandidate',
                null,
                [
                    'label' => 'student.sonata.form.is_candidate.label',
                    'required' => false,
                ]
            )
            ->add(
                'code',
                "text",
                [
                    'label' => 'student.sonata.form.code.label',
                    'required' => true,
                ]
            )
            ->add(
                'file',
                'file',
                [
                    'label' => 'student.sonata.form.file.label',
                    'required' => false,
                ]
            )
            ->add(
                'grade',
                'sonata_type_model',
                [
                    'label' => 'student.sonata.form.grade.label',
                    'class' => 'AppBundle\Entity\Grade',
                    'property' => 'name',
                    //'minimum_input_length' => 2,
                    //'placeholder' => $this->trans('student.sonata.form.grade.placeholder'),
                    'required' => true,
                ]
            )
            ->add(
                'group',
                'sonata_type_model',
                [
                    'label' => 'student.sonata.form.group.label',
                    'class' => 'AppBundle\Entity\Group',
                    'property' => 'name',
                    //'minimum_input_length' => 2,
                    //'placeholder' => $this->trans('student.sonata.form.group.placeholder'),
                    'required' => true,
                ]
            )
            ->add(
                'time',
                'sonata_type_model',
                [
                    'label' => 'student.sonata.form.time.label',
                    'class' => 'AppBundle\Entity\Time',
                    'property' => 'name',
                    //'minimum_input_length' => 2,
                    //'placeholder' => $this->trans('student.sonata.form.time.placeholder'),
                    'required' => true,
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
                    'label' => 'student.sonata.filter.voted.label',
                ]
            )
            ->add(
                'grade',
                null,
                [
                    'label' => 'student.sonata.filter.grade.label',
                ]
            )
            ->add(
                'group',
                null,
                [
                    'label' => 'student.sonata.filter.group.label',
                ]
            )
            ->add(
                'time',
                null,
                [
                    'label' => 'student.sonata.filter.time.label',
                ]
            )
            ->add(
                'isPersonero',
                null,
                [
                    'label' => 'student.sonata.filter.is_personero.label',
                ]
            )
            ->add(
                'isCandidate',
                null,
                [
                    'label' => 'student.sonata.filter.is_candidate.label',
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
                'names',
                null,
                [
                    'label' => 'student.sonata.list.name.label',
                ]
            )
            ->add(
                'lastname',
                null,
                [
                    'label' => 'student.sonata.list.lastname.label',
                ]
            )
            ->add(
                'voted',
                null,
                [
                    'label' => 'student.sonata.list.voted.label',
                ]
            )
            ->add(
                'voteCounting',
                null,
                [
                    'label' => 'student.sonata.list.vote_counting.label',
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
