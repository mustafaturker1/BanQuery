<?php

namespace BanQuery\Text;

use BanQuery\BanQuery;

class Text{

    /** @var BanQuery */
    private $plugin;

    /**
     * @var string[]
     */
    private $codes = [
        "{user}",
        "&",
        "{line}",
        "{admin}",
        "{reason}",
        "{prefix}"
    ];

    /** @var string */
    private $prefix = "&";

    public function __construct(BanQuery $plugin){
        $this->plugin = $plugin;
    }

    /**
     * @param string $text
     * @param string $admin
     * @param string|null $reason
     * @param string|null $player
     * @return string
     */
    public function convertCodeInTheText(string $text, string $admin, string $reason = null, string $player = null): string{
        $config = $this->plugin->getConfigData();
        $prefix = str_replace($this->prefix, "§", $config->get("Prefix"));
        return str_replace($this->codes, [$player, "§", "\n", $admin, $reason, $prefix], $text);
    }
}
