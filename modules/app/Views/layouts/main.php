<!DOCTYPE html>
<html lang="en" style="height: 100%">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="ccsrf_token" content= "<?= $_SESSION['csrf_token'] ?>">
    <!--<meta http-equiv="Cache-Control" content="no-cache"><meta http-equiv="Cache-Control" content="no-cache">-->
    <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="/public/bootstrap/css/jasny-bootstrap.min.css">
   <link rel="stylesheet" href="/public/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="/public/css/pf.css">
   <link href="/public/bootstrap/navmenu.css" rel="stylesheet">
   <link href="/public/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet" />
    
    

      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    
  </head>
  <body style="height: 100%">
	 <div class="navmenu navmenu-default navmenu-fixed-left offcanvas-sm">
      <a class="navmenu-brand visible-md visible-lg" style="font-style:oblique; color: #f7f7f7;" href="/site/index">Project name</a>

      <ul class="nav navmenu-nav">
        <li><a href="/site/index" class="navtext" style= "color: #f7f7f7;">Home</a></li>
        <li><a href="#" class="navtext" style= "color: #f7f7f7;">Transactions</a></li>
        <li><a href="/site/settings" class="navtext" style= "color: #f7f7f7;">Settings</a></li>
        <li><a href="/user/logout" class="navtext" style= "color: #f7f7f7;">Logout</a></li>
      </ul>
    </div>

    <div class="navbar navbar-default navbar-fixed-top hidden-md hidden-lg">
      <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target=".navmenu">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand navtext" href="/site/index">Project name</a>
    </div>

    <div class="container">
      {% block content %}{% endblock %}
      </div><!-- /.container -->
	
    <!--<script src="https://code.jquery.com/jquery.js"></script>-->
    <script src="/public/js/jquery/jquery-3.2.1.min.js"></script>
    <script src="/public/bootstrap/js/bootstrap.min.js"></script>
    <script src="/public/bootstrap/js/jasny-bootstrap.min.js"></script>
    <script src="/public/bootstrap-fileinput/js/fileinput.min.js"></script>
    
    <script>
$(document).on("ready", function() {
    $("#file").fileinput({
        uploadUrl: "/tools/getfiles1c",
        uploadAsync: false,
        showPreview: false,
        allowedFileExtensions: ['json'],
        maxFileCount: 15,
        elErrorContainer: '#kv-error-2'
    }).on('filebatchpreupload', function(event, data, id, index) {
        $('#kv-success-2').html('<h4>Upload Status</h4><ul></ul>').hide();
    }).on('filebatchuploadsuccess', function(event, data) {
        var out = '';
        $.each(data.files, function(key, file) {
            var fname = file.name;
            out = out + '<li>' + 'Uploaded file # ' + (key + 1) + ' - '  +  fname + ' successfully.' + '</li>';
        });
        $('#kv-success-2 ul').append(out);
        $('#kv-success-2').fadeIn('slow');
    });
});
   function getAjax(){
     
        var request = $.ajax({
            method: "POST",
            url: "/Dictonaries/Currencies",
            success: function(data){
                        alert(data);
                    },
            error: function(xhr, desc, err){
                        console.log(err);
                    }
        });
        
    }
    $('#exampleModal').on('show.bs.modal', function (event) {
        var call_elem = $(event.relatedTarget);
       // var data = call_elem.data('content'); 
       // var short_name = 'THB'; // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        //modal.find('.Short_Name input').val(short_name);
        //modal.find('.code input').val(short_name)
    });
    
    $("td").on("dblclick", function(){
        var row = $(this).parent().index() + 1;
        var id = $('table tr:nth-child(' + row + ')').find('td:nth-child(1)').html();
        //var code = $('table tr:nth-child(' + row + ')').find('td:nth-child(2)').html();
       // var name = $('table tr:nth-child(' + row + ')').find('td:nth-child(3)').html();
        //var short_name = $('table tr:nth-child(' + row + ')').find('td:nth-child(4)').html();
        
        $.ajax({
            method: "POST",
            url: "/Dictonaries/Currencies",
            data:{'id':id },
            success: function(data){
                var elem = data; 
                console.log(elem);
                $("#ajax_result").html(elem);
                
//var elem = JSON.parse(data);
                        //var obj = elem[0];
                        //$("#id").val(obj['id']);                
                        //$("#Code").val(obj['code']);
                        //$("#Name").val(obj['name']);
                        //$("#Short_Name").val(obj['short_name']);
  
                        $('#exampleModal').modal();
                    },
            error: function(xhr, desc, err){
                        console.log(err);
                    }
        });
        //console.log(data);
        
        
            
    });
    
    function getNewElement(){
        var id = '';
        //var code = $('table tr:nth-child(' + row + ')').find('td:nth-child(2)').html();
       // var name = $('table tr:nth-child(' + row + ')').find('td:nth-child(3)').html();
        //var short_name = $('table tr:nth-child(' + row + ')').find('td:nth-child(4)').html();
        
        $.ajax({
            method: "POST",
            url: "/Dictonaries/getNewCurrencyForm",
            data:{'id':id },
            success: function(data){
                var elem = data; 
                console.log(elem);
                $("#ajax_result").html(elem);
                
//var elem = JSON.parse(data);
                        //var obj = elem[0];
                        //$("#id").val(obj['id']);                
                        //$("#Code").val(obj['code']);
                        //$("#Name").val(obj['name']);
                        //$("#Short_Name").val(obj['short_name']);
  
                        $('#exampleModal').modal();
                    },
            error: function(xhr, desc, err){
                        console.log(err);
                    }
        });    
    }
    </script>
    
    
  </body>
  
</html>