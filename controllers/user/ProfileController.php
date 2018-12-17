<?php
namespace app\controllers\user;

use app\support\helpers\LoggedInUserTrait;
use dektrium\user\controllers\ProfileController as BaseProfileController;

class ProfileController extends BaseProfileController
{
    use LoggedInUserTrait;
}