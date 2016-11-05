<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">ログイン情報入力</h3>
                </div>
                <div class="panel-body">
                    <?php 
                        if (isset($error_message))
                        {
                            echo '<div class="alert alert-danger">';
                            echo $error_message;
                            echo '</div>';   
                        }
                    ?>
                    <form role="form" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="ユーザー名" name="username" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="パスワード" name="password" type="password" value="">
                            </div>
                            <input type="submit" value="ログイン" class="btn btn-lg btn-success btn-block"/>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>