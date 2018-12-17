<?php
namespace app\controllers\user;

use app\support\helpers\LoggedInUserTrait;
use dektrium\user\controllers\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
    use LoggedInUserTrait;
}