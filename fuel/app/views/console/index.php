<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php echo $target_date . ' の履歴（最大 ' . $show_limit . ' 件表示)' ?>
			</div><!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>端末名</th>
								<th>登録日時</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if ($ping_item_list != null)
							{
								foreach ($ping_item_list as $item)
								{
									echo '<tr>';
									echo '<td>'.$item->id.'</td>';
									echo '<td>'.$item->termid.'</td>';
									echo '<td>'.$item->created_at.'</td>';
									echo '</tr>';
								}
							}
							else
							{
								echo '<tr>';
								echo '<td colspan="3">データなし</td>';
								echo '</tr>';
							}
							?>
						</tbody>
					</table>
				</div><!-- /.table-responsive -->
			</div><!-- /.panel-body -->
		</div><!-- /.panel -->
	</div><!-- /.col-lg-12 -->

	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				表示オプション
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<?php                           
							echo Form::open(array('role' => 'form'));
							echo '<div class="form-group">';
							echo Form::label('履歴表示日付（YYYY/MM/DD）');
							echo Form::input('target_date', $target_date, array('type' => 'date', 'class' => 'form-control'));
							echo '</div>';

							echo '<div class="form-group">';
							echo Form::label('最大表示個数');
							echo Form::select('show_limit', $show_limit, array(
								25 => '25',
								50 => '50',
								100 => '100',
								500 => '500',
							), array('class' => 'form-control'));
							echo '</div>';

							echo Form::submit('submit', "更新", array('class' => 'btn btn-default'));
							echo Form::close();
						?>
					</div><!-- /.col-lg-12 (nested) -->
				</div><!-- /.row (nested) -->
			</div><!-- /.panel-body -->
		</div><!-- /.panel -->
	</div><!-- /.col-lg-6 -->
</div><!-- /.row -->
