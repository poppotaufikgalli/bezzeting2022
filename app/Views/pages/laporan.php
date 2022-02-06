<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?=$sidebar?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?=$topbar?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?=$title?></h1>

                    <div class="row">
                        <div class="col-lg-12 mb-12">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="row mb-2 d-none">
                                        <label class="form-control-label col-2">Semua OPD</label>
                                        <div class="col-10">
                                             <a href="<?=base_url('downloadExcel')?>" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-file-excel fa-sm text-white-50"></i> Generate Report</a>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="form-control-label col-2">OPD</label>
                                        <div class="col-8">
                                            <input type="search" class="form-control" value="<?=isset($selnunker)? $selnunker : "" ?>" id="opd" name="opd" list="lsopd">
                                        </div>
                                        <div class="col-2">
                                             <button id="btnReport" data-idx="" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-file-excel fa-sm text-white-50"></i> Generate Report</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?=$copyright?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

        <datalist id="lsopd">
            <?Php 
                if(isset($opd) && count($opd)> 0){
                    foreach ($opd as $key => $value) {
                        echo "<option data-idx='$value->kkomp' value='$value->nkomp'>"; 
                    }
                }
            ?>
        </datalist>

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</body>

<script type="text/javascript">
    $("#opd").on('input', function(){
        var userText = this.value;
        $("#lsopd").find("option").each(function() {
            if ($(this).val() == userText) {
                var idx = $(this).data('idx');

                $("#btnReport").data("idx", idx)
            }
        })
    });

    $("#btnReport").on('click', function(){
        var idx = $(this).data('idx');
        if(idx == ''){
            alert("Anda belum memilih OPD");    
        }else{
            window.location.href = "<?=base_url('downloadExcel')?>/"+idx;
        }
        
    })
</script>