<?php

namespace BanQuery\Forms;

use dktapps\pmforms\CustomForm;
use dktapps\pmforms\CustomFormResponse;
use pocketmine\Player;

class UserBanForm extends CustomForm
{
    public function __construct()
    {
        parent::__construct("Ban Form", [
        ], function (Player $player, CustomFormResponse $response): void
        {
            // TODO
        });
    }
}