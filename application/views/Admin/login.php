<!doctype html>
<html lang="en">
    <head>        
        <meta charset="utf-8" />
        <title>Login | <?=SITE_NAME;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="<?=SITE_NAME;?>" name="description" />
        <meta content="Third Law Media" name="Third Law Media" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?=base_url().SITE_FAV;?>">
        <!-- Bootstrap Css -->
        <link href="<?=base_url('assets/backend');?>/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?=base_url('assets/backend');?>/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?=base_url('assets/backend');?>/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Welcome Back !</h5>
                                            <img src="<?=base_url().SITE_LOGO;?>" alt="" class="img fluid" height="34">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-2">
                                    <?=notification_message();?>
                                    <?=form_open('admin-login',['method'=>'POST','class'=>'form-horizontal']); ?>
                                        <div class="mb-3">
                                            <label>Username</label>
                                            <input type="text" name="username" class="form-control" placeholder="Enter username">
                                        </div>                
                                        <div class="mb-3">
                                            <label>Password</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" name="password" class="form-control" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                                                <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                        </div>                                        
                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                                        </div>
                                    <?=form_close();?>
                                </div>            
                            </div>
                        </div>
                        <div class="mt-5 text-center">                            
                            <div>
                                <p>© <?=date('Y');?> <?=SITE_NAME;?>. Crafted with <i class="mdi mdi-heart text-danger"></i> </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->
        <!-- JAVASCRIPT -->
        <script src="<?=base_url('assets/backend');?>/libs/jquery/jquery.min.js"></script>
        <script src="<?=base_url('assets/backend');?>/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?=base_url('assets/backend');?>/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?=base_url('assets/backend');?>/libs/simplebar/simplebar.min.js"></script>
        <script src="<?=base_url('assets/backend');?>/libs/node-waves/waves.min.js"></script>   
        <!-- App js -->
        <script src="<?=base_url('assets/backend');?>/js/app.js"></script>
    </body>
</html>
