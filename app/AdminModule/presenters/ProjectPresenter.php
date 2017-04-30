<?php

declare(strict_types=1);

namespace  App\AdminModule\Presenters;

use Nette;
use App\Model;
use App\Model\Facades\ProjectFacade;


class ProjectPresenter extends BasePresenter
{

	public function renderDefault()
    {
        $this->template->anyVariable = 'any value';
    }


}
