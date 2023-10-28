<style type="text/css">
  .table-detail thead th,
  .table-detail2 thead th,
  .total {
    background: #3169c6;
    color: #ffffff;
    text-align: center;
    color: white;
  }
  .table-detail, 
  .table-detail>thead>tr>th, 
  .table-detail>tbody>tr>td,
  .table-detail2, 
  .table-detail2>thead>tr>th, 
  .table-detail2>tbody>tr>td {
    border-color: #3169c6 !important;
    padding: 2px 0px !important;
  }
  .table-detail > tbody > tr > td, .table-detail > thead > tr > th,
  .table-detail2 > tbody > tr > td, .table-detail2 > thead > tr > th { 
    word-break: break-all; 
    white-space: nowrap; 
    font-size: 12px;
  } 
</style>

<div style="overflow-x: auto;">
  <table class="table table-bordered table-detail table-responsive">
    <thead>
      <tr>
        <th>MinStock</th>
        <th>MaxStock</th>
        <th>BalanceQty</th>
        <th>SO-Pending</th>
        <th>Raw-Pending</th>
        <th>QtyReady</th>
        <th>MUATATION-Pending</th>
        <th>RO-Pending</th>
        <th>PO-Pending</th>
        <th>NetQty</th>
        <th>ProductRequest</th>
        <th>RO-QtySugestion</th>
      </tr>
    </thead>
    <tbody>
      <tr class=" alignCenter">
        <td><?php echo $content['MinStock'] ;?></td>
        <td><?php echo $content['MaxStock'] ;?></td>
        <td><?php echo $content['stock'] ;?></td>
        <td><?php echo $content['sopending'] ;?></td>
        <td><?php echo $content['rawpending'] ;?></td>
        <td><?php echo $content['qtyready'] ;?></td>
        <td><?php echo $content['mutationpending'] ;?></td>
        <td><?php echo $content['ropending'] ;?></td>
        <td><?php echo $content['sopending'] ;?></td>
        <td><?php echo $content['QtyNet'] ;?></td>
        <td><?php echo $content['productrequest'] ;?></td>
        <td><?php echo $content['rosuggestion'] ;?></td>
      </tr>
    </tbody>
  </table>
</div>