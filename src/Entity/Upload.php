<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 02/03/20
 * Time: 21:54
 */

namespace App\Entity;


class Upload
{
    protected $file;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

}