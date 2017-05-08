<?php

declare(strict_types=1);

namespace  App\AdminModule\Presenters;

use Nette;
use App\Model;
use App\Model\Facades\ProjectFacade;
use Tracy\Debugger;

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
            $project = $this->projectFacade->getProject($this->project);
            $arrJSON = [];

            foreach ($project->phases as $phase) {
	            if (!$phase->getEnabled()) {
		            continue;
	            }
                $phaseJSON= [];
                foreach ($phase->risks as $risk) {
	                if (!$risk->getEnabled()) {
		                continue;
	                }
                    $riskJSON = [];
                    array_push($riskJSON, $risk->id);
                    array_push($riskJSON, $risk->name);
                    array_push($riskJSON, $risk->probability);
                    array_push($riskJSON, $risk->money);
                    array_push($riskJSON, $risk->severity);
                    array_push($riskJSON, $risk->primaryCause);
                    array_push($riskJSON, $risk->result);
	                array_push($riskJSON, $risk->reaction);

                    array_push($phaseJSON, $riskJSON);
                }
                array_push($arrJSON, $phaseJSON);
            }

            $this->template->allProjects = [];
            $this->template->JSONData = json_encode($arrJSON,JSON_UNESCAPED_UNICODE);
        } else {
	        $projects = $this->projectFacade->getProjects();
            $arrJSON = [];

            foreach ($projects as $project) {
	            if (!$project->getEnabled()) {
		            continue;
	            }
                foreach ($project->phases as $phase) {
	                if (!$phase->getEnabled()) {
		                continue;
	                }
                    $phaseJSON= [];
                    foreach($phase->risks as $risk) {
	                    if (!$risk->getEnabled()) {
		                    continue;
	                    }
                        $riskJSON = [];
                        array_push($riskJSON, $risk->id);
                        array_push($riskJSON, $risk->name);
                        array_push($riskJSON, $risk->probability);
                        array_push($riskJSON, $risk->money);
                        array_push($riskJSON, $risk->severity);
                        array_push($riskJSON, $risk->primaryCause);
                        array_push($riskJSON, $risk->result);
	                    array_push($riskJSON, $risk->reaction);
                        array_push($phaseJSON, $riskJSON);
                    }
                    array_push($arrJSON, $phaseJSON);
                }
            }

	        //@TODO projet všechny projekty a pro všechny udělat to co máš vejš a hodit to do jedné tabulky
            $this->template->allProjects = $projects;
	        $this->template->JSONData = json_encode($arrJSON, JSON_UNESCAPED_UNICODE);
        }
    }

}
