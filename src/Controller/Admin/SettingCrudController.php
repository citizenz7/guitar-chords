<?php

namespace App\Controller\Admin;

use App\Entity\Setting;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\Validator\Constraints\Image;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SettingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Setting::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Général')
                ->setIcon('fas fa-info')
                ->setHelp('Informations générales'),
            TextField::new('siteName', 'Titre du site')
                ->setColumns(12),
            ImageField::new('siteLogo', 'Logo du site')
                ->setColumns(6)
                ->setRequired(false)
                ->setUploadDir('public/uploads/img')
                ->setBasePath('uploads/img')
                ->setUploadedFileNamePattern('[name]-[uuid].[extension]')
                ->setFileConstraints(new Image(
                    maxWidth: 800,
                    maxWidthMessage: 'L\'image est trop large. La largeur max est 800 px.',
                    maxHeight: 600,
                    maxHeightMessage: 'L\'image est trop grande. La hauteur max est 600 px.',
                    maxSize: '50k',
                    maxSizeMessage: 'L\'image est trop volumineuse. Le poids max est 50 Ko.',
                    mimeTypes: ['image/png'],
                    mimeTypesMessage: 'Seul le format png transparent est accepté.'
                )),

            FormField::addTab('Description')
                ->setIcon('fas fa-file-medical-alt')
                ->setHelp('Description du site'),
            TextareaField::new('siteDescription', 'Description du site')
                ->setColumns(12),

            FormField::addTab('Url')
                ->setIcon('fas fa-link')
                ->setHelp('Adresses du site'),
            TextField::new('siteUrl', 'Url courte du site')
                ->setColumns(6),
            TextField::new('siteUrlfull', 'Url complète du site')
                ->setColumns(6),

            FormField::addTab('Coordonnées')
                ->setIcon('fas fa-map-marker-alt')
                ->setHelp('Email, adresse, téléphone'),
            EmailField::new('siteEmail', 'E-mail du site')
                ->setColumns(3),
            TextField::new('siteAddress', 'Adresse postale')
                ->setColumns(4)
                ->hideOnIndex(),
            TextField::new('siteCp', 'Code Postal')
                ->setColumns(1)
                ->hideOnIndex(),
            TextField::new('siteCity', 'Ville')
                ->setColumns(2)
                ->hideOnIndex(),
            TextField::new('siteTelephone', 'Téléphone')
                ->setColumns(2)
                ->hideOnIndex(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Paramètres du site')
            ->setPageTitle('detail', 'Paramètres du site')
            ->showEntityActionsInlined(true)
            ->setPageTitle('edit', 'Modifier les paramètres')
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function(Action $action){
                return $action->setIcon('fas fa-eye text-info')->setLabel('');
            })
            // On DESACTIVE le bouton DELETE et le bouton NEW
            ->disable(Action::DELETE, Action::NEW)
            ->update(Crud::PAGE_INDEX,Action::EDIT,function(Action $action){
                return $action->setIcon('fas fa-edit text-warning')->setLabel('');
            });
    }
}
