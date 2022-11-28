<body class="login-page vertical-center" style="margin-top: -50px">
    <div class="login-box">
        <div class="card">
            <div class="body">
                <form id="sign-in-form">
                    <div class="msg">
                        <a href="javascript:void(0);">
                            <img style="border-radius: 50px" src="<?= base_url("assets/vendors/images/user.png") ?>" width="80" height="80" alt="User" />
                        </a>
                    </div>
                    <div class="msg">Enter password to continue session.</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <label class="error"></label>
                        
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="button" onclick="">CONTINUE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>