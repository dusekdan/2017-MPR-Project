<?php
/**
 * Created by PhpStorm for spravaRizik.
 * User: Karel Píč
 * Date: 03.05.2017
 * Time: 21:18
 */

namespace App\AdminModule\Forms;

use Ublaboo\DataGrid\DataGrid;
use Nette;
use App\Model\Entities\Phase;

class GridFormFactory
{
	public function phaseGrid(Phase $phase, $presenter)
	{
		/**
		 * @var DataGrid
		 */
		$grid = new DataGrid();
		$grid->setDataSource($phase->risks);
		//$grid->addColumnText('id', 'ID', 'id')
		//	->setSortable();
		$grid->addColumnText('name', 'Jméno', 'name')
			->setSortable()
			->setFilterText();
		$grid->addColumnText('description', 'Popis', 'description')
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
		return $grid;
	}
}