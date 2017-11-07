$(document).ready(function(){
    startLoadingAnimation();
    $('#tbody').load(
           '/currency/GetListData',
            {offset: 0},
           function(){
                $("td").dblclick(function () {
                
                    var row = $(this).parent().index() + 1;
                    var id = $('table tr:nth-child(' + row + ')').find('td:nth-child(1)').html();
                
                    AddNew(id);
                }); 
                stopLoadingAnimation();
           });   
});


function getData(){
    startLoadingAnimation();
    getAjax();  
}
function getAjax(id =''){
        
        var request = $.ajax({
            method: "POST",
            url: "/Currency/GetListData",
			
            success: function(data){
                      
                $('#tbody').html(data);
                stopLoadingAnimation(); 
					   $("td").dblclick(function(){
						   //console.log('test');
						   var row = $(this).parent().index() + 1;
						   var id = $('table tr:nth-child(' + row + ')').find('td:nth-child(1)').html();
						   console.log(id);
						   AddNew(id);
					   });
                    },
            error: function(xhr, desc, err){
                       console.log('test');
                    }
        });
        
    }

function td_dbl_click(){
	
}	
 
function AddNew(id){
	
	if(id === ''){
		data = {};	
	}
	else{
		data = {id: id};
	}
	
    $.ajax({
            method: "POST",
            url: '/Currency/GetElement',
            data: data,
            success: function(data){
                //console.log(data) ;      
                $('#frame').html(data);
                $("#form_element").submit(function(event){
					var dataForm = $(this).serializeArray();
					saveElement(dataForm) ;
					event.preventDefault();						
                });
                    },
            error: function(xhr, desc, err){
                        console.log(err);
                    }
        });    
}

function saveElement(dataForm){

	console.log(dataForm);
	
	$.ajax({
			type: "POST",
			url: "/Currency/SaveElement",
			data: dataForm,
			success: function(response){
				console.log(response);
                                return false;	
                            //location.reload();
			},
			error: function(jqXHR, textStatus, errorThrown ){
				console.log(textStatus);
			}
		});	
	
}

function startLoadingAnimation() // - функция запуска анимации
{
  // найдем элемент с изображением загрузки и уберем невидимость:
  var imgObj = $("#loadImg");
  imgObj.show();
 
  // вычислим в какие координаты нужно поместить изображение загрузки,
  // чтобы оно оказалось в серидине страницы:
  var pos = $("#form").offset();
  var pos_tbody = $("tbody").offset();
  var centerY = pos_tbody.top + $("#form").height()/2;
  var centerX = (pos.left + $("#form").width()) / 2;
 
  // поменяем координаты изображения на нужные:
  imgObj.offset({top:centerY, left:centerX});
}
 
function stopLoadingAnimation() // - функция останавливающая анимацию
{
  $("#loadImg").hide();
}