<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 2018-10-22
 * Time: 12:05
 */

namespace App\Models;


interface IRequest
{
    public function body();
    public function setPostVars( array $post);
    public function setGetVars( array  $get );
}
