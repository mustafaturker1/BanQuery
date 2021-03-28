<?php

namespace BanQuery\Forms;

use dktapps\pmforms\MenuForm;
use dktapps\pmforms\MenuOption;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class BanOptionForm extends MenuForm
{
    public function __construct()
    {
        parent::__construct("Ban Option Form", "\n", [
            new MenuOption(TextFormat::WHITE."Ban"),
            new MenuOption(TextFormat::WHITE."Unban"),
            new MenuOption(TextFormat::WHITE."All Unban")
        ], function (Player $player, ?int $response): void
        {
            switch (TextFormat::clean($this->getOption($response)->getText())) {
                case "Ban":
                    $player->sendForm(new UserBanForm());
                    break;
            }
        });
    }
}
