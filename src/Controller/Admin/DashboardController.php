<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();

        //  // redirect to some CRUD controller
        //  $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        //  return $this->redirect($routeBuilder->setController(OneOfYourCrudController::class)->generateUrl());
 
        //  // you can also redirect to different pages depending on the current user
        //  if ('jane' === $this->getUser()->getUsername()) {
        //      return $this->redirect('...');
        //  }
 
        //  // you can also render some template to display a proper Dashboard
        //  // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //  return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="assets/img/star.svg"> Administration de niveau 1')
            ->setFaviconPath('assets/img/star.svg')
            
            ;
            
    }

    public function configureMenuItems(): iterable
    {
        //créé un lien vers l'acceuil de l'admministration
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        //créé une nouvelle section dans le menu lateral
        yield MenuItem::section('Blog');
        // yield MenuItem::section()

        //créé un lien pour manager une entiéé (faire au préalable le crud de celle ci)
        yield MenuItem::linkToCrud('Articles', 'fa fa-file-text', Article::class);
        yield MenuItem::linkToCrud('Categories', 'fa fa-file-text', Category::class);
        yield MenuItem::linkToCrud('Comentaires', 'fa fa-file-message', Comment::class);
        // yield MenuItem::linkToCrud('media', 'fa fa-file-file', Category::class);
        
        //crééé dans le menu lateral un lien vers n'importe quel route de Symfony
        // yield MenuItem::linkToRoute('The Label', 'fa ...', 'home');
        // yield MenuItem::linkToRoute('The Label', 'fa ...', 'route_name', [ ... route parameters ... ]),
       
        // créé un lien vers n'importe quielle URL
        // yield MenuItem::linkToUrl('Search in Google', 'fab fa-google', 'https://google.com');
        
        
        //créé un lien vers la déconnection
        //yield MenuItem::linkToLogout('Logout', 'fa fa-exit')

        // créé  des sous-menu   mais ca marche pas trop....
        // yield MenuItem::subMenu('Blog', 'fa fa-article')->setSubItems([
        //     yield MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class),
        //     yield MenuItem::linkToCrud('Posts', 'fa fa-file-text', Article::class),
        // ]);
        yield MenuItem::section('Users');
        yield MenuItem::linkToCrud('Users', 'fa fa-users', User::class);
    }




    // public function configureUserMenu(UserInterface $user): UserMenu
    // {
    //     // Usually it's better to call the parent method because that gives you a
    //     // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
    //     // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
    //     return parent::configureUserMenu($user)
    //         // use the given $user object to get the user name
    //         ->setName($user->getFullName())
    //         // use this method if you don't want to display the name of the user
    //         ->displayUserName(true)

    //         // you can return an URL with the avatar image
    //         ->setAvatarUrl('https://...')
    //         // ->setAvatarUrl($user->getProfileImageUrl())
    //         // use this method if you don't want to display the user image
    //         ->displayUserAvatar(true)
    //         // you can also pass an email address to use gravatar's service
    //         ->setGravatarEmail($user->getUsername() )

    //         // you can use any type of menu item, except submenus
    //         ->addMenuItems([
    //             MenuItem::linkToRoute('My Profile', 'fa fa-id-card', '...', ['...' => '...']),
    //             MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
    //             MenuItem::section(),
    //             MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
    //         ]);
    // }

}
