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
                    <h1 class="h3 mb-4 text-gray-800">Pejabat Fungsional</h1>

                    <div class="row">
                        <div class="col-lg-12 mb-12">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <label class="form-control-label col-2">Jenis Fungsional</label>
                                        <div class="col-10">
                                            <select class="form-control" id="jenisjab" name="jenisjab">
                                                <option value="2" <?=$jenisjab == 2 ? "selected" : ""?>>Fungsional Tertentu</option>
                                                <option value="4" <?=$jenisjab == 4 ? "selected" : ""?>>Fungsional Umum</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="form-control-label col-2">Jabatan Fungsional</label>
                                        <div class="col-10">
                                            <input type="search" class="form-control" value="<?=isset($seljabfung)? $seljabfung : "" ?>" id="jabfung" name="jabfung" list="lsjabfung2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?Php 
                            if(isset($lspns) && count($lspns) >0){
                        ?>
                        <div class="col-lg-12 mb-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><?=$seljabfung?></h6>
                                </div>
                                <div class="card-body small">
                                    <table class="table table-hover table-sm table-bordered">
                                        <thead class="table-dark text-center">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="20%">Nama / NIP / Pangkat</th>
                                                <th width="30%">Jabatan</th>
                                                <th width="30%">Unit Kerja</th>
                                                <th width="5%">Usia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                foreach ($lspns as $key => $value) {
                                                    echo "<tr>";
                                                    echo "<td class='text-center'>".($key +1)."</td>";
                                                    echo "<td>";
                                                    echo $value->namapeg."<br>";
                                                    echo $value->nip."<br>";
                                                    echo $value->ngolru."<br>";
                                                    echo "</td>";
                                                    echo "<td>$value->njab</td>";
                                                    echo "<td>$value->nunker</td>";
                                                    echo "<td>$value->usiath</td>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?Php 
                            }else{
                                if($selkjab != null){
                        ?>
                        <div class="col-lg-12 mb-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary" id="titlejabfung"></h6>
                                </div>
                                <div class="card-body">
                                    <h2 class="text-center">Data Pejabat Fungsional Tidak Ditemukan</h2>
                                </div>
                            </div>
                        </div>
                        <?Php 
                                }
                            }
                        ?>
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

    </div>
    <!-- End of Page Wrapper -->

    <datalist id="lsjabfung2">
        <?Php 
            if(isset($lsjabfung['tertentu']) && count($lsjabfung['tertentu'])> 0){
                foreach ($lsjabfung['tertentu'] as $key => $value) {
                    echo "<option data-idx='$value->kjab' value='$value->njab'>"; 
                }
            }
        ?>
    </datalist>
    <datalist id="lsjabfung4">
        <?Php 
            if(isset($lsjabfung['umum']) && count($lsjabfung['umum'])> 0){
                foreach ($lsjabfung['umum'] as $key => $value) {
                    echo "<option data-idx='$value->kjab' value='$value->njab'>"; 
                }
            }
        ?>
    </datalist>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</body>
<script type="text/javascript">
    $(document).ready(function(){
        var kjab = '<?=$selkjab?>';
        var jenisjab = '<?=$jenisjab?>';
        var njenisjab = $("#jenisjab option:selected").text();
        $("#lsjabfung"+jenisjab).find("option").each(function() {
            if ($(this).data('idx') == kjab) {
                var njab = $(this).val();
                $("#jabfung").val(njab)
                $("#titlejabfung").html(njenisjab + " - " + njab)
            }
        });
        $("#jabfung").attr('list', "lsjabfung"+jenisjab)
    });

    $("#jenisjab").on('change', function(){
        var val = $(this).val()
        $("#jabfung").val("");
        $("#jabfung").attr('list', 'lsjabfung'+val);
    });

    $("#jabfung").on('input', function(){
        var userText = this.value;
        var jenisjab = $("#jenisjab").val()
        $("#lsjabfung"+jenisjab).find("option").each(function() {
            if ($(this).val() == userText) {
                var idx = $(this).data('idx');
                console.log(idx)
                if(idx != ""){
                    window.location.href = "<?=base_url('pejabat')?>/"+idx+"/"+jenisjab;    
                }
            }
        })
    })
</script>