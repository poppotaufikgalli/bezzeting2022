<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">
            
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block">
                                <div class="d-flex align-items-center">
                                    <img src="<?=base_url('asset/img/logo_tpi.png')?>" class="p-2 mx-auto">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bezzeting Fungsional<br>Kota Tanjungpinang @ 2022</h1>
                                    </div>
                                    <?php if(session()->getFlashdata('msg')):?>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <i class="small"><?= session()->getFlashdata('msg') ?></i>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php endif;?>
                                    <form class="user" method="POST" action="<?=base_url('auth')?>">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="uname" name="uname" aria-describedby="usernameHelp" placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="pass" name="pass" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>