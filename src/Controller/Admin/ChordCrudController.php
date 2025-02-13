<?php

namespace App\Controller\Admin;

use App\Entity\Chord;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\Validator\Constraints\Image;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ChordCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chord::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnIndex(),
            BooleanField::new('is_active', 'Publié')
                ->setColumns(12),
            TextField::new('title', 'Nom')
                ->setColumns(4),
            SlugField::new('slug')
                ->setTargetFieldName('title')
                ->setColumns(4),
            AssociationField::new('tonalite', 'Tonalité')
                ->setColumns(4),
            ImageField::new('image', 'Image')
                ->setColumns(6)
                ->setHelp('Image de l\'accord. Vous pouvez générer des images d\'accord sur cette page : https://chordgenerator.net')
                ->setRequired(false)
                ->setUploadDir('public/uploads/img/chords')
                ->setBasePath('uploads/img/chords')
                ->setUploadedFileNamePattern('[name]-[uuid].[extension]')
                ->setFileConstraints(new Image(
                    maxWidth: 800,
                    maxWidthMessage: 'L\'image est trop large. La largeur max est 800 px.',
                    maxHeight: 600,
                    maxHeightMessage: 'L\'image est trop grande. La hauteur max est 600 px.',
                    maxSize: '300k',
                    maxSizeMessage: 'L\'image est trop volumineuse. Le poids max est 300 Ko.',
                    mimeTypes: ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'],
                    mimeTypesMessage: 'Seuls les formats jpeg, jpg, png, webp sont acceptés.'
                )),
            TextEditorField::new('content', 'Contenu')
                ->setColumns(12)
                ->hideOnIndex()
                ->hideOnDetail(),
            TextareaField::new('content', 'Contenu')
                ->hideOnForm()
                ->hideOnIndex()
                ->setTemplatePath('admin/fields/text.html.twig'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste des accords')
            ->setPageTitle('edit', 'Modifier un accord')
            ->setPageTitle('new', 'Ajouter un accord')
            ->setPageTitle('detail', 'Voir un accord')
            ->setDefaultSort(['id' => 'DESC'])
            ->setEntityLabelInPlural('Accords')
            ->setEntityLabelInSingular('Accord')
            ->showEntityActionsInlined(true)
            ->setPaginatorPageSize(10);
    }

    public function configureActions(Actions $actions): Actions{
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function(Action $action){
                return $action->setIcon('fas fa-eye text-info')->setLabel('')->addCssClass('text-dark');
            })
            ->update(Crud::PAGE_INDEX,Action::NEW,function(Action $action){
                return $action->setIcon('fas fa-newspaper pe-1')->setLabel('Ajouter un accord');
            })
            ->update(Crud::PAGE_INDEX,Action::EDIT,function(Action $action){
                return $action->setIcon('fas fa-edit text-success')->setLabel('')->addCssClass('text-dark');
            })
            ->update(Crud::PAGE_INDEX,Action::DELETE,function(Action $action){
                return $action->setIcon('fas fa-trash text-danger')->setLabel('')->addCssClass('text-dark');
            });
    }
}
