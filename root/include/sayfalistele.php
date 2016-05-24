<section class="content-header">
  <h1>
    <i class="fa fa-file"></i> Sayfa İşlemleri
  </h1>
</section>
<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-xs-12 user-add">
      <h3>
        <span class="label label-success"><a href="main.php?sayfa=sayfaekle"><i class="fa fa-file"></i>Sayfa Ekle</a></span>
      </h3>
    </div>
    <div class="col-xs-12">

      <div class="box">
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>&nbsp;</th>
                <th>Sayfa Adı</th>
                <th>Sayfa Yazarı</th>
                <th>Sayfa Güncelleme Tarihi</th>
                <th>İşlemler</th>
              </tr>
            </thead>
            <tbody>
              <?php
              sayfalistele($db);
              ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->




<?php require_once("include/footerinc.php");?>


<script>
$(function () {
  $("#example1").DataTable({
    "order":[[3,"desc"]]
  });
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false
  });
});
</script>
<script language="javascript">
function confirmDel() {
 var agree=confirm("Bu içeriği silmek istediğinizden emin misiniz?\nBu işlem geri alınamaz!");
 if (agree) {
  return true ; }
 else {
  return false ;}
}
</script>
