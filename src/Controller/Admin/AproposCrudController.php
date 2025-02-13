<?php

namespace App\Controller\Admin;

use App\Entity\Apropos;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\Validator\Constraints\Image;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AproposCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Apropos::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Infos générales de la page'),
            // IdField::new('id'),
            TextField::new('title', 'Titre')
                ->setColumns(6),
            SlugField::new('slug', 'Slug')
                ->setTargetFieldName('title')
                ->hideOnIndex(),
            TextField::new('mainTitle', 'Titre principal')
                ->setColumns(12)
                ->hideOnIndex(),
            TextField::new('subtitle', 'Sous-titre')
                ->setColumns(12)
                ->hideOnIndex(),

            FormField::addTab('Texte principal'),
            TextEditorField::new('content', 'Texte de la page')
                ->setColumns(12)
                ->hideOnIndex()
                ->hideOnDetail(),
            TextareaField::new('content', 'Texte de la page')
                ->hideOnForm()
                ->hideOnIndex()
                ->setTemplatePath('admin/fields/text.html.twig'),

            FormField::addTab('Image de la page'),
            ImageField::new('image', 'Image')
                ->setColumns(6)
                ->setRequired(false)
                ->setUploadDir('public/uploads/img/pages')
                ->setBasePath('uploads/img/pages')
                ->setUploadedFileNamePattern('[name]-[uuid].[extension]')
                ->setFileConstraints(new Image(
                    maxWidth: 1920,
                    maxWidthMessage: 'L\'image est trop large. La largeur max est 1920 px.',
                    maxHeight: 1080,
                    maxHeightMessage: 'L\'image est trop grande. La hauteur max est 1080 px.',
                    maxSize: '500k',
                    maxSizeMessage: 'L\'image est trop volumineuse. Le poids max est 500 Ko.',
                    mimeTypes: ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'],
                    mimeTypesMessage: 'Seuls les formats jpeg, jpg, png, webp sont acceptés.'
                )),
            TextField::new('imageAlt', 'Alt de l\'image')
            ->setColumns(6),

            FormField::addTab('SEO'),
            TextField::new('seoTitle','Balise SEO Titre')
                ->setColumns(12)
                ->hideOnIndex(),
            TextareaField::new('seoDescription','Balise SEO Description')
                ->setColumns(12)
                ->hideOnIndex(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Page A propos')
            ->setPageTitle('edit', 'Modifier la page A propos')
            ->setPageTitle('detail', 'Page A propos')
            ->showEntityActionsInlined(true);
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
