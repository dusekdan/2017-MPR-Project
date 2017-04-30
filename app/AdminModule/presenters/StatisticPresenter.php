<?php

declare(strict_types=1);

namespace  App\AdminModule\Presenters;

use Nette;
use App\Model;


class StatisticPresenter extends Nette\Application\UI\Presenter
{

    public function renderDefault()
    {
        $this->template->anyVariable = 'any value';
    }

}
