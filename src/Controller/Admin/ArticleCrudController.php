<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Tag;
use App\Form\TagType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $article = new Article();
        $article->setUser($this->getUser());

        return $article;
    }

    public function configureFields(string $pageName): iterable
    {
          yield  IdField::new('id','id')->onlyOnIndex();
        //   yield  FormField::addPanel();
          yield  DateTimeField::new('updated_at', "date de dernière édition")->hideOnForm();
          yield  TextField::new('titre');
            if($pageName == crud::PAGE_NEW || $pageName == crud::PAGE_EDIT ){
              yield  ImageField::new('imageFile', 'image assocée');
            }else{
              yield  ImageField::new('featured_image', 'image assocée')->setBasePath('uploads/images/featured') ;

            }
           yield TextEditorField::new('content', "contenu")->setFormType(CKEditorType::class);
            // ChoiceField::new('categories', 'Categories')->setChoices(['foo' => 1, 'bar' => 2]),
    
            if($pageName == crud::PAGE_EDIT || $pageName== crud::PAGE_NEW){
                yield AssociationField::new('categories', "Categories")->setCrudController('CAtegoryCrudController');
            }else{
                yield ArrayField::new('Categories', "Categories");
            }


            if($pageName == crud::PAGE_EDIT || $pageName== crud::PAGE_NEW){
                yield CollectionField::new('tags', 'Mots clés')->allowAdd()
                                                                ->allowDelete()
                                                                ->setEntryType(TagType::class);
            }else{
                yield ArrayField::new('Tags', "Mots clés");
            }

            yield ArrayField::new('commentsqdc', 'Commentaires')->onlyOnIndex();
            // yield NumberField::new('reacts', 'reactions')->onlyOnIndex();
            

    }

    public function configureActions(Actions $actions): Actions
    {

        return $actions
                ->add(Crud::PAGE_INDEX, Action::DETAIL)
                //pour suppormer une action
                // ->remove(Crud::PAGE_INDEX, Action::NEW)
    ;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ...
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')

            ->showEntityActionsAsDropdown()
            // ->renderSidebarMinimized()
            // ->renderContentMaximized()
            // // use dots (e.g. 'seller.email') to search in Doctrine associations
            // ->setSearchFields(['name', 'description', 'seller.email', 'seller.phone'])
            ->setPaginatorPageSize(25)
            // ->setFormThemes(['article/new.html.twig', 'admin.html.twig'])
        ;
    }
}
