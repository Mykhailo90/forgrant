<link rel="stylesheet" href="./public/styles/main/main.css">
<div class="container">
    <div class="header">
      <h1>Test page</h1>
    </div>

    <div class="btn-group dropright">
      <button id="main_btn" type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <strong>Категории</strong>
      </button>
      <div class="dropdown-menu">
        <?php foreach($categories as $key => $val): ?>
          <div class="btn btn-secondary btn-lg btn-block categ" id="<?php echo $val['id']; ?>">
            <?php echo $val['name']; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="show">
    </div>



    <!-- ********************************* -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Управление ценой</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="price_form" action="/" enctype="multipart/form-data" method="POST">
      <div class="modal-body">

      <input id="position_id" type="hidden" name="title" value="">
        
      <div class="form-group">
            <label for="price">Цена:</label>
            <input type="number" min="0.00" step="0.01" class="form-control" id="price" name="price" value="">  
          </div>

          <div class="form-group">
            <label for="from_date">Начало действия цены:</label>
            <input type="date" class="form-control" id="from_date" name="from_date" max="2038-01-18" min="<?php echo date("Y-m-d");?>">
          </div>

          <div class="form-group">
            <label for="to_date">Последний день действия цены:</label>
            <input type="date" class="form-control" id="to_date" name="to_date" min="<?php echo date("Y-m-d");?>" max="2038-01-18">
          </div>
          <div>
          <label for="type">Тип ценообразования: </label>
          </div>
          
            <div class="form-check-inline">
              <label class="form-check-label" for="radio1" id="label_radio1">
                <input type="radio" class="form-check-input" id="radio1" name="type_price" value="1" checked>Приоритет последней стоимости
              </label>
              <label class="form-check-label" for="radio1">
                <input type="radio" class="form-check-input" id="radio1" name="type_price" value="2" >Приоритет наименьшего временного периода
              </label>
            </div>
      </div>
      <div class="modal-footer">
        <button id="ch_btn" type="button" class="btn btn-success btn-lg btn-block" data-dismiss="modal" onclick="change_price();">Внести изменения</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
<script src="./public/js/main/main.js"></script>