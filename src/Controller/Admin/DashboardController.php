<?php

namespace App\Controller\Admin;

use App\Entity\Cgu;
use App\Entity\Home;
use App\Entity\User;
use App\Entity\Chord;
use App\Entity\Search;
use App\Entity\Apropos;
use App\Entity\Article;
use App\Entity\Contact;
use App\Entity\Setting;
use App\Entity\Tonalite;
use App\Entity\ChordPage;
use App\Entity\TonalitePage;
use App\Repository\SettingRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

// #[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private SettingRepository $settingRepository,
    )
    {}

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<div style="width: 90%; text-align: center; margin: 0 auto; padding: 2px 5px 4px 5px; border-radius: 4px; background-color: #ffffff79;"><h1 style="font-size: clamp(18px, 1.5vw, 24px); font-weight: 800; color: #fff; text-align: center; margin: 0;"> ' . $this->settingRepository->find(1)->getSiteName() . '</h1></div>')
            ->renderContentMaximized();
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        if (!$user instanceof User) {
            throw new \Exception('Mauvais utilisateur.');
        }

        $image = '../../../uploads/img/users/' . $user->getImage();

        return parent::configureUserMenu($user)
            ->setAvatarUrl($image);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Visiter le site', 'fas fa-home', $this->generateUrl('app_home'));
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-cog');

        // -------------------------------------
        // PAGES
        // -------------------------------------
        yield MenuItem::section('Pages')->setCssClass('text-warning fw-bold shadow');
        yield MenuItem::linkToCrud('Accueil', 'fas fa-home', Home::class)->setAction('detail')->setEntityId(1);
        yield MenuItem::linkToCrud('Accords', 'fa-solid fa-guitar', ChordPage::class)->setAction('detail')->setEntityId(1);
        yield MenuItem::linkToCrud('A propos', 'fas fa-info', Apropos::class)->setAction('detail')->setEntityId(1);
        yield MenuItem::linkToCrud('Contact', 'fas fa-envelope', Contact::class)->setAction('detail')->setEntityId(1);
        yield MenuItem::linkToCrud('CGU', 'fas fa-gavel', Cgu::class)->setAction('detail')->setEntityId(1);
        yield MenuItem::linkToCrud('Recherche', 'fas fa-search', Search::class)->setAction('detail')->setEntityId(1);
        yield MenuItem::linkToCrud('Tonalités', 'fas fa-music', TonalitePage::class)->setAction('detail')->setEntityId(1);

        // -------------------------------------
        // ACCORDS
        // -------------------------------------
        yield MenuItem::section('Accords')->setCssClass('text-warning fw-bold shadow');
        yield MenuItem::linkToCrud('Accords', 'fa-solid fa-guitar', Chord::class);
        yield MenuItem::linkToCrud('Tonalités', 'fas fa-music', Tonalite::class);

        // -------------------------------------
        // BLOG
        // -------------------------------------
        yield MenuItem::section('Blog')->setCssClass('text-warning fw-bold shadow');
        yield MenuItem::linkToCrud('Articles', 'fas fa-newspaper', Article::class);

        // -------------------------------------
        // USERS
        // -------------------------------------
        yield MenuItem::section('Utilisateurs')->setCssClass('text-warning fw-bold shadow');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);

        // -------------------------------------
        // PARAMETRES
        // -------------------------------------
        yield MenuItem::section('Paramètres')->setCssClass('text-warning fw-bold shadow');
        yield MenuItem::linkToCrud('Configuration du site', 'fa fa-cogs', Setting::class);
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addAssetMapperEntry('admin');
    }
}
