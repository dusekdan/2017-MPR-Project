<?php

declare(strict_types=1);

namespace  App\AdminModule\Presenters;

use Nette;
use App\Model;
use App\Model\Facades\ProjectFacade;

class StatisticPresenter extends BasePresenter
{

    /** @var ProjectFacade */
    public $projectFacade;

    public function __construct(ProjectFacade $projectFacade)
    {
        $this->projectFacade = $projectFacade;
    }

    public function renderDefault()
    {
        if(isset($this->project)){
            $this->template->anyVariable = 'any value';
            $arrJSON = [];
            $project = $this->projectFacade->getProject($this->project);
            foreach ($project->phases as $phase){
                $phaseJSON= [];
                foreach($phase->risks as $risk){
                    $riskJSON = [];
                    array_push($riskJSON, $risk->id);
                    array_push($riskJSON, $risk->name);
                    array_push($riskJSON, $risk->probability);
                    array_push($riskJSON, $risk->money);
                    array_push($riskJSON, $risk->severity);
                    array_push($riskJSON, $risk->primaryCause);
                    array_push($riskJSON, $risk->result);
                    array_push($phaseJSON, $riskJSON);
                }
                array_push($arrJSON, $phaseJSON);
            }

            $this->template->JSONData = json_encode($arrJSON,JSON_UNESCAPED_UNICODE);
        }
    }

}
