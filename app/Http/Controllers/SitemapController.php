<?php

namespace App\Http\Controllers;

use App;
use App\News;
use App\Page;
use Illuminate\Http\Request;
use URL;

class SitemapController extends Controller
{
    /**
     * sitemap.xml
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sitemap = App::make('sitemap');

        $sitemap->setCache('laravel.sitemap', 60);

        if (!$sitemap->isCached()) {

            // Index page
            $sitemap->add(URL::to('/'));

            // Feedback page
            $sitemap->add(URL::to('feedback'));

            // Callback page
            $sitemap->add(URL::to('callback'));

            // Search page
            $sitemap->add(URL::to('search'));

            // Static pages
            $pages = Page::all();
            foreach ($pages as $value) {
                $sitemap->add(URL::to('page/' . $value->slug));
            }

            // News pages
            $sitemap->add(URL::to('news'));
            $news = News::all();
            foreach ($news as $value) {
                $sitemap->add(URL::to('news/' . $value->id));
            }
        }

        return $sitemap->render('xml');
    }
}
