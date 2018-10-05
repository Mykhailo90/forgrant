<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Forgrant</title>
    <style>
      .header{
        text-align: center;
      }
      .dropdown-menu{
        border: none;
      }
      #main_btn{
        margin-bottom: 30px;
      }
      table, tr{
        width: 100%;
      }
      .r{
        text-align: right;
      }
      #label_radio1{
        margin-right: 30px;
      }

    </style>
  </head>
  <body>
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


    <!-- ************************************************************** -->





  </div>
  <script>

      function ajax_send_info(data){
        var request = new XMLHttpRequest();
        request.open('POST', '/', true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send(data);
        request.onreadystatechange = function (e) {
         if(request.readyState == 4 && request.status == 200) {
           var res = request.responseText;
           alert("Данные отправлены на сервер!");
         }
        }
      }
  // Передача параметров товара в модальное окно
    function add_head(){
      $('#exampleModal').on('show.bs.modal', function (event) {
       var button = $(event.relatedTarget);
       var recipient = button.data('id');
       var modal = $(this);
      modal.find('.modal-body #position_id').val(recipient);
      });
    }

    function change_price(e){
      // Проверить, что поле to_date должно быть больше или равно полю from_date
      var ch_btn = document.querySelector('#ch_btn');
      var pos_id = document.querySelector('#position_id').value;
      var price = document.querySelector('#price').value;
      var from_date = document.querySelector('#from_date').value;
      var to_date = document.querySelector('#to_date').value;
      if (to_date != "" && from_date != "" && from_date > to_date){
        alert ("Некорректный ввод сроков действия стоимости продукции");
        ch_btn.removeAttribute('data-dismiss');
      }
      else{
        if (!ch_btn.hasAttribute('data-dismiss')){
          ch_btn.setAttribute('data-dismiss', 'modal')
        }
        
        var type_price = '';
        var radio = document.querySelectorAll('#radio1');
        for(var i = 0; i < radio.length; i++){
          if(radio[i].checked)
          type_price = radio[i].value;
        }
        ajax_send_info('price=' + price +
                        '&from_date=' + from_date +
                        '&to_date=' + to_date +
                        '&type_price=' + type_price +
                        '&position_id=' + pos_id);

      }
      
    };


    function get_category_info(data_send) {
      var request = new XMLHttpRequest();
     request.open('POST', '/', true);
     request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
     request.send(data_send);
     var data = "";
     request.onreadystatechange = function (e) {
         if(request.readyState == 4 && request.status == 200) {
           var res = request.responseText;
           var show_area = document.querySelector('.show');
           show_area.innerHTML = '';
           data = JSON.parse(res);
           for (var i = 0; i < data.products.length; i++) {
             var div = document.createElement("div");
             div.className = "alert alert-primary products";
             div.innerHTML =  '<table>' +
                                '<tr>' +
                                  '<td><strong>' + data.products[i]['name_position'] + '<strong></td>' +
                                  '<td>2000 руб</td>' +
                                  '<td class="r"> <div class="btn btn-danger btn-lg product_item" data-toggle="modal" data-target="#exampleModal" data-id="' + data.products[i]['id'] + '">Управлние ценой</div></td>' +
                                '</tr>' +
                              '</table>';
             show_area.appendChild(div);
           }
           add_head();
         };
       }
}

    window.onload = function(){
      var main_btn = document.querySelector('#main_btn');
      main_btn.onclick = function(){
        var show_area = document.querySelector('.show');
        show_area.innerHTML = '';
      }


      var div_categ = document.querySelectorAll('.categ');
      for (var i = 0; i < div_categ.length; i++) {
        div_categ[i].onclick = function(e){
          var category_id = e.target.id;
          get_category_info('category_id=' + category_id);
        };
      }
    }
  </script>
  </body>
</html>
