<?php

declare(strict_types=1);

namespace  App\AdminModule\Presenters;

use Nette;
use App\Model;


class ProjectsPresenter extends Nette\Application\UI\Presenter
{

    public function renderProjects()
    {
        $this->template->anyVariable = 'any value';
    }

}
