<?php if (Auth::has_access('access.level2')) { ?>
<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				全般設定
			</div><!-- /.panel-heading -->
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<?php 
							if (isset($success_message))
							{
								echo '<div class="alert alert-success">';
								echo $success_message;
								echo '</div>';   
							}
							if (isset($error_message))
							{
								echo '<div class="alert alert-danger">';
								echo $error_message;
								echo '</div>';   
							}

							echo Form::open(array('role' => 'form'));
							echo '<div class="form-group">';
							echo Form::label('サービス名称');
							echo Form::input('service_name', $service_name, array('class' => 'form-control', 'placeholder' => 'サービス名称'));
							echo '</div>';
							
							echo '<div class="form-group">';
							echo Form::label('サイトフッター');
							echo Form::input('footer_text', $footer_text, array('class' => 'form-control', 'placeholder' => 'コピーライト等'));
							echo '</div>';

							echo Form::submit('submit', "登録する", array('class' => 'btn btn-primary'));
							echo Form::close();
						?>
					</div><!-- /.col-lg-12 (nested) -->
				</div><!-- /.row (nested) -->
			</div><!-- /.panel-body -->
		</div><!-- /.panel -->
	</div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<?php } ?>
