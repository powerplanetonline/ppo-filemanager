<?php namespace Powerplanetonline\Ppofilemanager\controllers;

use Powerplanetonline\Ppofilemanager\controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

/**
 * Class DownloadController
 * @package Powerplanetonline\Ppofilemanager\controllers
 */
class DownloadController extends LfmController {

    /**
     * Download a file
     *
     * @return mixed
     */
    public function getDownload()
    {
        return Response::download(parent::getPath('directory') . Input::get('file'));
    }

}
