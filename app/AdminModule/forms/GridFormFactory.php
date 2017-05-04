<?php
/**
 * Created by PhpStorm for spravaRizik.
 * User: Karel Píč
 * Date: 03.05.2017
 * Time: 21:18
 */

namespace App\AdminModule\Forms;

use Doctrine\Common\Collections\ArrayCollection;
use Ublaboo\DataGrid\DataGrid;
use Nette;
use App\Model\Entities\Phase;
use App\Model\Facades\RiskFacade;
use App\Model\Facades\PhaseFacade;
use Tracy\Debugger;

class GridFormFactory
{
	/** @var RiskFacade */
	private $riskFacade;

	/** @var  PhaseFacade */
	private $phaseFacade;


	public function __construct(RiskFacade $riskFacade, PhaseFacade $phaseFacade)
	{
		$this->riskFacade = $riskFacade;
		$this->phaseFacade = $phaseFacade;
	}

	public function phasesProjectGrid($phaseId, $presenter, $parent)
	{
		/**
		 * @var DataGrid
		 */
		$phase = $this->phaseFacade->getPhase($phaseId);
		$grid = new DataGrid($parent, $phaseId);
		$grid->setDataSource($phase->getRisks());
		$grid->addColumnText('name', 'Jméno', 'name')
			->setSortable()
			->setFilterText();
		$grid->addColumnNumber('money', 'Cena', 'money')
			->setSortable()
			->setFilterText();
		$grid->addColumnDateTime('startDate', 'Začátek', 'startDate')
			->setSortable();
		$grid->addColumnDateTime('endDate', 'Konec', 'endDate')
			->setSortable();


		$grid->addAction('View', '')->setRenderer(
			function ($risk) use ($presenter) {
				return Nette\Utils\Html::el('a')->addAttributes(['class'=>'ajax'])->href($presenter->link("viewRisk", $risk->id ))->setHtml('<i class="glyphicon glyphicon-eye-open"></i>') ;
			}
		);

		$grid->addAction('Edit', '')->setRenderer(
			function ($risk) use ($presenter) {
				return Nette\Utils\Html::el('a')->addAttributes(['class'=>'ajax'])->href($presenter->link("editRisk", $risk->id ))->setHtml('<i class="glyphicon glyphicon-pencil"></i>') ;
			}
		);

		$grid->addAction('Remove', '')->setRenderer(
			function ($risk) use ($presenter) {
				return Nette\Utils\Html::el('a')->addAttributes(['class'=>'ajax'])->href($presenter->link("removeRisk", $risk->id ))->setHtml('<i class="glyphicon glyphicon-trash"></i>') ;
			}
		);

		$grid->addColumnStatus('enabled', 'Status')
			->setSortable()
			->addOption(1, 'Platné')
			->setClass('btn-success')
			->endOption()
			->addOption(0, 'Neplatné')
			->setClass('btn-danger')
			->endOption()
			->onChange[] = function ($riskId ,$value) use ($grid, $presenter) {
				$this->riskFacade->setEnabled($riskId, $value, true);
				if ($presenter->isAjax()) {
					$grid->redrawItem($riskId);
				}
			};

		return $grid;
	}

	public function risksProjectsGrid($name, $presenter)
	{
		/**
		 * @var DataGrid
		 */
		$risks = New ArrayCollection($this->riskFacade->getRisks());
		$grid = new DataGrid($presenter, $name);
		$grid->setColumnsHideable();
		$grid->setDataSource($risks);
		$grid->addColumnText('project', 'Projekt', 'phase.project.name')
			->setSortable()
			->setFilterText();
		$grid->addColumnText('name', 'Jméno', 'name')
			->setSortable()
			->setFilterText();
		$grid->addColumnNumber('money', 'Cena', 'money')
			->setSortable()
			->setFilterText();
		$grid->addColumnDateTime('startDate', 'Začátek', 'startDate')
			->setSortable();
		$grid->addColumnDateTime('endDate', 'Konec', 'endDate')
			->setSortable();


		$grid->addAction('View', '')->setRenderer(
			function ($risk) use ($presenter) {
				return Nette\Utils\Html::el('a')->addAttributes(['class'=>'ajax'])->href($presenter->link("viewRisk", $risk->id ))->setHtml('<i class="glyphicon glyphicon-eye-open"></i>') ;
			}
		);

		$grid->addAction('Edit', '')->setRenderer(
			function ($risk) use ($presenter) {
				return Nette\Utils\Html::el('a')->addAttributes(['class'=>'ajax'])->href($presenter->link("editRisk", $risk->id ))->setHtml('<i class="glyphicon glyphicon-pencil"></i>') ;
			}
		);

		$grid->addAction('Remove', '')->setRenderer(
			function ($risk) use ($presenter) {
				return Nette\Utils\Html::el('a')->addAttributes(['class'=>'ajax'])->href($presenter->link("removeRisk", $risk->id ))->setHtml('<i class="glyphicon glyphicon-trash"></i>') ;
			}
		);

		$grid->addColumnStatus('enabled', 'Status')
			->setSortable()
			->addOption(1, 'Platné')
			->setClass('btn-success')
			->endOption()
			->addOption(0, 'Neplatné')
			->setClass('btn-danger')
			->endOption()
			->onChange[] = function ($riskId ,$value) use ($grid, $presenter) {
			$this->riskFacade->setEnabled($riskId, $value, true);
			debugger::fireLog($riskId);
			if ($presenter->isAjax()) {
				$grid->redrawControl();
			}
		};

		return $grid;
	}
}