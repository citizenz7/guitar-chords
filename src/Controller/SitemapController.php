<?php

namespace App\Controller;

use App\Repository\ChordRepository;
use App\Repository\SettingRepository;
use App\Repository\TonaliteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class SitemapController extends AbstractController
{
    #[Route('/sitemap.xml', name: 'app_sitemap', defaults: ['_format', 'xml'])]
    public function index(
        Request $request,
        SettingRepository $settingRepository,
        TonaliteRepository $tonaliteRepository,
        ChordRepository $chordRepository
    ): Response
    {
        $settings = $settingRepository->findOneBy([]);
        $tonalites = $tonaliteRepository->findAll();
        $chords = $chordRepository->findBy(['active' => true], []);

        $lastmodPage = date('Y-m-d');
        $hostname = $request->getSchemeAndHttpHost();

        // Initialisation du tableau des URL
        $urls = [];

        // Homepage
        $urls[] = [
            'loc' => $this->generateUrl('app_home'),
            'lastmod' => $lastmodPage,
            'changefreq' => 'weekly',
            'priority' => '0.5',
        ];

        // Contact
        $urls[] = [
            'loc' => $this->generateUrl('app_contact'),
            'lastmod' => $lastmodPage,
            'changefreq' => 'weekly',
            'priority' => '0.5',
        ];

        // A propos
        $urls[] = [
            'loc' => $this->generateUrl('app_apropos'),
            'lastmod' => $lastmodPage,
            'changefreq' => 'weekly',
            'priority' => '0.5',
        ];

        // Recherche
        $urls[] = [
            'loc' => $this->generateUrl('app_search'),
            'lastmod' => $lastmodPage,
            'changefreq' => 'weekly',
            'priority' => '0.5',
        ];

        // CGU
        $urls[] = [
            'loc' => $this->generateUrl('app_cgu'),
            'lastmod' => $lastmodPage,
            'changefreq' => 'weekly',
            'priority' => '0.5',
        ];

        // Tonalites
        $urls[] = [
            'loc' => $this->generateUrl('app_tonalite_index'),
            'lastmod' => $lastmodPage,
            'changefreq' => 'weekly',
            'priority' => '0.5',
        ];

        // Boucle sur les tonalités
        foreach($tonalites as $tonalite) {
            $urls[] = [
                'loc' => $this->generateUrl('app_tonalite_show', ['slug' => $tonalite->getSlug()]),
                'lastmod' => $lastmodPage,
                'changefreq' => 'weekly',
                'priority' => '0.5',
            ];
        }

        // Boucle sur les accords
        foreach($chords as $chord) {
            $urls[] = [
                'loc' => $this->generateUrl('app_chord_show', ['slug' => $chord->getSlug()]),
                'lastmod' => $lastmodPage,
                'changefreq' => 'weekly',
                'priority' => '0.5',
            ];
        }

        // Create the XML response
        $response = new Response(
            $this->renderView('sitemap/index.html.twig', [
                'urls' => $urls,
                'hostname' => $hostname,
                'settings' => $settings,
                'tonalites' => $tonalites,
                'chords' => $chords
            ]),
            200
        );

        // Add headers
        $response->headers->set('Content-Type', 'application/xml');

        // Send the response
        return $response;
    }
}
