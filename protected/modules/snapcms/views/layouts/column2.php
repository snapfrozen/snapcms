<?php /* @var $this Controller */ 

?>
<?php $this->beginContent('/layouts/main'); ?>
<div class="row">
	<div id="content" class="col-md-9 clearfix">
		<?php echo $content; ?>
	</div><!-- content -->
	<div id="sidebar" class="col-md-3">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Operations',
				'titleCssClass' => 'panel-title',
				'decorationCssClass' => 'panel-heading',
				'htmlOptions'=>array('class'=>'panel panel-success')
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->operations,
				'htmlOptions'=>array('class'=>'nav nav-stacked'),
			));
			$this->endWidget();
		?>
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Menu',
				'titleCssClass' => 'panel-title',
				'decorationCssClass' => 'panel-heading',
				'htmlOptions'=>array('class'=>'panel panel-info')
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->getMenuArray(),
				'htmlOptions'=>array('class'=>'nav nav-stacked'),
			));
			$this->endWidget();
		?>
		<!--
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Useful Links</h3>
			</div>
			<div class="list-group">
				<a class="list-group-item" href="https://forums.uberent.com/threads/rel-pa-tournaments-54631.50777/"><strong>In Game Mod</strong></a>
				<a class="list-group-item" href="https://forums.uberent.com/categories/planetary-annihilation.60/">Planetary Annihilation Forums</a>
				<a class="list-group-item" href="https://store.uberent.com/Store/PreOrder?titleId=4">Buy Planetary Annihilation</a>
				<a class="list-group-item" href="http://www.petardia.com/">Petardia</a>
				<a class="list-group-item" href="http://pamatches.com/">PA Matches</a>
				<a class="list-group-item" href="http://www.nanodesu.info/pastats/">PA Stats</a>
				<a class="list-group-item" href="http://www.pa-db.com/">PA DB</a>
				<a class="list-group-item" href="http://www.snapfrozen.com.au/">Web Development Services</a>
			</div>
		</div>
		-->
		
	</div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>