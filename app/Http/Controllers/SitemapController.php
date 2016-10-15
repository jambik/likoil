<?php

namespace App\Http\Controllers;

use App;
use App\Article;
use App\Category;
use App\Gallery;
use App\News;
use App\Page;
use App\Product;
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

            // Articles pages
            $sitemap->add(URL::to('articles'));
            $articles = Article::all();
            foreach ($articles as $value) {
                $sitemap->add(URL::to('articles/' . $value->slug));
            }

            // News pages
            $sitemap->add(URL::to('news'));
            $news = News::all();
            dd($news);
            foreach ($news as $value) {
                $sitemap->add(URL::to('news/' . $value->id));
            }

            // Galleries pages
            $sitemap->add(URL::to('galleries'));
            $galleries = Gallery::all();
            foreach ($galleries as $value) {
                $sitemap->add(URL::to('galleries/' . $value->slug));
            }

            // Catalog pages
            $sitemap->add(URL::to('catalog'));
            $categories = Category::all();
            foreach ($categories as $category) {
                $sitemap->add(URL::to('catalog/' . $category->slug));
            }

            // Products pages
            $products = Product::all();
            foreach ($products as $value) {
                $sitemap->add(URL::to('product/' . $value->slug));
            }
        }

        return $sitemap->render('xml');
    }
}
