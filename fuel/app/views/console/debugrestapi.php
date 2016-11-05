<?php if (Auth::has_access('access.level3')) { ?>
<div class="row">

	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				aip/ping.json
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<?php 
							echo Form::open(array('role' => 'form', 'action' => 'api/ping.json'));
							echo '<div class="form-group">';
							echo Form::label('端末番号');
							echo Form::input('termid', '1', array('class' => 'form-control'));
							echo '</div>';

							echo Form::submit('submit', "送信", array('class' => 'btn btn-primary'));
							echo Form::close();
						?>
					</div><!-- /.col-lg-12 (nested) -->
				</div><!-- /.row (nested) -->
			</div><!-- /.panel-body -->
		</div><!-- /.panel -->
	</div><!-- /.col-lg-6 -->
    
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				aip/echo.json
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<?php 
							echo Form::open(array('role' => 'form', 'action' => 'api/echo.json'));
							echo '<div class="form-group">';
							echo Form::label('メッセージ');
							echo Form::input('message', 'recovery', array('class' => 'form-control'));
							echo '</div>';

							echo Form::submit('submit', "送信", array('class' => 'btn btn-primary'));
							echo Form::close();
						?>
					</div><!-- /.col-lg-12 (nested) -->
				</div><!-- /.row (nested) -->
			</div><!-- /.panel-body -->
		</div><!-- /.panel -->
	</div><!-- /.col-lg-6 -->
</div><!-- /.row -->
<?php } ?>
