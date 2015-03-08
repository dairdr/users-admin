<?php
namespace Application\Bundle\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TeacherAdmin extends Admin
{
    private $container;
    protected $baseRoutePattern = 'teacher';
    protected $baseRouteName = 'sonata_teacher';
    
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
                    'label' => 'teacher.sonata.form.names.label',
                    'required' => true,
                ]
            )
            ->add(
                'lastname',
                'text',
                [
                    'label' => 'teacher.sonata.form.lastname.label',
                    'required' => true,
                ]
            )
            ->add(
                'voted',
                null,
                [
                    'label' => 'teacher.sonata.form.voted.label',
                    'required' => false,
                ]
            )
            ->add(
                'isCandidate',
                null,
                [
                    'label' => 'teacher.sonata.form.is_candidate.label',
                    'required' => false,
                ]
            )
            ->add(
                'code',
                "text",
                [
                    'label' => 'teacher.sonata.form.code.label',
                    'required' => true,
                ]
            )
            ->add(
                'file',
                'file',
                [
                    'label' => 'teacher.sonata.form.file.label',
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
                'voted',
                null,
                [
                    'label' => 'teacher.sonata.filter.voted.label',
                ]
            )
            ->add(
                'isCandidate',
                null,
                [
                    'label' => 'teacher.sonata.filter.is_candidate.label',
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
                    'label' => 'teacher.sonata.list.names.label',
                ]
            )
            ->add(
                'lastname',
                null,
                [
                    'label' => 'teacher.sonata.list.lastname.label',
                ]
            )
            ->add(
                'voted',
                null,
                [
                    'label' => 'teacher.sonata.list.voted.label',
                ]
            )
            ->add(
                'voteCounting',
                null,
                [
                    'label' => 'teacher.sonata.list.vote_counting.label',
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
