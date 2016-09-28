<?php namespace Powerplanetonline\Ppofilemanager\controllers;

use Illuminate\Support\Facades\Event;
use Powerplanetonline\Ppofilemanager\controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Lang;
use Powerplanetonline\Ppofilemanager\Events\ImageWasRenamed;
use Powerplanetonline\Ppofilemanager\Events\FolderWasRenamed;

/**
 * Class RenameController
 * @package Powerplanetonline\Ppofilemanager\controllers
 */
class RenameController extends LfmController {

    /**
     * @return string
     */
    public function getRename()
    {
        $old_name = Input::get('file');
        $new_name = trim(Input::get('new_name'));

        $file_path  = parent::getPath('directory');
        $thumb_path = parent::getPath('thumb');

        $old_file = $file_path . $old_name;

        if (!File::isDirectory($old_file)) {
            $extension = File::extension($old_file);
            $new_name = str_replace('.' . $extension, '', $new_name) . '.' . $extension;
        }

        $new_file = $file_path . $new_name;

        if (Config::get('lfm.alphanumeric_directory') && preg_match('/[^\w-]/i', $new_name)) {
            return Lang::get('ppo-filemanager::lfm.error-folder-alnum');
        } elseif (File::exists($new_file)) {
            return Lang::get('ppo-filemanager::lfm.error-rename');
        }

        if (File::isDirectory($old_file)) {
            File::move($old_file, $new_file);
            Event::fire(new FolderWasRenamed($old_file, $new_file));
            return 'OK';
        }

        File::move($old_file, $new_file);

        if ('Images' === $this->file_type) {
            File::move($thumb_path . $old_name, $thumb_path . $new_name);
        }

        Event::fire(new ImageWasRenamed($old_file, $new_file));

        return 'OK';
    }
}
