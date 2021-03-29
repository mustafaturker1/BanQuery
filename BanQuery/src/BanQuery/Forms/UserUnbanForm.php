<?php

namespace BanQuery\Forms;

use BanQuery\BanQuery;
use dktapps\pmforms\ModalForm;

class UserUnbanForm extends ModalForm{

    /** @var BanQuery */
    private $plugin;

    /**
     * UserUnbanForm constructor.
     * @param BanQuery $plugin
     */
    public function __construct(BanQuery $plugin){
        $this->plugin = $plugin;

        parent::__construct(
            "",
            "",

            function (): void{

            },
            "",
            ""
        );
    }
}
