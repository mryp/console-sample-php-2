<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				ユーザー情報
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
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
							echo Form::label('ユーザー名');
							echo '<p class="form-control-static">'.$username.'</p>';
							echo '</div>';

							echo '<div class="form-group">';
							echo Form::label('メールアドレス');
							echo Form::input('email', $email, array('class' => 'form-control', 'placeholder' => 'メールアドレス'));
							echo '</div>';

							echo '<div class="form-group">';
							echo Form::label('権限グループ');
							echo '<p class="form-control-static">'.$groupname.'</p>';
							echo '</div>';

							echo Form::submit('passwordcnf', "更新する", array('class' => 'btn btn-primary'));
							echo Form::close();
						?>
					</div><!-- /.col-lg-6 (nested) -->
				</div><!-- /.row (nested) -->
			</div><!-- /.panel-body -->
		</div><!-- /.panel -->
	</div><!-- /.col-lg-12 -->
</div><!-- /.row -->
