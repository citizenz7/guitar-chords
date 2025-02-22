<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\Validator\Constraints\Image;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            BooleanField::new('isActive', 'Publié')
                ->setColumns(12),
            TextField::new('title', 'Titre')
                ->setColumns(5),
            SlugField::new('slug', 'Slug')
                ->setTargetFieldName('title')
                ->hideOnIndex()
                ->setColumns(5),
            AssociationField::new('tonalite', 'Tonalité')
                ->setColumns(2),
            TextEditorField::new('intro', 'Introduction')
                ->setColumns(12)
                ->hideOnIndex()
                ->hideOnDetail(),
            TextareaField::new('intro', 'Introduction')
                ->hideOnForm()
                ->hideOnIndex()
                ->setTemplatePath('admin/fields/text.html.twig'),
            TextEditorField::new('content', 'Contenu')
                ->setColumns(12)
                ->hideOnIndex()
                ->hideOnDetail(),
            TextareaField::new('content', 'Contenu')
                ->hideOnForm()
                ->hideOnIndex()
                ->setTemplatePath('admin/fields/text.html.twig'),
            ImageField::new('mainImage', 'Image de couverture')
                ->setColumns(6)
                ->setRequired(false)
                ->setUploadDir('public/uploads/img/articles')
                ->setBasePath('uploads/img/articles')
                ->setUploadedFileNamePattern('[name]-[uuid].[extension]')
                ->setFileConstraints(new Image(
                    maxWidth: 1920,
                    maxWidthMessage: 'L\'image est trop large. La largeur max est 1920 px.',
                    maxHeight: 1080,
                    maxHeightMessage: 'L\'image est trop grande. La hauteur max est 1080 px.',
                    maxSize: '500k',
                    maxSizeMessage: 'L\'image est trop volumineuse. Le poids max est 500 Ko.',
                    mimeTypes: ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'],
                    mimeTypesMessage: 'Seul les formats jpeg, jpg, webp et png sont acceptés.'
                )),
            DateField::new('createdAt', 'Posté le')
                ->hideOnForm(),
            AssociationField::new('author', 'Auteur')
                ->hideOnForm(),
            AssociationField::new('accords', 'Accords')
                ->setColumns(12),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste des articles')
            ->setPageTitle('edit', 'Modifier un article')
            ->setPageTitle('new', 'Ajouter un article')
            ->setPageTitle('detail', 'Voir un article')
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
                return $action->setIcon('fas fa-newspaper pe-1')->setLabel('Ajouter un article');
            })
            ->update(Crud::PAGE_INDEX,Action::EDIT,function(Action $action){
                return $action->setIcon('fas fa-edit text-success')->setLabel('')->addCssClass('text-dark');
            })
            ->update(Crud::PAGE_INDEX,Action::DELETE,function(Action $action){
                return $action->setIcon('fas fa-trash text-danger')->setLabel('')->addCssClass('text-dark');
            });
    }
}
