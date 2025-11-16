<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @author Xanders
 * @see https://team.xsamtech.com/xanderssamoth
 */
class HomeController extends Controller
{
    // ==================================== HTTP GET METHODS ====================================
    /**
     * GET: Home page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * GET: Change language
     *
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeLanguage($locale)
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }

    /**
     * GET: About page
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('about');
    }

    /**
     * GET: About entity page
     *
     * @return \Illuminate\View\View
     */
    public function aboutEntity($entity)
    {
        return view('about');
    }

    /**
     * GET: Notifications page
     *
     * @return \Illuminate\View\View
     */
    public function notification()
    {
        return view('notification');
    }

    // ==================================== HTTP POST METHODS ====================================
    //
}
