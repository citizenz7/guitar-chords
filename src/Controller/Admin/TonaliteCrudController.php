<?php

namespace App\Controller\Admin;

use App\Entity\Tonalite;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TonaliteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tonalite::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('title', 'Tonalité')
                ->setColumns(3),
            SlugField::new('slug')
                ->setTargetFieldName('title')
                ->setColumns(3),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste des Tonalités')
            ->setPageTitle('edit', 'Modifier une tonalité')
            ->setPageTitle('new', 'Ajouter une tonalité')
            ->setPageTitle('detail', 'Voir une tonalité')
            ->setDefaultSort(['id' => 'DESC'])
            ->setEntityLabelInPlural('Tonalités')
            ->setEntityLabelInSingular('Tonalité')
            ->showEntityActionsInlined(true)
            ->setPaginatorPageSize(10);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action){
                return $action->setIcon('fas fa-plus text-success')->setLabel('Ajouter une tonalité');
            })
            ->update(Crud::PAGE_INDEX, ACtion::DELETE, function(Action $action){
                return $action->setIcon('fas fa-trash text-danger')->setLabel('');
            })
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function(Action $action){
                return $action->setIcon('fas fa-eye text-info')->setLabel('');
            })
            // On DESACTIVE le bouton DELETE et le bouton NEW
            // ->disable(Action::DELETE, Action::NEW, Action::EDIT)
            ->update(Crud::PAGE_INDEX,Action::EDIT,function(Action $action){
                return $action->setIcon('fas fa-edit text-warning')->setLabel('');
            })
            ;
    }
}
