<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;


class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield  EmailField::new('Email');
        yield  TextField::new('pseudo');
        if($pageName == Crud::PAGE_EDIT || $pageName == crud::PAGE_INDEX ){
            yield ChoiceField::new('Roles')->setChoices(User::ROLES)->allowMultipleChoices()->renderAsBadges(true) ;
        }else{
            yield  ArrayField::new('Roles');
        }
   
    }

    public function configureActions(Actions $actions): Actions
    {

        return $actions
                ->add(Crud::PAGE_INDEX, Action::DETAIL)
                //pour suppormer une action
                ->remove(Crud::PAGE_INDEX, Action::NEW)
    ;
    }
    
}
