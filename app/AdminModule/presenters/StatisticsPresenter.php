<?php

declare(strict_types=1);

namespace  App\AdminModule\Presenters;

use Nette;
use App\Model;


class StatisticsPresenter extends Nette\Application\UI\Presenter
{

    public function renderStatistics()
    {
        $this->template->anyVariable = 'any value';
    }

}
