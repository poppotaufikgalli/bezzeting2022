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
                                    <div class="row mb-2">
                                        <label class="form-control-label col-2">OPD</label>
                                        <div class="col-10">
                                            <input type="search" class="form-control" value="<?=isset($selnunker)? $selnunker : "" ?>" id="opd" name="opd" list="lsopd">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?Php 
                            if(isset($selopd) && count($selopd) >0){
                        ?>
                        <div class="col-lg-9 mb-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="m-0 font-weight-bold text-primary"><?=$selnunker?></h6>
                                        <h6 class="m-0 font-weight-bold text-primary align-self-center">
                                            <input type="checkbox" id="ynama" name="ynama" checked>
                                            <label for="ynama" class="mb-0">Tampil Nama</label>
                                        </h6>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover table-sm table-bordered">
                                        <thead class="table-dark text-center">
                                            <tr>
                                                <th width="5%">&nbsp;</th>
                                                <th width="5%">&nbsp;</th>
                                                <th width="80%">Struktur / Jabatan</th>
                                                <th width="10%">Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $jmlfung = 0;
                                                foreach ($selopd as $key => $value) {
                                                    $offset = (20* $value->levelunker) . "px";
                                                    //$colspan = 5 - $offset;
                                                    //echo "<tr>";
                                                    //for ($i=1; $i < $offset  ; $i++) { 
                                                    //    echo "<td>&nbsp;</td>";
                                                    //}
                                                    $kunker = $value->kunker;
                                                    echo "<tr>";
                                                    echo "<td class='text-center'><button class='btn btn-sm btn-circle btn-info' data-toggle='modal' data-target='#FungsionalModal' data-kunker='$kunker' role='button'>+</button></td>";
                                                    echo "<td>&nbsp;</td>";
                                                    echo "<td style='padding-left: $offset'>";
                                                    echo "<b>$value->nunker</b>";
                                                    echo "</td>";
                                                    echo "<td></td>";
                                                    echo "</tr>";

                                                    if(isset($selRefBazFung[$kunker]) && count($selRefBazFung[$kunker]) > 0){
                                                        $BazFung = $selRefBazFung[$kunker];    
                                                        //$offset = (20* ($value->levelunker+1)) . "px";
                                                        //echo "<tr><td>&nbsp;</td><td>&nbsp;</td><th class='bg-gray-300' style='padding-left: $offset;'>Fungsional Tertentu</th><td>&nbsp;</td></tr>";
                                                        foreach ($BazFung as $key => $value) {
                                                            echo "<tr>";
                                                            echo "<td>&nbsp;</td>";
                                                            echo "<td class='text-center'><button class='btn btn-sm btn-circle btn-danger' onclick='hapus(`$value->kunker`, `$value->kjabfung`)'>x</button></td>";
                                                            echo "<td style='padding-left: $offset;'>&#8627;&nbsp;";
                                                            echo "<i>$value->jabfung</i>";
                                                            echo $value->jenisjab == 2 ? " (JFT)" : " (JFU)";
                                                            echo "</td>";
                                                            echo "<td class='text-center'>$value->jml</td>";
                                                            echo "</tr>";
                                                            $jmlfung = $jmlfung + $value->jml;
                                                            //list orang
                                                            $idxfung = $value->jenisjab == 2 ? "tertentu" : "umum";
                                                            $kjabfung = $value->kjabfung;

                                                            if(isset($lspnsfung[$idxfung][$kunker][$kjabfung]) && count($lspnsfung[$idxfung][$kunker][$kjabfung])> 0){
                                                                echo "<tr class='trNama'>";
                                                                echo "<td>&nbsp;</td>";
                                                                echo "<td>&nbsp;</td>";
                                                                echo "<td style='padding-left: $offset; padding-bottom: 1px'>";
                                                                $dtlspnsfung = $lspnsfung[$idxfung][$kunker][$kjabfung];
                                                                foreach ($dtlspnsfung as $key1 => $value1) {
                                                                    echo "✅ ".$value1->nama." (".$value1->ngolru.")<br>";
                                                                }
                                                                echo "</td>";
                                                                echo "<td></td>";
                                                                echo "</tr>";
                                                            }
                                                        }    
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot class="table-dark text-center">
                                            <tr>
                                                <th colspan="3">Jumlah</th>
                                                <th><?=$jmlfung?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Jabatan Fungsional</h6>
                                </div>
                                <div class="card-body small">
                                    <div class="row mb-2">
                                        <b class="mb-2">Fungsional Tertentu</b>
                                        <table class="table table-hover table-sm table-bordered">
                                            <thead class="table-dark text-center">
                                                <tr>
                                                    <th>Struktur / Jabatan</th>
                                                    <th width="15%">Butuh</th>
                                                    <th width="15%">Ada</th>
                                                    <th width="15%">Kurang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $jml1 = 0;
                                                    $jml2 = 0;
                                                    if(isset($sellspns) && count($sellspns) > 0){
                                                        foreach ($sellspns as $key => $value) {
                                                            if($value['jenisjab'] == 2){
                                                                $kjab = $value['kjab'];
                                                                $njab = $value['njab'];
                                                                $jenisjab = $value['jenisjab'];
                                                                $butuh = $value['butuh'];
                                                                $ada = $value['ada'];
                                                                $kurang = $butuh - $ada;

                                                                if($kurang < 0){
                                                                    echo "<tr class='text-danger'>";
                                                                }else{
                                                                    echo "<tr>";
                                                                }

                                                                echo "<td>$njab</td>";
                                                                echo "<td class='text-center'>$butuh</td>";
                                                                echo "<td class='text-center'>";
                                                                if($ada > 0){
                                                                    echo "<u><a href='".base_url('pejabat')."/$kjab/$jenisjab/$selkdkomp'>$ada</a></u>";    
                                                                }else{
                                                                    echo $ada;
                                                                }
                                                                echo "</td>";
                                                                $jml1 = $jml1 + $butuh;
                                                                $jml2 = $jml2 + $ada;
                                                                if($kurang < 0){
                                                                    echo "<td class='text-center'>($kurang)</td>";
                                                                }else{
                                                                    echo "<td class='text-center'>$kurang</td>";
                                                                }
                                                                echo "</tr>";
                                                            }
                                                        }    
                                                    }
                                                    
                                                    //if(isset($selBazFung[]))
                                                ?>
                                            </tbody>
                                            <tfoot class="table-dark text-center">
                                                <tr>
                                                    <th>Jumlah</th>
                                                    <th><?=$jml1?></th>
                                                    <th><?=$jml2?></th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="row mb-2">
                                        <b class="mb-2">Fungsional Umum</b>
                                        <table class="table table-hover table-sm table-bordered">
                                            <thead class="table-dark text-center">
                                                <tr>
                                                    <th>Struktur / Jabatan</th>
                                                    <th width="15%">Butuh</th>
                                                    <th width="15%">Ada</th>
                                                    <th width="15%">Kurang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $jml1 = 0;
                                                    $jml2 = 0;
                                                    if(isset($sellspns) && count($sellspns) > 0){
                                                        foreach ($sellspns as $key => $value) {
                                                            if($value['jenisjab'] == 4){
                                                                $kjab = $value['kjab'];
                                                                $njab = $value['njab'];
                                                                $jenisjab = $value['jenisjab'];
                                                                $butuh = $value['butuh'];
                                                                $ada = $value['ada'];
                                                                $kurang = $butuh - $ada;

                                                                if($kurang < 0){
                                                                    echo "<tr class='text-danger'>";
                                                                }else{
                                                                    echo "<tr>";
                                                                }

                                                                echo "<td>$njab</td>";
                                                                echo "<td class='text-center'>$butuh</td>";
                                                                echo "<td class='text-center'>";
                                                                if($ada > 0){
                                                                    echo "<u><a href='".base_url('pejabat')."/$kjab/$jenisjab/$selkdkomp'>$ada</a></u>";    
                                                                }else{
                                                                    echo $ada;
                                                                }
                                                                echo "</td>";
                                                                $jml1 = $jml1 + $butuh;
                                                                $jml2 = $jml2 + $ada;
                                                                if($kurang < 0){
                                                                    echo "<td class='text-center'>($kurang)</td>";
                                                                }else{
                                                                    echo "<td class='text-center'>$kurang</td>";
                                                                }
                                                                echo "</tr>";
                                                            }
                                                        }    
                                                    }
                                                    
                                                    //if(isset($selBazFung[]))
                                                ?>
                                            </tbody>
                                            <tfoot class="table-dark text-center">
                                                <tr>
                                                    <th>Jumlah</th>
                                                    <th><?=$jml1?></th>
                                                    <th><?=$jml2?></th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?Php 
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

            <!-- Fungsional Modal-->
            <div class="modal fade" id="FungsionalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form id="formFungsional" method="POST" action="<?=base_url('simpan/fungsional')?>" class="needs-validation" novalidate>
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Formasi Fungsional</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="form-group col-md-9">
                                        <label for="jenisjab">Jenis Fungsional</label>
                                        <select class="form-control" id="jenisjab" name="jenisjab">
                                            <option value="2">Fungsional Tertentu</option>
                                            <option value="4">Fungsional Umum</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="jabfung">Jabatan Fungsional</label>
                                        <input type="text" class="form-control" id="jabfung" name="jabfung" list="lsjabfung2" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="jml">Jumlah Formasi</label>
                                        <input type="number" class="form-control" id="jml" name="jml" min="1" required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <input type="hidden" id="idx_opd" name="idx_opd" required>
                                        <input type="hidden" id="kjabfung" name="kjabfung" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary" id="btnSimpan">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

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
                window.location.href = "<?=base_url('formasi')?>/"+idx;
            }
        })
    });

    $("#jenisjab").on('change', function(){
        var val = $(this).val()
        $("#jabfung").val("");
        $("#kjabfung").val("");
        $("#jabfung").attr('list', 'lsjabfung'+val);
    });

    $("#jabfung").on('input', function(){
        var userText = this.value;
        var jenisjab = $("#jenisjab").val()
        $("#lsjabfung"+jenisjab).find("option").each(function() {
            if ($(this).val() == userText) {
                var idx = $(this).data('idx');
                $("#kjabfung").val(idx)
            }
        })
    })

    $('#FungsionalModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('kunker') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        //modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('.modal-body input#idx_opd').val("")
        modal.find('.modal-body input#jabfung').val("")
        modal.find('.modal-body input#kjabfung').val("")
        modal.find('.modal-body input#jml').val("")
        modal.find('.modal-body input#idx_opd').val(recipient)
    });

    function hapus(kunker, kjabfung) {
        var ds = confirm("Apakah anda yakin menghapus data ini?")
        if(ds == true){
            window.location.href = "<?=base_url('hapus/fungsional/')?>/"+kunker+"/"+kjabfung;
        }
    }

    $("#ynama").on('change', function(){
        if ($(this).prop("checked")) {
            $(".trNama").removeClass('d-none');
        }else{
            $(".trNama").removeClass('d-none').addClass('d-none')
        }
    });

    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
</script>