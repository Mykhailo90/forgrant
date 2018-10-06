function ajax_get_all_prices(data){
  var request = new XMLHttpRequest();
  request.open('POST', '/', true);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send(data);
  request.onreadystatechange = function (e) {
   if(request.readyState == 4 && request.status == 200) {
     var res = request.responseText;
     data = JSON.parse(res);
    
     var arg_time = data.day;     
     var arg_first_type_price = data.arg1;
     var arg_second_type_price = data.arg2;

     var chart_div = document.querySelector('.show_charts');
     chart_div.innerHTML = '<canvas id="myChart" width="400" height="400"></canvas>';
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: arg_time,
        datasets: [{
            label: 'First type',
            data: arg_first_type_price,
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 1
        },
      {
        label: 'Second type',
        data: arg_second_type_price,
        backgroundColor: [
            'rgba(123, 19, 25, 0.2)'
        ],
        borderColor: [
            
            'rgba(15, 65, 200, 1)'
        
        ],
        borderWidth: 1
      }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
   }
  }
}

/**
 * 
 * This function get parameters for ajax request to charts
 */

function show_charts(){
  var pos_id = document.querySelector('#pos_id').value;
  var from_date = document.querySelector('#from').value;
  var to_date = document.querySelector('#to').value;

  if (from_date == "" || to_date == "" || from_date > to_date){
    alert("Период задан некорректно!");
  }
  else{
    ajax_get_all_prices('id=' + pos_id +
                        '&from=' + from_date +
                        '&to=' + to_date +
                        '&chart=1');

  }
  
}

/**
 * 
 * This function get parameters from change_price_form
 * and send on MainController
 */

function ajax_send_info(data){
  var request = new XMLHttpRequest();
  request.open('POST', '/', true);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send(data);
  request.onreadystatechange = function (e) {
   if(request.readyState == 4 && request.status == 200) {
     var res = request.responseText;
     console.log(res);
     alert("Данные отправлены на сервер!");
     window.location.reload();
   }
  }
}

/**
 * 
 * This function  send id category in the modal window
 */

function add_head(){
  $('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var recipient = button.data('id');
    var modal = $(this);
    modal.find('.modal-body #position_id').val(recipient);
  });

  $('#chartsModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var recipient = button.data('id');
    var modal = $(this);
    modal.find('.modal-body #pos_id').val(recipient);
  });
}

/**
 * 
 * This function  check user input and change default behavior
 */

function change_price(e){
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


/**
 * 
 * This function  get info about products in category
 * and show all info into table
 */


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
                            '<td><strong data-toggle="modal" data-target="#chartsModal" data-id="'+ data.products[i]['id'] +'"><a href="#" class="my_link link">' + data.products[i]['name_position'] + '</a><strong></td>' +
                            '<td>' + data.products[i]['price'] + ' руб</td>' +
                            '<td class="r">' + data.products[i]['name'] + '</td>' +
                            '<td class="r"> <div class="btn btn-danger btn-lg product_item" data-toggle="modal" data-target="#exampleModal" data-id="' + data.products[i]['id'] + '">Управлние ценой</div></td>' +
                          '</tr>' +
                        '</table>';
       show_area.appendChild(div);
     }
     add_head();
   };
 }
}

/**
 * 
 * This function  set fields for display price
 * and set activity
 */

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