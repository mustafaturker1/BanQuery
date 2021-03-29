<?php

namespace BanQuery\Forms;

use BanQuery\BanQuery;
use BanQuery\Text\Text;
use dktapps\pmforms\CustomForm;
use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\Input;
use dktapps\pmforms\element\Label;
use pocketmine\Player;
use pocketmine\utils\TextFormat as C;

class UserUnbanSearchForm extends CustomForm{

    /** @var BanQuery */
    private $plugin;

    /**
     * UserUnbanSearchForm constructor.
     * @param BanQuery $plugin
     */
    public function __construct(BanQuery $plugin){
        $this->plugin = $plugin;

        parent::__construct(
            C::BOLD . C::DARK_GRAY . "Unban",

            [
                new Label("element0", "\n"),
                new Input("element1", "Search", "MustafaTurker1, ByAlperenS...")
            ],

            function (Player $player, CustomFormResponse $response): void{
                $search = $response->getString("element1");
                $mysql = $this->plugin->getMySQL();
                $text = new Text($this->plugin);
                $config = $this->plugin->getConfigData();

                if ($mysql->isBanned($search)){
                    $player->sendForm(new UserUnbanConfirmForm($this->plugin, $search));
                }else{
                    $player->sendMessage($text->convertCodeInTheText($config->get("User-Not-Found-Message"), $player, $search));
                }
            }
        );
    }
}
