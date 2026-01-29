<?php
/**
 * Home Controller
 * Main landing page
 */

namespace App\Controllers;

use App\Models\SanityNewsModel;

class Home extends BaseController
{
    public function index(): void
    {
        $newsModel = new SanityNewsModel();
        
        $this->view('home/index', [
            'news' => $newsModel->getLatest(),
            'pageTitle' => 'Monster Adventure - Choose Your Adventure',
            // No longer passing $user since we removed authentication
        ]);
    }
}
